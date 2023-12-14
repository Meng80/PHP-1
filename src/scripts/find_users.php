<?php

/**
 * find_result_by_userid.php
 *
 * Script to find user information by user ID using Doctrine ORM
 *
 * Usage: php find_result_by_userid.php <user_id>
 */

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

Utils::loadEnv(dirname(__DIR__, 2));


if ($argc !== 2) {
    echo "Usage: php find_result_by_userid.php <user_id>" . PHP_EOL;
    exit(1);
}

// Extract command line arguments
$userId = (int)$argv[1];

// Get the entity manager
$entityManager = DoctrineConnector::getEntityManager();

// Get the user
$userRepository = $entityManager->getRepository(User::class);
$user = $userRepository->find($userId);

if (!$user instanceof User) {
    echo "Error: User with ID $userId not found." . PHP_EOL;
    exit(1);
}

echo "User Information for User ID $userId:" . PHP_EOL;
echo sprintf(
    'User ID: %d, Username: %s, Email: %s, Enabled: %s' . PHP_EOL,
    $user->getId(),
    $user->getUsername(),
    $user->getEmail(),
    $user->isEnabled() ? 'true' : 'false'
);

