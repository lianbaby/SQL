<?php
     namespace db;

     require_once $_SERVER["DOCUMENT_ROOT"] . "/db/base_dao.php";
     require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/status.php";
 
     use entity\Status;
    
     class StatusDao extends BaseDao {
        protected function getTableName() :string {
            return "status";
        }

        public function findAll() {
            return $this->fetchAll("entity\Status");
        }
     }

?>