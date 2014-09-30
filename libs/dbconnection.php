<?php

class dbconnection {
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $db = 'kehadiran';

    protected $connection;

    public function __construct($host, $user, $password, $db) {
        $this->connection = new mysqli(
            $this->host,
            $this->user,
            $this->passwd,
            $this->db
        );

        if ($this->connection->connect_error) {
          trigger_error('Database connection failed: '  . $this->connection->connect_error, E_USER_ERROR);
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
