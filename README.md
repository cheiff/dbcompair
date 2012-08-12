dbcompair
=========

Object Oriented PHP project which will compair two databases for changes

/*
base file which is used to extend the classes for other scripts
*/
dbcompair.php

compair tables
==============

This file will list all the tables from db1 and db2 find out the changes
of tables. 

	* which tables are missing in db1
	* which tables are missing in db2
	* create a string to dump a sql file
		* create table script
		* alter table script

dbcompair_compair_tables.php

/**TODO**/

compair data
============

This file will identify the key of the table, compair data of the 
two tables of two databases.identity the different columns and 
create a html file with checkboxes for the user to select which 
changes are the latest

dbcompair_compair_data.php
