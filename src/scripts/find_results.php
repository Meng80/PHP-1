<?php

/**
 * find_results_by_user_id.php
 *
 * Script to find results by user ID using Doctrine ORM
 *
 * Usage: php find_results_by_user_id.php <user_id>
 */

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

Utils::loadEnv(dirname(__DIR__, 2));

if ($argc !== 2) {
    echo "Usage: php find_results_by_user_id.php <user_id>" . PHP_EOL;
    exit(1);
}

$userId = (int) $argv[1];
$entityManager = DoctrineConnector::getEntityManager();

$userRepository = $entityManager->getRepository(User::class);
$user = $userRepository->find($userId);

if (!$user instanceof User) {
    echo "User with ID $userId not found." . PHP_EOL;
    exit(1);
}

$resultRepository = $entityManager->getRepository(Result::class);
$results = $resultRepository->findBy(['user' => $user]);

if (count($results) > 0) {
    echo "Results for User ID $userId:" . PHP_EOL;
    foreach ($results as $result) {
        echo sprintf(
            'Result: %d' . PHP_EOL,
            $result->getResult()
        );
    }
} else {
    echo "No results found for User ID $userId." . PHP_EOL;
}



