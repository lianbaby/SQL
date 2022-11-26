<?php
    namespace db;

    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/base_dao.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/entity/class_student.php";

    use entity\ClassStudent;

    class ClassStudentDao extends BaseDao {

        protected function getTableName() :string {
            return "class_student";
        }

        /**
         * 根據班級編號獲取最大的座號
         * @param @class_code 班級編號
         */
        public function getMaxSeatNumByClassCode(string $class_code) :int {
            $sql = " 
                SELECT MAX(seat_num) FROM {$this->getTableName()}
                WHERE class_code = :class_code
            ";

            return $this->fetchColumn($sql, [ "class_code" => $class_code ]);
        }

        /**
         * 創建
         */
        public function create(ClassStudent $class_student) {
            return $this->insert($class_student);
        }

        public function modify(ClassStudent $class_student) {
            return $this->update($class_student);
        }

        public function findAll() {
            return $this->fetchAll("entity\ClassStudent");
        }

        public function findOneBySchoolNum(int $school_num) :ClassStudent {
            return $this->fetchOne("entity\ClassStudent", null, [ "school_num" => $school_num ]);
        }
    }
?>