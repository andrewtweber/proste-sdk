<?php namespace Proste;

class YouTube extends SDK
{
    /**
     * @var string
     */
    protected $name = 'YouTube';

    /**
     * @var string
     */
    protected $base_url = 'https://www.googleapis.com/youtube/v3/';

    public function __construct($api_key)
    {
        parent::__construct();

        $this->params = [
            'key' => $api_key,
        ];
    }
}

