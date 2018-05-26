<?php namespace App;

class Url {

    private $server;
    private $protocol;
    private $domain;
    private $query_string;

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->setProtocol();
        $this->setDomain();
        $this->setQueryString();
    }

    public function protocol()
    {
        return $this->protocol;
    }

    public function domain()
    {
        return $this->domain;
    }

    public function queryString()
    {
        return $this->query_string;
    }
    
    private function setProtocol()
    {
        $this->protocol = isset($this->server['HTTPS']) ? 'https' : 'http';
    }

    private function setDomain()
    {
        $this->domain = $this->server['SERVER_NAME'];
    }

    private function setQueryString()
    {
        $this->query_string = $this->server['QUERY_STRING'];
    }
}