<?php namespace System\Core;

class Url {

    private static $instance = null;
    //private $server;
    private $protocol;
    private $domain;
    private $port;
    //private $self;
    private $public;
    private $query;
    private $host;
    private $referer;
    private $base;

    private function __construct()
    {
        //$this->server   = $_SERVER;
        $this->protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $this->domain   = $_SERVER['SERVER_NAME'];
        $this->port     = empty($_SERVER['SERVER_PORT']) ? '' : ':'.$_SERVER['SERVER_PORT'];
        //$this->self     = $_SERVER['PHP_SELF'];
        $this->public   = str_replace('index.php', '', $_SERVER['PHP_SELF']);
        $this->query    = $_SERVER['QUERY_STRING'];
        $this->host     = $_SERVER['HTTP_HOST'];
        $this->referer  = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null;
        $this->base     = $this->protocol . '://' . $this->domain . $this->port . $this->public;
    }

    private function location($url = '')
    {
        header('Location: '.$url);
        exit();
    }
    
    static public function address($url)
    {
        $self = self::getInstance();
        return $self->base.$url;
    }

    static public function redirect($url)
    {
        $self = self::getInstance();
        $redirect = $self->base.$url;
        $self->location($redirect);
    }
    
    static public function back()
    {
        $self = self::getInstance();
        if( !is_null( $self->referer ) )
            $self->location( $self->referer );
        
        $self->location( $self->base );
    }

    static public function generator($string, array $arguments = null)
    {
        $self = self::getInstance();
        $route = $self->address($string);
        return $route;
        if( is_array($arguments) && $count = count($arguments) )
        {
            $last = $arguments[ $count - 1 ];
            $query = '?';
            foreach($arguments as $key => $value)
            {
                $query .= $key.'='.$value;
                if($key <> $last) $query .= '&';
            }
            return $route.$query;
        }
        return $route;
    }
    
    static public function getInstance()
    {
        if( is_null( self::$instance ) )
        {
            self::$instance = new Url();
        }
        return self::$instance;
    }
}





/*
[REDIRECT_STATUS] => 200
    [HTTP_HOST] => localhost:8888
    [HTTP_CONNECTION] => keep-alive
    [HTTP_CACHE_CONTROL] => max-age=0
    [HTTP_UPGRADE_INSECURE_REQUESTS] => 1
    [HTTP_USER_AGENT] => Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36
    [HTTP_ACCEPT] => text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*_/*;q=0.8
    [HTTP_ACCEPT_ENCODING] => gzip, deflate, br
    [HTTP_ACCEPT_LANGUAGE] => en-US,en;q=0.9,es;q=0.8
    [PATH] => /usr/bin:/bin:/usr/sbin:/sbin
    [SERVER_SIGNATURE] => 
    [SERVER_SOFTWARE] => Apache/2.2.34 (Unix) mod_wsgi/3.5 Python/2.7.13 PHP/7.2.1 mod_ssl/2.2.34 OpenSSL/1.0.2j DAV/2 mod_fastcgi/2.4.6 mod_perl/2.0.9 Perl/v5.24.0
    [SERVER_NAME] => localhost
    [SERVER_ADDR] => ::1
    [SERVER_PORT] => 8888
    [REMOTE_ADDR] => ::1
    [DOCUMENT_ROOT] => /Applications/MAMP/htdocs
    [SERVER_ADMIN] => you@example.com
    [SCRIPT_FILENAME] => /Applications/MAMP/htdocs/maguk/new/public/index.php
    [REMOTE_PORT] => 49555
    [REDIRECT_QUERY_STRING] => url=dashboard
    [REDIRECT_URL] => /maguk/new/public/dashboard
    [GATEWAY_INTERFACE] => CGI/1.1
    [SERVER_PROTOCOL] => HTTP/1.1
    [REQUEST_METHOD] => GET
    [QUERY_STRING] => url=dashboard
    [REQUEST_URI] => /maguk/new/public/dashboard
    [SCRIPT_NAME] => /maguk/new/public/index.php
    [PHP_SELF] => /maguk/new/public/index.php
    [REQUEST_TIME_FLOAT] => 1527714810.478
    [REQUEST_TIME] => 1527714810
    [argv] => Array
        (
            [0] => url=dashboard
        )

    [argc] => 1
)
*/