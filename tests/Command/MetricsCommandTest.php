<?php

namespace App\Tests\Command;

use App\Command\MetricsCommand;
use App\Entity\Alias;
use App\Entity\Domain;
use App\Entity\OpenPgpKey;
use App\Entity\User;
use App\Entity\Voucher;
use App\Repository\AliasRepository;
use App\Repository\DomainRepository;
use App\Repository\OpenPgpKeyRepository;
use App\Repository\UserRepository;
use App\Repository\VoucherRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MetricsCommandTest extends TestCase
{
    public function testExecute(): void
    {
        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $userRepository->method('countUsers')->willReturn(10);
        $userRepository->method('countDeletedUsers')->willReturn(3);
        $userRepository->method('countUsersWithRecoveryToken')->willReturn(5);
        $userRepository->method('countUsersWithMailCrypt')->willReturn(7);
        $userRepository->method('countUsersWithTwofactor')->willReturn(9);

        $openPgpKeyRepository = $this->getMockBuilder(OpenPgpKeyRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $openPgpKeyRepository->method('countKeys')->willReturn(2);

        $aliasRepository = $this->getMockBuilder(AliasRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $aliasRepository->method('count')->willReturn(4);

        $domainRepository = $this->getMockBuilder(DomainRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $domainRepository->method('count')->willReturn(6);

        $voucherRepository = $this->getMockBuilder(VoucherRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $voucherRepository->method('countRedeemedVouchers')->willReturn(1);
        $voucherRepository->method('countUnredeemedVouchers')->willReturn(7);

        $manager = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $manager->method('getRepository')->willReturnMap([
            [User::class, $userRepository],
            [OpenPgpKey::class, $openPgpKeyRepository],
            [Alias::class, $aliasRepository],
            [Domain::class, $domainRepository],
            [Voucher::class, $voucherRepository],
        ]);

        $command = new MetricsCommand($manager);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $output = $commandTester->getDisplay();

        self::assertStringContainsString("userli_users_total 10", $output);
        self::assertStringContainsString("userli_users_deleted_total 3", $output);
        self::assertStringContainsString("userli_users_recovery_token_total 5", $output);
        self::assertStringContainsString("userli_users_mailcrypt_total 7", $output);
        self::assertStringContainsString("userli_users_twofactor_total 9", $output);
        self::assertStringContainsString("userli_vouchers_total{type=\"unredeemed\"} 7", $output);
        self::assertStringContainsString("userli_vouchers_total{type=\"redeemed\"} 1", $output);
        self::assertStringContainsString("userli_domains_total 6", $output);
        self::assertStringContainsString("userli_aliases_total 4", $output);
        self::assertStringContainsString("userli_openpgpkeys_total 2", $output);
    }
}
