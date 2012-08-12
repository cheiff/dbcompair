<?php
include("dbcompair.php");
include("dbcompair_database_tables.php");


$compair_tables = new compair_tables();

$diff = $compair_tables->execute();


var_dump($diff);