<?php
    namespace db;

    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/base_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/graduate_school.php";

    use entity\GraduateSchool;

    class GraduateSchoolDao extends BaseDao {
        protected function getTableName() :string {
            return "graduate_school";
        }

        public function findAll() {
            return $this->fetchAll("entity\GraduateSchool", null, []);
        }
    }
?>