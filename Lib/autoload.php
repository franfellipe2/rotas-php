<?php

spl_autoload_register(function($class) {

       $fileName = 'Lib/' . $class . '.php';       
       if (file_exists($fileName)) {              
              require_once $fileName;
       } else {
              echo '<p>A class <b>'.$class.'</b>não existe!</p>';
       }
});
