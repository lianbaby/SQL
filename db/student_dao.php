<?php
    namespace db;

    require_once ($_SERVER["DOCUMENT_ROOT"] . "/db/base_dao.php");
    require_once ($_SERVER["DOCUMENT_ROOT"] . "/entity/student.php");

    use entity\Student;

    class StudentDao extends BaseDao {
        
        protected function getTableName() :string {
            return "students";
        }

        public function findAll(int|null $offset = null, int|null $limit = null) :array {
            return $this->fetchAll("entity\Student", null, [], $offset, $limit);
        }

        public function findAllByClassCode(string $class_code, int|null $offset = null, int|null $limit = null) :array {
            $sql = "
                SELECT 
                    `students`.`id`,
                    `students`.`school_num`,
                    `students`.`name`,
                    `students`.`birthday`,
                    `students`.`graduate_at`
                FROM {$this->getTableName()}
                LEFT JOIN class_student
                ON class_student.school_num = {$this->getTableName()}.school_num
                WHERE class_code = :class_code
            ";
            return $this->fetchAll("entity\Student", $sql, [ "class_code" => $class_code ], $offset, $limit);
        }

        public function findOne(int $id) :Student {
            return $this->fetchOne("entity\Student", null, [ "id" => $id ]);
        }

        public function countByClassCode(string $class_code) :int {
            $sql = " 
                SELECT COUNT(*) 
                FROM {$this->getTableName()}
                LEFT JOIN class_student 
                ON class_student.school_num = {$this->getTableName()}.school_num
                WHERE class_code = :class_code
            ";

            return $this->fetchColumn($sql, [ "class_code" => $class_code ]);
        }

        public function create(Student $student) :bool {
            return $this->insert($student);
        }

        public function modify(Student $student) :bool {
            return $this->update($student);
        }

        public function getMaxSchoolNum() {
            $sql = " SELECT MAX(school_num) FROM {$this->getTableName()}";
            return $this->fetchColumn($sql);
        }
    }
?>