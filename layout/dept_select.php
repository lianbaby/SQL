<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/dept_dao.php";
    
    //從`dept`資料表中撈出所有的科系資料並在網頁上製作成下拉選單的項目
    class DeptSelect {

        /**
         * 顯示科別 select
         * 
         */
        public static function render(string|null $dept_id = null, array|string|null $html_attribute = null) {
            $deptDao = new \db\DeptDao();
            $deptList = $deptDao->findAll();
            
            if (is_array($html_attribute)) {
                $str = "";
                foreach ($html_attribute as $attr => $value) {
                    $str .= " $attr='$value'";
                }
                $html_attribute = $str;
            }

            $html = "<select" . ($html_attribute ?? "") . ">";
            
            foreach ($deptList as $dept) {
                $selected = ($dept->id === $dept_id) ? "selected" : "";
                $html .= "<option value='{$dept->id}' $selected>{$dept->name}</option>";
            }

            $html .= "</select>";

            echo $html;
        }
    }
?>