<?php

namespace App\Services\Icons\Api;


use App\Exceptions\MalformedIconDataException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ApiClient
{

    private const BASE_URL = 'https://api.thenounproject.com/';

    protected HandlerStack $authStack;

    public function __construct(string $key, string $secret)
    {
        $handler = new CurlHandler();
        $this->authStack = HandlerStack::create($handler);

        $middleware = new Oauth1([
            'consumer_key' => $key,
            'consumer_secret' => $secret,
            'signature_method' => Oauth1::SIGNATURE_METHOD_HMAC,
        ]);
        $this->authStack->push($middleware);
    }

    public function fetch(string $endpoint, array $parameters): Response
    {
        return Http::withOptions([
            'base_uri' => self::BASE_URL,
            'handler' => $this->authStack,
            'auth' => 'oauth',
        ])->get(
            $endpoint,
            $parameters
        );
    }

    /**
     * @param array $data
     * @return ApiIcon[]
     * @throws MalformedIconDataException
     */

    private static function parseIcons(array $data): array
    {
        $icons = array_map(function ($iconData) {
            return self::parseIcon($iconData);
        }, $data);
        return array_filter($icons);
    }

    /**
     * @param array $iconData
     * @return ApiIcon|bool returns the {@link Icon} generated from the $iconData or false if no icon could be generated.
     * @throws MalformedIconDataException Gets thrown when you try to generate an icon based on invalid data
     */

    private static function parseIcon(array $iconData): ApiIcon|bool
    {
        if (!array_key_exists('icon_url', $iconData)) {
            return false;
        }

        if (array_key_exists('attribution_preview_url', $iconData)) {
            $preview_url = $iconData['attribution_preview_url'];
        } else if (array_key_exists('preview_url', $iconData)) {
            $preview_url = $iconData['preview_url'];
        } else {
            throw new MalformedIconDataException('Couldn\'t create Icon from icon data\n\
            No url for an icon preview could be found\n\
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
     * @param string $name the name to search for
     * @param bool $limit_to_public_domain if the icons shall be limited to icons from the public domain
     * @param int|null $offset the offset from the first icon (how many icons shall be skipped)
     * @param int|null $page the page of the results ($page * $limit = $offset)
     * @param int|null $limit the limit of icons on one page
     * @return ApiIcon[]
     * @throws RequestException
     * @throws MalformedIconDataException
     */

    public function icons(
        string $name,
        bool   $limit_to_public_domain = false,
        int    $offset = null,
        int    $page = null,
        int    $limit = null): array
    {
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

        $response = $this->fetch('icons/' . $name, $parameters);

        if ($response->failed()) {
            $response->throw();
        }

        $data = $response->json();

        return self::parseIcons($data['icons']);
    }

    /**
     * @param int|string $icon
     * @return ApiIcon|bool
     * @throws RequestException|MalformedIconDataException
     */

    public function icon(int|string $icon): ApiIcon|bool
    {
        $response = $this->fetch('icon/' . $icon, []);

        if ($response->failed()) {
            $response->throw();
        }

        $data = $response->json();

        return self::parseIcon($data['icon']);
    }

}
