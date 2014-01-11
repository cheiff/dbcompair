<?php
include("dbcompare.php");
include("dbcompare_compare_tables.php");


$compare_tables = new compare_tables();
$compare_tables->findDifference();
$compare_tables->buildCreateTablesQuery();
$compare_tables->saveCreateTablesQuery();
$compare_tables->migrateTables();

//$compare_tables->buildInsertIntoQuery();
