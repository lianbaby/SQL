<?php
     namespace db;

     require_once $_SERVER["DOCUMENT_ROOT"] . "/db/base_dao.php";
     require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/dept.php";
 
     use entity\Dept;

     class DeptDao extends BaseDao {
        protected function getTableName() :string {
            return "dept";
        }

        protected function getPrimaryColumnName() :string {
            return "id";
        }

        public function findAll() {
            return $this->fetchAll("entity\Dept", null, []);
        }
     }

?>