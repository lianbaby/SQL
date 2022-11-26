<?php
    namespace db;

    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/base_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/user.php";

    use entity\User;

    class UserDao extends BaseDao {
        protected function getTableName() :string {
            return "users";
        }

        public function findOne(string $acc, string $pw) :User {
            $sql = " 
                SELECT id, acc, name, last_login 
                FROM {$this->getTableName()}
                WHERE acc = :acc
                AND pw = :pw
            ";

            return $this->fetchOne("entity\User", $sql, [ "acc" => $acc, "pw" => $pw ]);
        }

        public function create(User $user) :bool {
            return $this->insert($user);
        }
    }
?>