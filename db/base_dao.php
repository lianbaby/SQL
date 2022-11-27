<?php
    namespace db;

    abstract class BaseDao {
        const TYPES = array(
            "boolean" => \PDO::PARAM_BOOL,
            "integer" => \PDO::PARAM_INT,
            "double" => \PDO::PARAM_INT,
            "string" => \PDO::PARAM_STR
        );

        // 資料庫連接地址
        const HOST = "localhost";
        // 資料庫名稱
        const DB = "schools";
        // 資料庫使用者名稱
        const USERNAME = "root";
        // 資料庫使用者密碼
        const PASSWORD = "root";

        protected $conn;

        protected abstract function getTableName() :string ;

        protected function getPrimaryColumnName() :string {
            return "id";
        }

        private $is_transaction = false;

        function __construct() {

            $this->conn = new \PDO(
                "mysql:host=" . self::HOST . ";charset=utf8;dbname=" . self::DB, 
                self::USERNAME, 
                self::PASSWORD
            );
        }

        protected function fetchAll(string $class,string $sql = null, array|object $values = [], int|null $offset = null, int|null $limit = null) {
            if (is_object($values)) {
                $values = get_object_vars($values);
            }

            if (!$sql) {
                $sql = " SELECT * FROM {$this->getTableName()} WHERE 1 = 1 ";
                foreach ($values as $key => $value) {
                    $sql .= " AND $key = :$key ";
                }
            }

            if ($offset !== null && $limit !== null) {
                $sql .= " LIMIT :offset, :limit ";
            }

            $statement = $this->conn->prepare($sql);

            if ($offset !== null && $limit !== null) {
                $statement->bindValue("offset", $offset, \PDO::PARAM_INT);
                $statement->bindValue("limit", $limit, \PDO::PARAM_INT);
            }

            self::bindValues($statement, $values);

            $statement->execute();

            return $statement->fetchAll(\PDO::FETCH_CLASS, $class);
        }

        protected function fetchOne(string $class, string $sql = null, array|object $values = []) {
            if (is_object($values)) {
                $values = get_object_vars($values);
            }

            if (!$sql) {
                $sql = " SELECT * FROM {$this->getTableName()} WHERE 1 = 1 ";
                foreach ($values as $key => $value) {
                    $sql .= " AND $key = :$key ";
                }
            }

            $statement = $this->conn->prepare($sql);

            self::bindValues($statement, $values);

            $statement->execute();

            return $statement->fetchObject($class);
        }

        protected function fetchColumn(string $sql, array $values = [], int $column = 0) {
            $statement = $this->conn->prepare($sql);

            self::bindValues($statement, $values);

            $statement->execute();

            return $statement->fetchColumn($column);
        }

        protected function execute(string $sql, array $values = []) :bool {
            $statement = $this->conn->prepare($sql);

            self::bindValues($statement, $values);

            return $statement->execute();
        }

        public function count(array|object $values = []) :int {
            $sql = "SELECT COUNT(*) FROM {$this->getTableName()} WHERE 1 = 1";
            
            if (!is_array($values)) {
                $values = get_object_vars($values);
            }

            foreach($values as $key => $value) {
                if ($value == null) {
                    continue;
                }

                $sql .= " AND $key = :$key ";
            }
            
            $statement = $this->conn->prepare($sql);

            foreach($values as $key => $value) {
                if ($value == null) {
                    continue;
                }

                $statement->bindValue($key, $value, self::getType($value));
            }

            $statement->execute();

            return $statement->fetchColumn();
        }

        protected function insert(object $obj) {
            $values = [];
            $value_keys = [];
            $column_keys = [];

            foreach(get_object_vars($obj) as $key => $value) {
                if ($key === $this->getPrimaryColumnName()) {
                    continue;
                }
                array_push($column_keys, $key);
                array_push($value_keys, ":$key");

                $values[$key] = $value;
            }

            $sql = " 
                INSERT INTO {$this->getTableName()} 
                (" . join(", ", $column_keys) . ") 
                VALUES (" . join(", ", $value_keys) . ") 
            ";

            return $this->execute($sql, $values);
        }

        protected function update(object $obj) :bool {
            $values = [];
            $column_keys = [];

            foreach(get_object_vars($obj) as $key => $value) {
                if ($key === $this->getPrimaryColumnName() || $value == null) {
                    continue;
                }
                array_push($column_keys, "$key = :$key");
                $values[$key] = $value;
            }

            if (empty($values)) {
                return false;
            }

            $sql = " UPDATE {$this->getTableName()} SET " . join(", ", $column_keys)
                . " WHERE {$this->getPrimaryColumnName()} = :primary "
            ;

            $values['primary'] = $obj->{$this->getPrimaryColumnName()};
            return $this->execute($sql, $values);
        }

        public function delete(array|object|int|string $obj) :bool {
            $sql = " DELETE FROM {$this->getTableName()} ";
            $values = [];

            if (is_int($obj) || is_string($obj)) {
                $sql .= " WHERE {$this->getPrimaryColumnName()} = :primary ";
                $values["primary"] = $obj;
            } else {
                $sql .= " WHERE 1 = 1 ";

                if (!is_array($obj)) {
                    $obj = get_object_vars($obj);
                }
                foreach ($obj as $key => $value) {
                    if (!$value) {
                        continue;
                    }
    
                    $sql .= " && $key = :$key ";
                    $values[$key] = $value;
                }
            }

            return $this->execute($sql, $values);
        }

        protected static function getType($param) {
            return self::TYPES[\gettype($param)] ?: \PDO::PARAM_STMT;
        }

        private static function bindValues(\PDOStatement $statement, array $values) {
            foreach ($values as $key => $value) {
                $statement->bindValue($key, $value, self::getType($value));
            }
        }

        public function beginTransaction() :bool {
            return ($this->is_transaction = $this->conn->beginTransaction());
        }

        public function commit() :bool {
            if (!$this->is_transaction) {
                return $this->is_transaction;
            }

            return $this->conn->commit();
        }

        public function rollback() :bool {
            if (!$this->is_transaction) {
                return $this->is_transaction;
            }
            
            return $this->conn->rollBack();
        }
    }
?>