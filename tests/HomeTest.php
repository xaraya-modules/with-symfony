<?php

namespace Xaraya\SymfonyApp\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('h1', 'Hello World');
        $response = $client->getResponse();
        $output = $response->getContent();
        $this->assertJson($output);
        $data = json_decode($output, true);
        $expected = 'Welcome to your new controller!';
        $this->assertSame($expected, $data['message']);
    }
}
