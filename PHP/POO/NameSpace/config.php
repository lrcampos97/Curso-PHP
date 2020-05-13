<?php

    // Registrar as minhas classes
    spl_autoload_register(function($nameClass){
        
        $dirClass = "class";
        $fileName = $dirClass . DIRECTORY_SEPARATOR . $nameClass . ".php";

        if (file_exists($fileName)){
            require_once($fileName);
        }
    })

?>