<?php

/**
 * update.php
 *
 * Script to update user information using Doctrine ORM
 *
 * Usage: php update.php <user_id> <new_username> <new_email>
 */

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

Utils::loadEnv(dirname(__DIR__, 2));

if ($argc !== 4) {
    echo "Usage: php update.php <user_id> <new_username> <new_email>" . PHP_EOL;
    exit(1);
}

$userID = (int)$argv[1];
$newUsername = $argv[2];
$newEmail = $argv[3];

$entityManager = DoctrineConnector::getEntityManager();

$userRepository = $entityManager->getRepository(User::class);
$userToUpdate = $userRepository->find($userID);

// Update user information
if ($userToUpdate instanceof User) {
    $userToUpdate->setUsername($newUsername);
    $userToUpdate->setEmail($newEmail);

    try {
        $entityManager->flush();
        echo "User information updated successfully." . PHP_EOL;
    } catch (Throwable $exception) {
        echo $exception->getMessage() . PHP_EOL;
    }
} else {
    echo "User not found." . PHP_EOL;
    exit(1);
}

