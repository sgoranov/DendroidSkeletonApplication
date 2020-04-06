<?php
namespace App\Component\Login\Utils;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;

class AuthenticatedUser
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public static function getUserId(): int
    {
        if (!self::isLoggedIn()) {

            throw new \InvalidArgumentException('The user is not authenticated');
        }

        return $_SESSION[self::class];
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION[self::class]) ? true : false;
    }

    public function login(string $email, string $password): bool
    {

        try {

            /** @var User $user */
            $user = $this->userRepository->findByEmail($email);

            if (password_verify($password, $user->getPassword())) {

                $_SESSION[self::class] = $user->getId();

                return true;
            }

        } catch (EntityNotFoundException $e) {
        }

        return false;
    }

    public static function logout(): void
    {
        unset($_SESSION[self::class]);
    }
}