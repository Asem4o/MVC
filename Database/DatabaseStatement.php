<?php
namespace Database;

class DatabaseStatement implements DatabaseStatementInterface
{
    private $pdoStmt;

    public function __construct(\PDOStatement $pdoStmt)
    {
        $this->pdoStmt = $pdoStmt;
    }


    public function execute(array $params = []): DatabaseStatementInterface
    {
        $this->pdoStmt->execute($params);
        return $this;
    }

    public function fetch($className)
    {
       $res = $this->pdoStmt->fetchObject($className);

       if ($res){
           return $res;
       }
       return  null;
    }
    public function fetchAll($className)
    {
        // Ensure $className is a string
        $className = (string) $className;

        $res = $this->pdoStmt->fetchAll(\PDO::FETCH_CLASS, $className);

        if ($res) {
            return $res;
        }

        return [];
    }





}