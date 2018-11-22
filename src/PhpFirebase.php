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
    protected $table = 'records';

    /**
     * The class constructor. We get our firebase database ready here.
     *
     * @var string
     */
    public function __construct() {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . Engine::$secretKeyPath);
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->create();

        $this->database = $firebase->getDatabase();
    }

    /**
     * The function creates a table in the firebase datastore.
     *
     * @param string $table
     * @return $this
     */
    public function setTable(string $table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * This function returns all records
     *
     * @return mixed
     */
    public function getRecords(){
        return $this->database->getReference($this->table)->getValue();
    }

    /**
     * This function returns a specific record by id
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
     * This function adds new records|record
     * It will return this or inserted records if $returnData is set true.
     *
     * @param array $data
     * @param bool $returnData
     * @return $this|mixed
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
     * This function updates a record
     * It will return updated records
     *
     * @param int $recordID
     * @param array $data
     * @return array
     */
    public function updateRecord(int $recordID, array $data)
    {
        $records = $this->getRecords();
        foreach ($records as $key => $record) {
            if ($recordID == $record['id']) {
                foreach ($data as $dataKey => $dataValue) {
                    if (isset($record[$dataKey])) {
                        $record[$dataKey] = $dataValue;
                    }
                }

                $this->database->getReference()
                    ->getChild($this->table)
                    ->getChild($key)
                    ->set($record);
            }
        }

        return $this->getRecords();
    }

    /**
     * This function deletes a record from your database.
     * It will return boolean after action was commited
     *
     * @param int $recordID
     * @return bool
     */
    public function deleteRecord(int $recordID) {
        foreach ($this->getRecords() as $key => $record) {
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


