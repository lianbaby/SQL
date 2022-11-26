<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/db/classes_dao.php";;
    class ClassNav {

        public static function renderAndGetDefaultCode(string $code = null) :mixed {
            $classesDao = new \db\ClassesDao();
            $classes = $classesDao->findAll();
            
            $li = "";
            $default_code = $code ?? (empty($classes) ? null :  $classes[0]->code);

            foreach($classes as $class){
                $cls = '';
                if ($class->code === $default_code) {
                    $cls = 'active';
                }
                $li .= "<li class='$cls'><a href='?code={$class->code}'>{$class->name}</a></li>";
            }

            echo "
                <nav>
                    <ul class='class-list'>
                        $li
                    </ul>
                </nav>
            ";

            return $default_code;
        }
    }

?>
