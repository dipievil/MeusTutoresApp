<?php
include_once('../model/model.user.php');

interface UserRepositoryInterface
{
    public function find($id);
    public function save(User $user);
    public function remove(User $user);
}

//class UserMapper extends MapperAbstract
//{
//    public $tableName = 'user';
//
//    /**
//     * Fetch a user object by ID
//     *
//     * An example skeleton of a "Fetch" function showing
//     * how the database data ($dataFromDb) is used to
//     * create a new User instance via the create function.
//     *
//     * @param string $id
//     * @return User
//     */
//    public function findById($id)
//    {
//        $dbQueries = new classQuery();
//
//        $arWheres = array("id"=>"'".$id."'");
//        $arQuery = $dbQueries->SelectQueryInArray($arWheres,$this->$tableName);
//
//        return $this->create($arQuery);
//    }
//
//    /**
//     * Populate the User (DomainObject) with
//     * the data array.
//     *
//     * This is a very simple example, but the interface
//     * can be as complex as required.
//     *
//     * @param DomainObjectAbstract $obj
//     * @param array $data
//     * @return User
//     */
//    public function populate(DomainObjectAbstract $obj, array $data)
//    {
//         $obj->setId($data['id']);
//         $obj->firstname = $data['user'];
//         $obj->firstname = $data['tipo'];
//         $obj->firstname = $data['nome'];
//         $obj->firstname = $data['facebookid'];
//         $obj->firstname = $data['email'];
//         $obj->firstname = $data['pass'];
//         $obj->firstname = $data['points'];
//         $obj->firstname = $data['flag'];
//         $obj->firstname = $data['date'];
//         $obj->firstname = $data['ativo'];
//         return $obj;
//    }
//
//    /**
//     * Create a new User DomainObject
//     *
//     * @return User
//     */
//    protected function _create()
//    {
//        return new User();
//    }
//
//    /**
//     * Insert the DomainObject in persistent storage
//     *
//     * This may include connecting to the database
//     * and running an insert statement.
//     *
//     * @param DomainObjectAbstract $obj
//     */
//    protected function _insert(DomainObjectAbstract $obj)
//    {
//
//
//
//    }
//
//    /**
//     * Update the DomainObject in persistent storage
//     *
//     * This may include connecting to the database
//     * and running an update statement.
//     *
//     * @param DomainObjectAbstract $obj
//     */
//    protected function _update(DomainObjectAbstract $obj)
//    {
//        // ...
//    }
//
//    /**
//     * Delete the DomainObject from persistent storage
//     *
//     * This may include connecting to the database
//     * and running a delete statement.
//     *
//     * @param DomainObjectAbstract $obj
//     */
//    protected function _delete(DomainObjectAbstract $obj)
//    {
//        // ...
//    }
//}
