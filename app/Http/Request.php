<?php


namespace App\Http;



class Request
{
    private string $method;
    private string $url;


    public function __construct()
    {
        $this->method = strtolower($_SERVER['REQUEST_METHOD']);

        $url  = parse_url($_SERVER['REQUEST_URI'])['path'];
        $url = str_replace('\\', '/', $url);
        $url = str_replace(str_replace("C:/xampp/htdocs/", '', m_root_dir()), '', $url);
        $url = trim($url, '/');
        $this->url = $url === '' ? '/' : $url;

        foreach ($_REQUEST as $key => $value) {
            $this->$key = is_string($value) ? htmlspecialchars($value) : $value;
        }
    }

    public function method()
    {
        return $this->method;
    }
    public function url()
    {
        return $this->url;
    }
}
