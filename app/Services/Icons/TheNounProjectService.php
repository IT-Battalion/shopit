<?php

namespace App\Services\Icons;

use App\Exceptions\MalformedIconDataException;
use App\Models\Icon;
use App\Services\Icons\Api\ApiClient;
use App\Services\Icons\Api\ApiIcon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * An Icon Service Implementation for the Noun Projects Icon API.
 */
class TheNounProjectService implements IconServiceInterface
{

    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param string $iconName the name of the icon to search for
     * @param int|null $offset how many results shall be skipped
     * @param int|null $page offset in form of $page * $limit
     * @param int|null $limit the number of icons to return
     * @return ApiIcon[] the icons fetched from the API
     * @throws MalformedIconDataException
     * @throws RequestException
     */

    public function findByName(
        string $iconName,
        int    $offset = null,
        int    $page = null,
        int    $limit = null): array
    {
        return $this->apiClient->icons(
            $iconName,
            config('shop.icon.only_public_domain'),
            $offset,
            $page,
            $limit
        );
    }

    /**
     * @param string $id
     * @return ApiIcon
     * @throws MalformedIconDataException
     * @throws RequestException
     */

    public function findById(string $id): ApiIcon
    {
        return $this->apiClient->icon($id);
    }

    public function add(ApiIcon $apiIcon): Icon
    {
        $tmpResource = tmpfile();

        Http::sink($tmpResource)->get($apiIcon->icon_url);

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
        }

        return $icon;
    }

    /**
     * @param string $iconName
     * @return Collection
     */

    public function getByName(string $iconName): Collection
    {
        return Icon::where('name', $iconName)->get();
    }

    /**
     * @param string $id
     * @return Icon
     */

    public function getById(string $id): Icon
    {
        return Icon::where('id', $id)->get()->first();
    }
}
