<?php
/**
 * A simple crud system using php and firebase
 *
 * Creator: Josiah O Yahaha
 * Email: josiahoyahaya@gmail.com
 */

namespace Coderatio\PhpFirebase;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class PhpFirebase {
    protected $database;
    protected $table = 'users';
    /**
     * Please set create your secret key and replace this path to your key.
     *
     * @var string
     */
    public function __construct() {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . Engine::$secretKeyPath);
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();

        $this->database = $firebase->getDatabase();
    }

    public function setTable(string $table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * This function returns all users
     *
     * @return mixed
     */
    public function getRecords(){
        return $this->database->getReference($this->table)
            ->getSnapshot()
            ->getValue();
    }

    /**
     * This function returns a specific user by id
     *
     * @param int $recordID
     * @return null|array
     */
    public function getRecord(int $recordID)
    {
        foreach ($this->getRecords() as $key => $record) {
            if ($record['id'] == $recordID) {
                return $record;
            }
        }

        return null;
    }

    /**
     * This function adds new users|user
     * It will return bool or inserted users
     *
     * @param array $data
     * @param bool $returnData
     * @return bool|mixed
     */
    public function insertRecords(array $data, $returnData = false) {

        foreach ($data as $key => $value){
            $this->database->getReference()
                ->getChild($this->table)
                ->getChild($key)
                ->set($value);
        }

        if ($returnData) {
            return $this->getRecords();
        }

        return $this;
    }

    /**
     * This function updates a user
     * It will return updated data from the users table
     *
     * @param int $recordID
     * @param array $data
     * @return mixed
     */
    public function updateRecords(int $recordID, array $data)
    {
        $records = $this->getRecords();
        foreach ($records as $key => $record) {
            if ($recordID == $record['id']) {
                $data['id'] = $recordID;
                $this->database->getReference()
                    ->getChild($this->table)
                    ->getChild($key)
                    ->set($data);
            }
        }

        return $this->getRecords();
    }

    /**
     * This function deletes a user from your database.
     * It will return boolean after action was commited
     *
     * @param int $recordID
     * @return bool
     */
    public function deleteRecord(int $recordID) {

        $records = $this->getRecords();
        foreach ($records as $key => $record) {
            if ($record['id'] == $recordID) {
                $this->database->getReference()
                    ->getChild($this->table)
                    ->getChild($key)
                    ->set(null);

                return true;
            }
        }

        return false;
    }
}


