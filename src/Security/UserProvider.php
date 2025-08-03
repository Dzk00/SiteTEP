<?php

namespace App\Security;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class UserProvider implements UserProviderInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadUserByIdentifier($identifier): UserInterface
    {
        $user = $this->entityManager->getRepository(Admin::class)->findOneBy(['email' => $identifier]);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof Admin) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }

        // Chargez à nouveau l'utilisateur à partir de la source de données
        $refreshedUser = $this->entityManager->getRepository(Admin::class)->find($user->getId());

        if (null === $refreshedUser) {
            throw new UserNotFoundException();
        }

        return $refreshedUser;
    }

    public function supportsClass(string $class): bool
    {
        return Admin::class === $class || is_subclass_of($class, Admin::class);
    }
}
