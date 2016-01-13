<?php namespace Proste;

class GitHub extends SDK
{
    /**
     * @var string
     */
    protected $name = 'GitHub';

    /**
     * @var string
     */
    protected $base_url = 'https://api.github.com/';

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $token;

    /**
     * Authorize requests with a username and token
     *
     * @param  string  $username
     * @param  string  $token
     * @return void
     */
    public function __construct($username, $token)
    {
        parent::__construct();

        $this->username = $username;
        $this->token = $token;
    }

    /**
     * Get repository details
     *
     * @param  string  $repository
     */
    public function repo($repository)
    {
        return $this->get('/repos/' . $repository);
    }

    /**
     * Get releases
     *
     * @return array
     */
    public function releases($repository)
    {
        return $this->get('/repos/' . $repository . '/releases');
    }

    /**
     * Get issues
     *
     * @return array
     */
    public function issues($repository)
    {
        return $this->get('/repos/' . $repository . '/issues');
    }

    /**
     * SDK options
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            'auth' => [
                $this->username, 
                $this->token,
            ],
        ];
    }
}

