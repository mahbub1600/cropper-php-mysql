<?php
spl_autoload_register(function ($class) {
    $sources = array("..".DS."vendor\\libs\\$class.php", "..".DS.PROJECT_FOLDER."\\Modules\\$class.php");
    foreach ($sources as $source) {
        if (file_exists($source)) {
            require_once $source;
        }
    }
});