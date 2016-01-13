<?php namespace Upnd\Services;

use GuzzleHttp\Client as Guzzle;

class YouTube extends SDK
{
    protected $name = 'YouTube';

    public static $valid_domains = [
        'youtube.com',
        'www.youtube.com',
        'm.youtube.com',
        'youtu.be',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->params = [
            'key' => config('services.google.api_key'),
        ];
    }

    public function getVideoDetails($ids)
    {
        $response = $this->get('videos', [
            'part' => 'contentDetails,snippet',
            'id'   => implode(',', (array)$ids),
        ]);

        $details = [];
        foreach ($response['items'] as $video) {
            $details[] = [
                'title'     => ($video['snippet']['title'] ?: ''),
                'thumbnail' => $video['snippet']['thumbnails']['high']['url'],
                'width'     => $video['snippet']['thumbnails']['high']['width'],
                'height'    => $video['snippet']['thumbnails']['high']['height'],
                'duration'  => $this->durationToSeconds($video['contentDetails']['duration']),
            ];
        }

        return $details[0];
    }

    public function durationToSeconds($duration)
    {
        $interval = new \DateInterval($duration);

        return (($interval->s) + (60 * $interval->i) + (60 * 60 * $interval->h));
    }

    protected function baseUrl($url)
    {
        return 'https://www.googleapis.com/youtube/v3/' . ltrim($url, '/');
    }

    public static function parseId($url)
    {
        $parts = parse_url($url);
        $path = ltrim($parts['path'], '/');
        parse_str($parts['query'], $query);

        if (! in_array($parts['host'], self::$valid_domains)) {
            return false;
        }

        if ($path == 'watch') {
            return $query['v'];
        }

        return $path;
    }
}

