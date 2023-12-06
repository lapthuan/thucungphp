<?php



class DBConnectionPG
{
    public $connPG;
    public $conn;
    public function __construct()
    {

        if (!isset($this->connPG)) {
            $this->connPG = pg_connect("host=localhost dbname=qlchtatc user=lapthuan password=123456");

            if (!$this->connPG) {
                echo 'Cannot connect to database server';

            }
        }
        if (!isset($this->conn)) {
            $serverName = "LAPTHUAN";
            $connectionInfo = array("Database" => "QLCHTATC", "UID" => "sa", "PWD" => "123456", 'CharacterSet' => 'UTF-8');

            $this->conn = sqlsrv_connect($serverName, $connectionInfo);

            if (!$this->conn) {
                echo 'Cannot connect to database server';

            }
        }
    }

}
