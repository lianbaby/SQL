<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/status_dao.php";
    
    // 從`status`資料表中撈出所有的畢業狀態並在網頁上製作成下拉選單的項目
    class StatusSelect {

        /**
         * 顯示畢業狀態 select
         * 
         */
        public static function render(string|null $status_code = null, array|string|null $html_attribute = null) {
            $statusDao = new \db\StatusDao;
            $statusList = $statusDao->findAll();
            
            if (is_array($html_attribute)) {
                $str = "";
                foreach ($html_attribute as $attr => $value) {
                    $str .= " $attr='$value'";
                }
                $html_attribute = $str;
            }

            $html = "<select" . ($html_attribute ?? "") . ">";
            
            foreach ($statusList as $status) {
                $selected = ($status->code === $status_code) ? "selected" : "";
                $html .= "<option value='{$status->code}' $selected>{$status->status}</option>";
            }

            $html .= "</select>";

            echo $html;
        }
    }
?>