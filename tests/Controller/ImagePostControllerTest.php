<?php

namespace App\Tests\Controller;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

class ImagePostControllerTest extends WebTestCase
{
    /**
     * @throws \Exception
     */
    #[NoReturn] public function testCreate()
    {
        $client = static::createClient();
        $uploadedFile = new UploadedFile(
            __DIR__.'/../fixtures/picture.png',
            'ryan-fabien.jpg'
        );
        $client->request('POST', '/api/images', [], [
            'file' => $uploadedFile
        ]);

        $this->assertResponseIsSuccessful();
        $container = static::getContainer();
        /** @var InMemoryTransport $transport */
        $transport = $container->get('messenger.transport.async_priority_high');
        $this->assertCount(1, $transport->get());
    }
}