<?php


namespace App\Tests\Service;

use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserServiceTest extends KernelTestCase {
    public function test_checkUserAlreadyExist_userNotFound(): void {

        $entityManagerInterfaceMock = $this->createMock(EntityManagerInterface::class);
        $entityManagerInterfaceMock->expects(self::once())
            ->method('findOneBy')
            ->willReturn([]);

        self::bootKernel();
        $container = static::getContainer();
        $container->set(EntityManagerInterface::class, $entityManagerInterfaceMock);

        $userService = new UserService($container->get(EntityManagerInterface::class));

        $result = $userService->checkUserAlreadyExist('test@gmail.com');
        $this->assertEquals(true, $result);
    }
}

?>
