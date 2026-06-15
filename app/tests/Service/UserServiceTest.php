<?php

namespace App\Tests\Service;

use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserServiceTest extends KernelTestCase {

    #[DataProvider('dataprovider_validatePayload_throwOnInvalid')]
    public function test_validatePayload_throwOnInvalid(array $payload): void {
        self::bootKernel();
        $container = static::getContainer();
        $userService = new UserService($container->get(UserRepository::class), $container->get(EntityManagerInterface::class));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('invalid payload');

        $userService->validatePayload($payload);
    }


    public static function dataprovider_validatePayload_throwOnInvalid(): \Generator {
        yield [[]];
        yield [['email' => 'email', 'password' => 'password']];
        yield [['email' => 'email', 'password' => 'password', 'confirmPassword' => 'password', 'invalid' => 'value']];
        yield [['email' => 'email', 'password' => 'password', 'invalid' => 'value']];
        yield [['email' => '', 'password' => '', 'confirmPassword' => '']];
        yield [['email' => 'email', 'password' => 'password', 'confirmPassword' => 'invalid']];
    }

    public function test_checkUserAlreadyExist_userNotFound(): void {

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $userRepositoryMock ->expects(self::once())
            ->method('findOneBy')
            ->willReturn(null);

        self::bootKernel();
        $container = static::getContainer();
        $container->set(UserRepository::class, $userRepositoryMock );

        $userService = new UserService($container->get(UserRepository::class), $container->get(EntityManagerInterface::class));

        $result = $userService->checkUserAlreadyExist('test@gmail.com');
        $this->assertEquals(false, $result);
    }


    public function test_createUser_throwOnInvalidPayload(): void {
        self::bootKernel();
        $payload = ['email' => 'duplicated', 'password' => 'valid', 'confirmPassword' => 'invalid'];

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $emMock = $this->createMock(EntityManagerInterface::class);
        self::getContainer()->set(UserRepository::class, $userRepositoryMock);
        self::getContainer()->set(EntityManagerInterface::class, $emMock);

        $userServiceMock = $this->getMockBuilder(UserService::class)
            ->setConstructorArgs([$userRepositoryMock, $emMock])
            ->getMock();

        $userServiceMock->expects(self::once())
            ->method('validatePayload')
            ->with($payload)
            ->willThrowException(new \Exception('invalid payload'));

        $userServiceMock->expects(self::never())
            ->method('checkUserAlreadyExist');

        self::getContainer()->set(UserService::class, $userServiceMock);

        $userServiceMock->createUser($payload);
    }

    public function test_createUser_throwOnDuplicatedUser(): void {
        self::bootKernel();

        $payload = ['email' => 'duplicated', 'password' => 'valid', 'confirmPassword' => 'valid'];

        $userRepositoryMock = $this->createMock(UserRepository::class);
        $emMock = $this->createMock(EntityManagerInterface::class);
        self::getContainer()->set(UserRepository::class, $userRepositoryMock);
        self::getContainer()->set(EntityManagerInterface::class, $emMock);

        $userServiceMock = $this->getMockBuilder(UserService::class)
            ->setConstructorArgs([$userRepositoryMock, $emMock])
            ->getMock();

        $userServiceMock->expects(self::once())
            ->method('validatePayload')
            ->with($payload)
            ->willReturn(true);

        $userServiceMock->expects(self::once())
            ->method('checkUserAlreadyExist')
            ->with($payload['email'])
            ->willReturn(true);

        self::getContainer()->set(UserService::class, $userServiceMock);

        $userServiceMock->createUser($payload);
    }
}

?>
