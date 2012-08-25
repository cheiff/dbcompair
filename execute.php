<?php
include("dbcompair.php");
include("dbcompair_compair_tables.php");


$compair_tables = new compair_tables();
$compair_tables->findDifference();
$compair_tables->buildCreateTablesQuery();
$compair_tables->saveCreateTablesQuery();
$compair_tables->buildInsertIntoQuery();
