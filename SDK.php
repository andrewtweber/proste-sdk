<?php namespace Proste;

use GuzzleHttp\Client as Guzzle;

abstract class SDK
{
    /**
     * @var Guzzle
     */
    protected $guzzle;

    /**
     * Default parameters for all requests
     *
     * @var array
     */
    protected $params = [];

    /**
     * Create a new SDK instance with a GuzzleHttp client
     *
     * @return void
     */
    public function __construct()
    {
        $this->guzzle = new Guzzle();
    }

    /**
     * Generic GET request
     *
     * @param  string  $url
     * @param  array  $params
     * @return array
     */
    public function get($url, array $params = [])
    {
        return $this->request('GET', $url, $params);
    }

    /**
     * Generic POST request
     *
     * @param  string  $url
     * @param  array  $params
     * @return array
     */
    public function post($url, array $params = [])
    {
        return $this->request('POST', $url, $params);
    }

    /**
     * Generic PUT request
     *
     * @param  string  $url
     * @param  array  $params
     * @return array
     */
    public function put($url, array $params = [])
    {
        return $this->request('PUT', $url, $params);
    }

    /**
     * Generic DELETE request
     *
     * @param  string  $url
     * @param  array  $params
     * @return array
     */
    public function delete($url, array $params = [])
    {
        return $this->request('DELETE', $url, $params);
    }

    /**
     * Generic request
     *
     * @param  string  $verb  GET, POST, etc.
     * @param  string  $url  Relative URL
     * @param  array  $params  Query parameters
     * @return array
     */
    public function request($verb, $url, array $params = [])
    {
        try {
            $response = $this->guzzle->request($verb, $this->buildUrl($url, $params), $this->getOptions());

            if ($response->getStatusCode() != '200') {
                throw new \Exception($this->name . " API failed: " . $response->getBody());
            }
        } catch (\Exception $e) {
            throw new \Exception($this->name . " API failed: " . $e->getMessage());
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Convert relative URL to full URL
     * Must be defined by child class
     *
     * @param  string  $url
     * @return string
     */
    abstract protected function baseUrl($url);

    /**
     * Build a URL with array of params
     *
     * @param  string  $url 
     * @param  array  $params
     * @return string
     */
    protected function buildUrl($url, array $params = [])
    {
        $params = http_build_query($this->mergeParams($params));

        return $this->baseUrl($url) . ($params ? '?' . $params : '');
    }

    /**
     * Merge user parameters with SDK defaults
     *
     * @param  array  $params
     * @return array
     */
    protected function mergeParams(array $params = [])
    {
        return array_merge($this->params, $params);
    }

    /**
     * SDK options
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}

