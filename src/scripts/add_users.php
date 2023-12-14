<?php


/**
 * add_users.php
 *
 * Script to add a user to the database.
 */

require dirname(__DIR__, 2) . '/vendor/autoload.php';

use MiW\Results\Entity\User;
use MiW\Results\Utility\DoctrineConnector;
use MiW\Results\Utility\Utils;

Utils::loadEnv(dirname(__DIR__, 2));

$entityManager = DoctrineConnector::getEntityManager();

if ($argc !== 4) {
    $scriptName = basename(__FILE__);
    echo <<<MARCA_FIN

    Usage: $scriptName <Username> <Email> <Password>

MARCA_FIN;
    exit(1);
}

$username = $argv[1];
$email = $argv[2];
$password = $argv[3];

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

$user = new User($username, $email, $hashedPassword);

try {
    $entityManager->persist($user);
    $entityManager->flush();
    echo 'User added successfully.' . PHP_EOL;
    echo 'User ID: ' . $user->getId() . PHP_EOL;
} catch (Throwable $exception) {
    echo 'Error adding user: ' . $exception->getMessage() . PHP_EOL;
}
