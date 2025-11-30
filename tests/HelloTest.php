<?php

namespace Xaraya\SymfonyApp\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/webhook/hello-symfony', ['name' => 'world']);

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Hello World');
        $response = $client->getResponse();
        // check message
        $output = $response->getContent();
        $expected = 'Received Event hello ';
        $this->assertStringStartsWith($expected, $output);
        // get event payload
        $lines = explode("\n", $output);
        array_shift($lines);
        $payload = implode("\n", $lines);
        $data = json_decode($payload, true);
        $expected = 'world';
        $this->assertSame($expected, $data['hello']);
    }
}
