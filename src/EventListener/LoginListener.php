<?php

namespace App\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

#[AsEventListener]
readonly final class LoginListener
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(InteractiveLoginEvent $event): void
    {
        $this->logger->info('User "' . $event->getAuthenticationToken()->getUser()->getUserIdentifier() . '" logged in');
    }
}
