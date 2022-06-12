<?php

namespace Proste\Samples;

use Proste\SDK;

/**
 * Class YouTube
 *
 * @package Proste\Samples
 */
class YouTube extends SDK
{
    public string $name = 'YouTube';

    public string $base_url = 'https://www.googleapis.com/youtube/v3/';

    /**
     * @param string $api_key
     */
    public function __construct(string $api_key)
    {
        parent::__construct();

        $this->params = [
            'key' => $api_key,
        ];
    }
}
