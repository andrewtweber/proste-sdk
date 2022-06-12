<?php

namespace Proste\Samples;

use Proste\SDK;

/**
 * Class Reddit
 *
 * @package Proste\Samples
 */
class Reddit extends SDK
{
    public string $name = 'Reddit';

    public string $base_url = 'https://www.reddit.com/';

    /**
     * Convert relative URL to full URL
     *
     * @param string $url
     *
     * @return string
     */
    protected function baseUrl(string $url): string
    {
        return parent::baseUrl($url) . '.json';
    }
}
