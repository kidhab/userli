<?php

namespace App\Handler;

use App\Entity\User;
use App\Event\LoginEvent;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

/**
 * Class UserAuthenticationHandler.
 */
class UserAuthenticationHandler
{
    private PasswordHasherFactoryInterface $passwordHasherFactory;
    protected EventDispatcherInterface $eventDispatcher;

    /**
     * UserAuthenticationHandler constructor.
     */
    public function __construct(PasswordHasherFactoryInterface $passwordHasherFactory, EventDispatcherInterface $eventDispatcher)
    {
        $this->passwordHasherFactory = $passwordHasherFactory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function authenticate(User $user, string $password): ?User
    {
        $hasher = $this->passwordHasherFactory->getPasswordHasher($user);
        if (!$hasher->verify($user->getPassword(), $password)) {
            return null;
        }
        $user->setPlainPassword($password);

        $this->eventDispatcher->dispatch(new LoginEvent($user), LoginEvent::NAME);

        return $user;
    }
}
