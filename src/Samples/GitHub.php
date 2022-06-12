<?php

namespace Proste\Samples;

use Proste\SDK;

/**
 * Class GitHub
 *
 * @package Proste\Samples
 */
class GitHub extends SDK
{
    public string $name = 'GitHub';

    public string $base_url = 'https://api.github.com/';

    protected string $username;

    protected string $token;

    /**
     * Authorize requests with a username and token
     *
     * @param string $username
     * @param string $token
     */
    public function __construct(string $username, string $token)
    {
        parent::__construct();

        $this->username = $username;
        $this->token = $token;
    }

    /**
     * Get repository details
     *
     * @param string $repository
     *
     * @return array
     */
    public function repo(string $repository): array
    {
        return $this->get('/repos/' . $repository);
    }

    /**
     * Get releases
     *
     * @param string $repository
     *
     * @return array
     */
    public function releases(string $repository): array
    {
        return $this->get('/repos/' . $repository . '/releases');
    }

    /**
     * Get issues
     *
     * @param string $repository
     *
     * @return array
     */
    public function issues(string $repository): array
    {
        return $this->get('/repos/' . $repository . '/issues');
    }

    /**
     * SDK options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            'auth' => [
                $this->username,
                $this->token,
            ],
        ];
    }
}
