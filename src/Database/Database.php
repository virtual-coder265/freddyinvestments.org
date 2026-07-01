<?php

namespace App\Database;



/**

 * MySQL Database Connection Manager

 * Handles database initialization, queries, and transaction management

 */

class Database {

    protected static $instance = null;

    protected $connection;



    private function __construct() {

        $this->connect();

    }



    /**

     * Get singleton instance of database

     */

    public static function getInstance() {

        if (self::$instance === null) {

            self::$instance = new self();

        }

        return self::$instance;

    }



    /**

     * Reset singleton (useful for setup scripts after creating the database)

     */

    public static function resetInstance() {

        self::$instance = null;

    }



    /**

     * Create the configured database if it does not exist (local setup helper).

     */

    public static function ensureDatabaseExists() {

        $database = self::databaseName();

        $charset = env('DB_CHARSET', 'utf8mb4');

        $collation = env('DB_COLLATION', 'utf8mb4_unicode_ci');



        $pdo = new \PDO(

            self::buildDsn(false),

            env('DB_USERNAME', 'root'),

            env('DB_PASSWORD', ''),

            [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]

        );



        $pdo->exec(

            "CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET {$charset} COLLATE {$collation}"

        );

    }



    /**

     * Establish MySQL connection

     */

    protected function connect() {

        try {

            $this->connection = new \PDO(

                self::buildDsn(true),

                env('DB_USERNAME', 'root'),

                env('DB_PASSWORD', ''),

                [

                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,

                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,

                    \PDO::ATTR_EMULATE_PREPARES => false,

                ]

            );



            $charset = env('DB_CHARSET', 'utf8mb4');
            if (!preg_match('/^[A-Za-z0-9_]+$/', $charset)) {
                $charset = 'utf8mb4';
            }
            $this->connection->exec("SET NAMES {$charset}");
            $this->connection->exec('SET FOREIGN_KEY_CHECKS = 1');

        } catch (\PDOException $e) {

            error_log('Database connection failed: ' . $e->getMessage());

            throw new \Exception('Unable to connect to database');

        }

    }



    /**

     * Build a MySQL PDO DSN from environment configuration.

     */

    protected static function buildDsn($includeDatabase = true) {

        $host = env('DB_HOST', '127.0.0.1');

        $port = env('DB_PORT', '3306');

        $charset = env('DB_CHARSET', 'utf8mb4');

        $dsn = "mysql:host={$host};port={$port};charset={$charset}";



        if ($includeDatabase) {

            $dsn .= ';dbname=' . self::databaseName();

        }



        return $dsn;

    }



    /**

     * Resolve and validate the configured database name.

     */

    protected static function databaseName() {

        $database = env('DB_DATABASE', 'freddy_investments');



        if (!preg_match('/^[A-Za-z0-9_]+$/', $database)) {

            throw new \InvalidArgumentException('Invalid database name in DB_DATABASE');

        }



        return $database;

    }



    /**
     * Execute a prepared statement
     */

    public function execute($query, $params = []) {

        try {

            $stmt = $this->connection->prepare($query);

            $stmt->execute($params);

            return $stmt;

        } catch (\PDOException $e) {

            error_log('Database error: ' . $e->getMessage());

            throw new \Exception('Database operation failed');

        }

    }



    /**

     * Fetch single row

     */

    public function fetch($query, $params = []) {

        return $this->execute($query, $params)->fetch();

    }



    /**

     * Fetch all rows

     */

    public function fetchAll($query, $params = []) {

        return $this->execute($query, $params)->fetchAll();

    }



    /**

     * Insert record and return last insert ID

     */

    public function insert($table, $data) {

        $columns = implode(', ', array_keys($data));

        $placeholders = implode(', ', array_fill(0, count($data), '?'));



        $query = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";

        $this->execute($query, array_values($data));



        return $this->connection->lastInsertId();

    }



    /**

     * Update records

     */

    public function update($table, $data, $where, $whereParams = []) {

        $sets = implode(', ', array_map(fn($k) => "{$k} = ?", array_keys($data)));

        $query = "UPDATE {$table} SET {$sets} WHERE {$where}";



        $params = array_merge(array_values($data), $whereParams);

        $this->execute($query, $params);

    }



    /**

     * Delete records

     */

    public function delete($table, $where, $params = []) {

        $query = "DELETE FROM {$table} WHERE {$where}";

        $this->execute($query, $params);

    }



    /**

     * Get count of records

     */

    public function count($table, $where = '', $params = []) {

        $query = "SELECT COUNT(*) as count FROM {$table}";

        if ($where) {

            $query .= " WHERE {$where}";

        }



        $result = $this->fetch($query, $params);

        return (int) ($result['count'] ?? 0);

    }



    /**

     * Check whether a table has a specific column.

     */

    public function hasColumn($table, $column) {

        if (!preg_match('/^[A-Za-z0-9_]+$/', $table) || !preg_match('/^[A-Za-z0-9_]+$/', $column)) {

            return false;

        }



        $result = $this->fetch(

            'SELECT COUNT(*) AS count

             FROM information_schema.COLUMNS

             WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND COLUMN_NAME = ?',

            [self::databaseName(), $table, $column]

        );



        return ((int) ($result['count'] ?? 0)) > 0;

    }



    /**

     * Start transaction

     */

    public function beginTransaction() {

        $this->connection->beginTransaction();

    }



    /**

     * Commit transaction

     */

    public function commit() {

        $this->connection->commit();

    }



    /**

     * Rollback transaction

     */

    public function rollback() {

        $this->connection->rollBack();

    }



    /**

     * Get raw PDO connection for advanced operations

     */

    public function getConnection() {

        return $this->connection;

    }



    /**

     * Prevent cloning

     */

    private function __clone() {}



    /**

     * Prevent serialization

     */

    public function __wakeup() {}

}

