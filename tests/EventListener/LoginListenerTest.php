<?php

namespace App\Tests\EventListener;

use App\Entity\User;
use App\Event\LoginEvent;
use App\EventListener\LoginListener;
use App\Helper\PasswordUpdater;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class LoginListenerTest extends TestCase
{
    private EntityManagerInterface $manager;
    private LoginListener $listener;

    public function setUp(): void
    {
        $this->manager = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->listener = new LoginListener($this->manager);
    }

    public function testOnSecurityInteractiveLogin(): void
    {
        $user = new User();
        $this->manager->expects($this->once())->method('flush');
        $event = $this->getEvent($user);

        $this->listener->onSecurityInteractiveLogin($event);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|InteractiveLoginEvent
     */
    private function getEvent(User $user): InteractiveLoginEvent
    {
        $request = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $request->method('get')->willReturn('password');

        $token = $this->getMockBuilder(TokenInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $token->method('getUser')->willReturn($user);

        $event = $this->getMockBuilder(InteractiveLoginEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event->method('getRequest')->willReturn($request);
        $event->method('getAuthenticationToken')->willReturn($token);

        return $event;
    }

    public function testGetSubscribedEvents(): void
    {
        $this->assertEquals([
            SecurityEvents::INTERACTIVE_LOGIN => 'onSecurityInteractiveLogin',
            LoginEvent::NAME => 'onLogin',
        ],
            $this->listener::getSubscribedEvents());
    }
}
