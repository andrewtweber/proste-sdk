<?php

namespace Proste;

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Proste\Exceptions\HttpException;

/**
 * Class SDK
 *
 * @package Proste
 */
abstract class SDK
{
    protected Guzzle $guzzle;

    public string $name;

    public string $base_url;

    protected array $params = [];

    /**
     * Create a new SDK instance with a GuzzleHttp client
     */
    public function __construct()
    {
        $this->guzzle = new Guzzle();
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
        return $this->request(Verb::Post, $url, $params);
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

    /**
     * Generic request
     *
     * @param Verb   $verb GET, POST, etc.
     * @param string $url Relative URL
     * @param array  $params Query parameters
     *
     * @return array
     */
    public function request(Verb $verb, string $url, array $params = []): array
    {
        try {
            $response = $this->guzzle->request(
                $verb->value,
                $this->buildUrl($url, $params),
                $this->getOptions()
            );
        } catch (ClientException|ServerException $e) {
            throw HttpException::make($this, $e->getResponse()->getStatusCode(), $e);
        }

        return json_decode($response->getBody(), true);
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
     * SDK options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [];
    }
}
