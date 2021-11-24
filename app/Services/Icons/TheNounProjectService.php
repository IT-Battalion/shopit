<?php

namespace App\Services\Icons;

use App\Exceptions\IconNotFoundException;
use App\Exceptions\IconSaveException;
use App\Exceptions\MalformedIconDataException;
use App\Models\Icon;
use App\Services\Icons\NounProjectApi\ApiClient;
use App\Services\Icons\NounProjectApi\ApiIcon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Storage;

/**
 * An Icon Service Implementation for the Noun Projects Icon API.
 * TODO: handle adding for existing Icons
 */
class TheNounProjectService implements IconServiceInterface
{

    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Searches for multiple icons
     * @param string $iconName the name to search for
     * @param int|null $offset the offset from the first icon (how many icons shall be skipped)
     * @param int|null $page the page of the results ($page * $limit = $offset)
     * @param int|null $limit the limit of icons on one page
     * @param array $options Additional options
     * @return ApiIcon[] the icons that have been found
     */

    public function findByName(
        string $iconName,
        int    $offset = null,
        int    $page = null,
        int    $limit = null,
        array  $options = []): array
    {
        $entries = $this->findByNameInDatabase($iconName, $offset, $page, $limit);

        if (empty($entries))
        {
            $entries = $this->findByNameThroughApi($iconName, $offset, $page, $limit, $options);
        }

        return $entries;
    }

    public function findByNameInDatabase(
        string $iconName,
        int    $offset = null,
        int    $page = null,
        int    $limit = null) : array
    {
        if (is_null($offset))
        {
            $offset = 0;
        }

        if (is_null($page))
        {
            $page = 0;
        }

        if (is_null($limit))
        {
            $limit = config('services.nounproject.default_page_size');
        }

        $icons = Icon::whereName($iconName)
            ->offset($offset)
            ->forPage($page, $limit)
            ->get();

        return $icons->all();
    }

    public function findByNameThroughApi(
        string $iconName,
        int    $offset = null,
        int    $page = null,
        int    $limit = null,
        array  $options = []): array
    {
        if (array_key_exists('limit_to_public_domain', $options)) {
            $limit_to_public_domain = $options['limit_to_public_domain'];
        } else {
            $limit_to_public_domain = config('services.nounproject.only_public_domain');
        }

        $parameters = [
            'limit_to_public_domain' => $limit_to_public_domain ? 1 : 0,
        ];

        if ($offset) {
            $parameters = array_merge($parameters, [
                'offset' => $offset
            ]);
        }

        if ($page) {
            $parameters = array_merge($parameters, [
                'page' => $page
            ]);
        }

        if ($limit) {
            $parameters = array_merge($parameters, [
                'limit' => $limit
            ]);
        }

        $response = $this->apiClient->fetch('icons/' . $iconName, $parameters);

        if ($response->failed()) {
            switch ($response->status()) {
                case 404:
                    return [];
                default:
                    $response->throw();
            }
        }

        $data = $response->json('icons');

        return self::parseIcons($data);
    }

    /**
     * Searches for a single icon
     * @param string $id the icon name or id to search for
     * @return ApiIcon the icon data fetched from the API or false if no matching icon could be found
     * @throws IconNotFoundException
     * @throws MalformedIconDataException|RequestException
     */

    public function findById(string $id): ApiIcon
    {
        return $this->findByIdInDatabase($id) ?? $this->findByIdThroughApi($id);
    }

    public function findByIdInDatabase(string $id): ApiIcon|null
    {
        $icon = Icon::whereOriginalId($id)->first();

        if (is_null($icon))
        {
            return null;
        }

        return new ApiIcon(
            $icon->original_id,
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        );
    }

    /**
     * @throws IconNotFoundException
     * @throws RequestException
     * @throws MalformedIconDataException
     */
    public function findByIdThroughApi(string $id): ApiIcon
    {
        $response = $this->apiClient->fetch('icon/' . $id, []);

        if ($response->failed()) {
            switch ($response->status()) {
                case 404:
                    $exception = $response->toException();
                    throw new IconNotFoundException("We couldn't find any icons with the name or id \"$id\"", 0, $exception);
                default:
                    $response->throw();
            }
        }

        $data = $response->json();

        return self::parseIcon($data['icon']);
    }

    /**
     * @param array $data
     * @return ApiIcon[]
     * @throws MalformedIconDataException
     */

    public static function parseIcons(array $data): array
    {
        $icons = array_map(function ($iconData) {
            return self::parseIcon($iconData);
        }, $data);
        return array_filter($icons);
    }

    /**
     * @param array $iconData
     * @return ApiIcon|bool returns the {@link ApiIcon} generated from the $iconData or false if the icon doesn't have
     *                      a preview url
     * @throws MalformedIconDataException Gets thrown when you try to parse an icon from invalid data
     */

    public static function parseIcon(array $iconData): ApiIcon|bool
    {
        if (!array_key_exists('icon_url', $iconData)) {
            return false;
        }

        if (array_key_exists('attribution_preview_url', $iconData)) {
            $preview_url = $iconData['attribution_preview_url'];
        } else if (array_key_exists('preview_url', $iconData)) {
            $preview_url = $iconData['preview_url'];
        } else {
            throw new MalformedIconDataException('Couldn\'t create Icon from icon data
No url for an icon preview could be found
This is most likely a problem with the API of the Noun Project (It is inconsistent some times and that definitely didn\'t cost me hours🤪)');
        }

        $iconData['license'] = match ($iconData['license_description']) {
            'public-domain' => strval(ApiIcon::LICENSE_PUBLIC_DOMAIN),
            'creative-commons-attribution' => strval(ApiIcon::LICENSE_CC_BY_3_0),
            default => throw new MalformedIconDataException("No valid license detected for icon " . $iconData['name']),
        };

        return new ApiIcon(
            $iconData['id'],
            $iconData['attribution'],
            $iconData['icon_url'],
            $preview_url,
            $iconData['license'],
            $iconData['term'],
            $iconData['uploader']['name'],
            'image/svg+xml'
        );
    }

    /**
     * @throws IconSaveException
     * @throws IconNotFoundException
     * @throws RequestException
     */
    public function add(ApiIcon $apiIcon): Icon
    {
        $tmpResource = tmpfile();

        $response = $this->apiClient->downloadIcon($apiIcon, $tmpResource);

        if ($response->failed()) {
            switch ($response->status()) {
                case 404:
                    throw new IconNotFoundException('Couldn\'t download icon');
                default:
                    $response->throw();
            }
        }

        $savePath = 'icons/' . $apiIcon->id;
        Storage::put($savePath, $tmpResource);

        $icon = new Icon([
            'original_id' => $apiIcon->id,
            'name' => $apiIcon->name,
            'artist' => $apiIcon->artist,
            'provider' => 'the Noun Project',
            'license' => $apiIcon->license,
            'mimetype' => 'image/svg+xml',
            'path' => $savePath,
        ]);

        if (!$icon->save()) {
            Storage::delete($savePath);
            throw new IconSaveException("Couldn't save icon to the database", 0);
        }

        return $icon;
    }

    /**
     * @param string $iconName
     * @return Collection
     */

    public function getByName(string $iconName): Collection
    {
        return Icon::whereName($iconName)->get();
    }

    /**
     * @param string $id
     * @return Icon
     */

    public function getById(string $id): Icon
    {
        return Icon::whereId($id)->get()->first();
    }
}
