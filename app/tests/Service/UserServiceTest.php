<?php



namespace App\Tests\Service;

use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserServiceTest extends KernelTestCase {
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
        $this->assertEquals(true, $result);
    }
}

?>
