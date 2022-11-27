<?php
    class Paging {

        /**
         * 渲染分頁區塊
         * @param $current_page 當前頁碼
         * @param $total_page 總頁碼數量
         * @param $count 頁碼區塊顯示數量
         * @param $code 班級編碼
         */
        public static function render(int $current_page = 1, int $total_page = 0, int $count = 5, string $code = null) {
            // 上一頁
            $prev = self::getLtOrGtElement($current_page > 1, $current_page - 1, $code);
            // 下一頁
            $next = self::getLtOrGtElement($current_page < $total_page , $current_page + 1, $code, false);
            // 第一頁
            $first = self::getFirstOrLastElement(1, $code, $current_page, $count, $total_page);
            // 最後一頁
            $last = self::getFirstOrLastElement($total_page, $code, $current_page, $count, $total_page);
            // 分頁區塊
            $paging = self::getRangeElement($current_page, $code, $total_page, $count);

            echo "
                <div class='pages'>
                    $prev
                    <div>
                        $first
                        $paging
                        $last
                    </div>
                    $next
                </div>
            ";
        }

        /**
         * 上下頁
         * @param $is_show 是否顯示
         * @param $page 前往的頁碼
         * @param $code 班級編碼
         * @param $is_lt 如果為 true 則顯示左箭頭，反之則顯示右箭頭。
         */
        private static function getLtOrGtElement(bool $is_show, int $page = 1, string $code = null, bool $is_lt = true) :string {
            if (!$is_show) {
                return "<a class='noshow'>&nbsp;</a>";
            }

            return "<a href='?page=$page" . ($code ? "&code=$code" : "") . "'>" . ($is_lt ? "&lt" : "&gt") . ";</a>";
        }

        /**
         * 第一頁或最後一頁頁碼連接
         * @param $page 顯示的頁數，用於顯示第一頁或最後一頁的頁數
         * @param $code 班級編碼
         * @param $current_page 當前頁面的頁數
         * @param $over_page 超過多少頁數則顯示第一頁或者最後一頁的頁碼連接
         * @param $total 總頁數
         */
        private static function getFirstOrLastElement(int $page = 1, string $code = null, int $current_page = 1, int $over_page = 4, int $total = 0) {
            $center = (int) floor($over_page / 2);

            if ((($page === 1 && ($current_page - $page + $center) < $over_page)
                || ($page !== 1 && $page + $center < $current_page + $over_page))
                || $total <= $over_page ) {
                return "";
            }
            
            $result = "<a href='?page=$page" . ($code ? "&code=$code" : ""). "'>$page</a>";

            if ($page === 1) {
                $result .= "...";
            } else {
                $result = "...$result";
            }

            return $result;
        }

        /**
         * 頁碼區
         * @param $page 當前頁碼
         * @param $total 總頁碼數量
         * @param $count 頁碼顯示數量
         */
        private static function getRangeElement(int $page = 1, string $code = null, int $total = 0, int $count = 5) {
            $result = "";
            $center_num = (int) floor(min($total, $count) / 2);
            $start = min($page - $center_num, $total - min($total, $count) + 1);
            $code = $code ? "&code=$code" : "";
            
            for ($idx = 0; $idx < min($total, $count); $idx++) {
                $current_page = $idx + max(1, $start);
                $class = $current_page === $page ? "now" : "";
                $result .= "<a href='?page=$current_page$code' class='$class'>$current_page</a>";
            } 
            return $result;
        }
    }
?>