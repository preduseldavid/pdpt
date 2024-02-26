<?php

namespace JsonRpc\Driver;

use Dotenv\Dotenv;
use Exception;
use mysqli;

class DatabaseMySQL
{
    /** @var string */
    private string $host;

    /** @var string */
    private string $database;

    /** @var string */
    private string $username;

    /** @var string */
    private string $password;

    /** @var mixed */
    private mixed $conn = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/../..');
        $dotenv->load();

        $this->host = $_ENV['DB_HOST'];
        $this->database = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASS'];

        $this->openConnection();
    }

    public function __destruct()
    {
        $this->closeConnection();
    }

    /**
     * Escape a string value that needs to be used for a Database SQL Query.
     *
     * @param  string  $value
     * The string value that needs to be escaped
     *
     * @return string
     * Returns a string.
     */
    public function escapeString(string $value): string
    {
        return $this->conn->real_escape_string($value);
    }

    /**
     * Run a SQL Query to the database. You can run any type of queries you want
     * but before binding any string value to that query you have to escape the
     * string for dangerous characters to prevent SQL injection.
     *
     * @param  string  $sql
     * The SQL query that needs to be executed
     *
     * @return bool|array|null Returns false if the query fails (any type of query you run)
     * Returns false if the query fails (any type of query you run)
     * Returns true if the query type is INSERT, UPDATE, DELETE, DROP, etc
     *   (no object returned as a result to extract the data)
     * Returns int for an insert, update, delete query type with the last
     *   inserted id or affected rows count
     * Returns array on this SQL operations: SELECT, SHOW, DESCRIBE or EXPLAIN
     * @throws Exception
     */
    public function runQuery(string $sql): bool|array|null
    {
        if (!$this->conn) {
            throw new Exception("There isn't any connection to the database");
        }
        $result = $this->conn->query($sql);
        if ($result === false) {
            return false;
        } elseif ($result === true) {
            /*
             *   INSERT, UPDATE, DELETE, DROP, etc (no object returned as a result to extract the data)
             */
            $words = explode(' ', trim($sql));
            $type = strtolower($words[0]);
            if ($type == 'insert') {
                $lastId = $this->conn->insert_id;
                return $lastId;
            }
            if ($type == 'update') {
                $lastId = $this->conn->affected_rows;
                return $lastId;
            }
            if ($type == 'delete') {
                $lastId = $this->conn->affected_rows;
                return $lastId;
            }
            return true;
        } elseif (gettype($result) === 'object') {
            /* SELECT, SHOW, DESCRIBE or EXPLAIN */
            $rows = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    array_push($rows, $row);
                }
            }
            return $rows;
        }
        return null;
    }

    /**
     * Open a new connection to the database server
     *
     * @return void
     * No returning value is expected
     * @throws Exception
     */
    private function openConnection(): void
    {
        $conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($conn->connect_error) {
            throw new Exception("Connection to database failed: ".$conn->connect_error);
        }
        $this->conn = $conn;
    }

    /**
     * Close the connection to the database server
     *
     * @return void
     * No returning value is expected
     */
    private function closeConnection(): void
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
