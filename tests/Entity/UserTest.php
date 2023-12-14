<?php

/**
 * tests/Entity/UserTest.php
 *
 * @category EntityTests
 * @package  MiW\Results\Tests
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://www.etsisi.upm.es/ ETS de Ingeniería de Sistemas Informáticos
 */

namespace MiW\Results\Tests\Entity;

use MiW\Results\Entity\User;

/**
 * Class UserTest
 *
 * @package MiW\Results\Tests\Entity
 * @group   users
 */
class UserTest extends \PHPUnit\Framework\TestCase
{
    private User $user;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp(): void
    {
        $this->user = new User();
    }

    /**
     * @covers \MiW\Results\Entity\User::__construct()
     */
    public function testConstructor(): void
    {
        $this->assertInstanceOf(User::class, $this->user);
    }

    /**
     * @covers \MiW\Results\Entity\User::getId()
     */
    public function testGetId(): void
    {
        self::assertSame(0, $this->user->getId());
    }

    /**
     * @covers \MiW\Results\Entity\User::setUsername()
     * @covers \MiW\Results\Entity\User::getUsername()
     */
    public function testGetSetUsername(): void
    {
        $username = 'zzz';
        $this->user->setUsername($username);
        self::assertSame($username, $this->user->getUsername());
    }

    /**
     * @covers \MiW\Results\Entity\User::getEmail()
     * @covers \MiW\Results\Entity\User::setEmail()
     */
    public function testGetSetEmail(): void
    {
        $email = 'zzz123@example.com';
        $this->user->setEmail($email);
        self::assertSame($email, $this->user->getEmail());
    }

    /**
     * @covers \MiW\Results\Entity\User::setEnabled()
     * @covers \MiW\Results\Entity\User::isEnabled()
     */
    public function testIsSetEnabled(): void
    {
        $this->user->setEnabled(true);
        self::assertTrue($this->user->isEnabled());
    }

    /**
     * @covers \MiW\Results\Entity\User::setIsAdmin()
     * @covers \MiW\Results\Entity\User::isAdmin
     */
    public function testIsSetAdmin(): void
    {
        $this->user->setIsAdmin(true);
        self::assertTrue($this->user->isAdmin());
    }

    /**
     * @covers \MiW\Results\Entity\User::setPassword()
     * @covers \MiW\Results\Entity\User::validatePassword()
     */
    public function testSetValidatePassword(): void
    {
        $password = 'zzz123password';
        $this->user->setPassword($password);
        self::assertTrue($this->user->validatePassword($password));
    }

    /**
     * @covers \MiW\Results\Entity\User::__toString()
     */
    public function testToString(): void
    {
        self::assertIsString((string) $this->user);
    }

    /**
     * @covers \MiW\Results\Entity\User::jsonSerialize()
     */
    public function testJsonSerialize(): void
    {
        $json = $this->user->jsonSerialize();
        self::assertIsArray($json);
        self::assertArrayHasKey('id', $json);
        self::assertArrayHasKey('username', $json);
        self::assertArrayHasKey('email', $json);
        self::assertArrayHasKey('enabled', $json);
        self::assertArrayHasKey('admin', $json);
    }
}
