<?php

namespace App\Services\Icons\NounProjectApi;


use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
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
     * Downloads an icon image
     * @param ApiIcon $apiIcon the icon to download
     * @param string|resource $downloadLocation where to download the icon to
     * @return PromiseInterface|Response the answer of the request
     */
    public function downloadIcon(ApiIcon $apiIcon, mixed $downloadLocation): PromiseInterface|Response
    {
        return Http::sink($downloadLocation)->get($apiIcon->icon_url);
    }

}
