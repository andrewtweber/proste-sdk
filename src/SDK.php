<?php

namespace Proste;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Proste\Exceptions\HttpException;

/**
 * Class SDK
 *
 * @package Proste
 */
abstract class SDK
{
    public string $name;

    public string $base_url;

    protected array $headers = [
        'Accept' => 'application/json',
    ];

    protected array $params = [];

    /**
     * Create a new SDK instance
     */
    public function __construct()
    {
    }

    /**
     * Generic GET request
     *
     * @param string $url
     * @param array  $params
     *
     * @return array
     */
    public function get(string $url, array $params = []): array
    {
        return $this->request(Verb::Get, $url, $params);
    }

    /**
     * Generic POST request
     *
     * @param string $url
     * @param array  $params
     *
     * @return array
     */
    public function post(string $url, array $params = []): array
    {
        return $this->request(Verb::Post, $url, options: [
            'form_params' => $params,
        ]);
    }

    /**
     * Generic PUT request
     *
     * @param string $url
     * @param array  $params
     *
     * @return array
     */
    public function put(string $url, array $params = []): array
    {
        return $this->request(Verb::Put, $url, $params);
    }

    /**
     * Generic PATCH request
     *
     * @param string $url
     * @param array  $params
     *
     * @return array
     */
    public function patch(string $url, array $params = []): array
    {
        return $this->request(Verb::Patch, $url, $params);
    }

    /**
     * Generic DELETE request
     *
     * @param string $url
     * @param array  $params
     *
     * @return array
     */
    public function delete(string $url, array $params = []): array
    {
        return $this->request(Verb::Delete, $url, $params);
    }

    public function send(Request $request): array
    {
        $response = Http::send(
            $request->verb->value,
            $this->buildUrl($request->url, $request->getParams()),
            array_merge($this->getOptions(), $request->getOptions()),
        );

        return $this->parseResponse($response);
    }

    /**
     * Generic request
     *
     * @param Verb   $verb GET, POST, etc.
     * @param string $url Relative URL
     * @param array  $params Query parameters
     * @param array  $options Additional options
     *
     * @return array
     */
    public function request(Verb $verb, string $url, array $params = [], array $options = []): array
    {
        $response = Http::send(
            $verb->value,
            $this->buildUrl($url, $params),
            array_merge($this->getOptions(), $options),
        );

        return $this->parseResponse($response);
    }

    /**
     * Throw an exception if the request failed, otherwise decode the JSON body
     *
     * @param Response $response
     *
     * @return array
     */
    protected function parseResponse(Response $response): array
    {
        if ($response->failed()) {
            throw HttpException::make($this, $response->status(), $response->toException());
        }

        return $response->json() ?? [];
    }

    /**
     * Convert relative URL to full URL
     *
     * @param string $url
     *
     * @return string
     */
    protected function baseUrl(string $url): string
    {
        return rtrim($this->base_url, '/') . '/' . ltrim($url, '/');
    }

    /**
     * Build a URL with array of params
     *
     * @param string $url
     * @param array  $params
     *
     * @return string
     */
    protected function buildUrl(string $url, array $params = []): string
    {
        $params = http_build_query($this->mergeParams($params));

        return $this->baseUrl($url) . ($params ? '?' . $params : '');
    }

    /**
     * Merge user parameters with SDK defaults
     *
     * @param array $params
     *
     * @return array
     */
    protected function mergeParams(array $params = []): array
    {
        return array_merge($this->params, $params);
    }

    /**
     * Guzzle options for every request
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [];
    }
}
