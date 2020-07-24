<?php

class DatabaseMysql
{
    private $dbHost="localhost";
    private $dbUser= "root";
    private $dbPass="";
    private $dbName="books";

    //Create Connection

    public function ConnectionDB()
    {
        $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName"; 
        $dbConnection=new PDO($mysqlConnect,$this->dbUser,$this->dbPass);
        $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConnection;
    }
}
