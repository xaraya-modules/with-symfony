<?php

namespace Xaraya\SymfonyApp\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Symfony\Component\Messenger\Transport\Receiver\MessageCountAwareInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/HomeController.php',
            'app_count' => $this->generateUrl('app_count'),
            '_webhook_controller' => $this->generateUrl('_webhook_controller', ['type' => 'hello-symfony']),
        ]);
    }

    /**
     * @see https://github.com/symfony/symfony/issues/53954#issuecomment-1946610595
     */
    #[Route('/count', name: 'app_count')]
    public function count(
        #[TaggedIterator('messenger.receiver', indexAttribute: 'alias')]
        iterable $receivers,
    ): JsonResponse {
        $count = [];
        foreach ($receivers as $key => $receiver) {
            if ($receiver instanceof MessageCountAwareInterface) {
                $count[$key] = $receiver->getMessageCount();
            } else {
                $count[$key] = -1;
            }
        }
        return $this->json([
            'count' => $count,
        ]);
    }
}
