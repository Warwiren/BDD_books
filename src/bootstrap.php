<?php
session_start();

function custom_autoloader($classname){
    include 'src/'. $classname .'.php';
}
spl_autoload_register('custom_autoloader');
include_once __DIR__ . '/../vendor/autoload.php';
?>