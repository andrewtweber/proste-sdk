<?php

namespace Proste;

class Request
{
    public Verb $verb = Verb::Get;

    public array $headers = [];

    public array $params = [];

    public function __construct(
        public string $url,
    ) {
    }

    public static function make(string $url): Request
    {
        return new Request($url);
    }

    //------------------------------------------------------------------------------
    //  Verbs
    //------------------------------------------------------------------------------
    public function verb(Verb $verb): self
    {
        $this->verb = $verb;

        return $this;
    }

    public function get(): self
    {
        $this->verb = Verb::Get;

        return $this;
    }

    public function post(): self
    {
        $this->verb = Verb::Post;

        return $this;
    }

    public function put(): self
    {
        $this->verb = Verb::Put;

        return $this;
    }

    public function patch(): self
    {
        $this->verb = Verb::Patch;

        return $this;
    }

    public function delete(): self
    {
        $this->verb = Verb::Delete;

        return $this;
    }

    //------------------------------------------------------------------------------
    //  Headers
    //------------------------------------------------------------------------------
    public function setHeaders(array $headers = []): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function mergeHeaders(array $headers = []): self
    {
        $this->headers = array_merge($this->headers, $headers);

        return $this;
    }

    public function header(string $key, ?string $value): self
    {
        $this->headers[$key] = $value;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    //------------------------------------------------------------------------------
    //  Params
    //  These will either be sent as the URL query or as form params, depending
    //  on the request verb.
    //------------------------------------------------------------------------------
    public function setParams(array $params = []): self
    {
        $this->params = $params;

        return $this;
    }

    public function mergeParams(array $params = []): self
    {
        $this->params = array_merge($this->params, $params);

        return $this;
    }

    public function param(string $key, ?string $value): self
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function getParams(): array
    {
        if ($this->verb === Verb::Post) {
            return [];
        }

        return $this->params;
    }

    public function getOptions(): array
    {
        if ($this->verb === Verb::Post) {
            return [
                'headers' => $this->headers,
                'form_params' => $this->params,
            ];
        }

        return [
            'headers' => $this->headers,
        ];
    }
}
