<?php
/**
 * Created by PhpStorm.
 * User: dritzel
 * Date: 11/08/2015
 * Time: 15:10
 */

class SQLUserRepository implements UserRepositoryInterface
{
    protected $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function find($id)
    {
        // Find a record with the id = $id
        // from the 'users' table
        // and return it as a User object
        return $this->db->find($id, 'users', 'User');
    }

    public function save(User $user)
    {
        // Insert or update the $user
        // in the 'users' table
        $this->db->save($user, 'users');
    }

    public function remove(User $user)
    {
        // Remove the $user
        // from the 'users' table
        $this->db->remove($user, 'users');
    }
}