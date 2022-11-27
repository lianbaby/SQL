<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/classes_dao.php";
    
    // 從`classes`資料表中撈出所有的班級資料並在網頁上製作成下拉選單的項目
    class ClassSelect {

        /**
         * 顯示畢業學校 select
         * 
         */
        public static function render(string|null $class_code = null, array|string|null $html_attribute = null) {
            $classesDao = new \db\ClassesDao;
            $classes = $classesDao->findAll();
            
            if (is_array($html_attribute)) {
                $str = "";
                foreach ($html_attribute as $attr => $value) {
                    $str .= " $attr='$value'";
                }
                $html_attribute = $str;
            }

            $html = "<select" . ($html_attribute ?? "") . ">";
            
            foreach ($classes as $class) {
                $selected = ($class->code === $class_code) ? "selected" : "";
                $html .= "<option value='{$class->code}' $selected>{$class->name}</option>";
            }

            $html .= "</select>";

            echo $html;
        }
    }
?>