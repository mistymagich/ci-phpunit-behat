<?php

/**
 * UsersTest 
 * 
 */
class UsersTest extends CI_PHPUnit_Extensions_Database_TestCase
{
    private $users;

    public function setUp() {
        parent::setUp();

        $this->users = new Users_model;
    }

    public function testGetUser() {
        $user = $this->users->get(1);

        $this->assertEquals(1, $user->id);
        $this->assertEquals('User1', $user->name);
    }

    public function testGetUsers() {
        $users = $this->users->all();
        $this->assertCount(2, $users);
    }

    public function testAddUser() {
        $id = $this->users->add('User3');

        $queryTable = $this->getConnection()->createQueryTable(
            'users',
            "SELECT * FROM users WHERE id=$id"
        );
        $row = $queryTable->getRow(0);
        $this->assertEquals($id, $row['id']);
        $this->assertEquals('User3', $row['name']);
    }

    public function testEditUser() {
        $user = $this->users->get(1);
        $user->name = 'User1New';

        $this->users->update($user);

        $queryTable = $this->getConnection()->createQueryTable(
            'users',
            "SELECT * FROM users WHERE id=1"
        );
        $row = $queryTable->getRow(0);
        $this->assertEquals(1, $row['id']);
        $this->assertEquals('User1New', $row['name']);
    }

    public function testDeleteUser() {
        $this->users->delete(2);

        $queryTable = $this->getConnection()->createQueryTable(
            'users',
            "SELECT * FROM users"
        );
        $num = $queryTable->getRowCount();
        $this->assertEquals(1, $num);
    }
}
