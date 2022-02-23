<?php

namespace App;

use GuzzleHttp\Client;

class PageLoader
{

    public function load($url, $path, $clientClass = null): string
    {
        $filename = $path . '/' . $this->getFilename($url);
        $content = $this->getUrlContent($url, $clientClass);
        file_put_contents($filename, $content);
        return $filename;
    }

    private function getFilename($url): string
    {
        $parts = parse_url($url);
        $name = $parts['host'] . $parts['path'];
        return preg_replace( '/[\W]/', '-', $name) . '.html';
    }

    private function getUrlContent($url, $clientClass = null): string
    {
        $client = $clientClass ?? new Client();
        return $client->request('GET', $url)->getBody()->getContents();
    }

}