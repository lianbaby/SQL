<?php
    namespace db;

    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/base_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/classes.php";

    use entity\Classes;

    class ClassesDao extends BaseDao {
        protected function getTableName() :string {
            return "classes";
        }

        public function findAll() {
            return $this->fetchAll("entity\Classes");
        }
    }
?>