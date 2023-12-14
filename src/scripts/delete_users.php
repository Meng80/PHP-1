<?php

/**
 * delete_users.php
 *
 * Script to delete a user from the database.
 */

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;


Utils::loadEnv(dirname(__DIR__, 2));

$entityManager = DoctrineConnector::getEntityManager();

if ($argc !== 2) {
    echo "Usage: php delete_users.php <user_id>" . PHP_EOL;
    exit(1);
}

$userId = (int)$argv[1];

$userRepository = $entityManager->getRepository(User::class);
$user = $userRepository->find($userId);

if (!$user instanceof User) {
    echo "User with ID $userId not found." . PHP_EOL;
    exit(1);
}

try {
    $entityManager->remove($user);
    $entityManager->flush();
    echo "User with ID $userId deleted successfully." . PHP_EOL;
} catch (Throwable $exception) {
    echo $exception->getMessage() . PHP_EOL;
    exit(1);
}

