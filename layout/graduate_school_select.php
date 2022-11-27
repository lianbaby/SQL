<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/graduate_school_dao.php";
    
    // 從`graduate_school`t資料表中撈出所有的畢業學生資料並在網頁上製作成下拉選單的項目
    class GraduateSchoolSelect {

        /**
         * 顯示畢業學校 select
         * 
         */
        public static function render(string|null $graduate_school_id = null, array|string|null $html_attribute = null) {
            $graduateSchoolDao = new \db\GraduateSchoolDao();
            $graduateSchoolList = $graduateSchoolDao->findAll();
            
            if (is_array($html_attribute)) {
                $str = "";
                foreach ($html_attribute as $attr => $value) {
                    $str .= " $attr='$value'";
                }
                $html_attribute = $str;
            }

            $html = "<select" . ($html_attribute ?? "") . ">";
            
            foreach ($graduateSchoolList as $graduateSchool) {
                $selected = ($graduateSchool->id === $graduate_school_id) ? "selected" : "";
                $html .= "<option value='{$graduateSchool->id}' $selected>{$graduateSchool->county}{$graduateSchool->name}</option>";
            }

            $html .= "</select>";

            echo $html;
        }
    }
?>