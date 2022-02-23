<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;

class PageLoaderTest extends TestCase
{
    public Client $client;
    public vfsStreamDirectory $root;
    
    public function setUp(): void
    {
        $mock = new MockHandler([
            new Response(200, [], 'test content'),
        ]);
        $handlerStack = HandlerStack::create($mock);
        $this->client = new Client(['handler' => $handlerStack]);
        $this->root = vfsStream::setup('exampleDir');
    }

    public function testLoad()
    {
        $loader = new App\PageLoader();
        
        $path = $loader->load('https://test.ru/load', $this->root->url(), $this->client);
        
        $this->assertTrue(true, $this->root->hasChild('test-ru-load.html'));
        $this->assertEquals($path, $this->root->getChild('test-ru-load.html')->url());
    }
}
