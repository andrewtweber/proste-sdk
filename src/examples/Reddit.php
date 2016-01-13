<?php namespace Proste;

class Reddit extends SDK
{
    /**
     * @var string
     */
    protected $name = 'Reddit';

    /**
     * @var string
     */
    protected $base_url = 'https://www.reddit.com/';

    /**
     * Convert relative URL to full URL
     *
     * @param  string  $url
     * @return string
     */
    protected function baseUrl($url)
    {
        return parent::baseUrl($url) . '.json';
    }
}

