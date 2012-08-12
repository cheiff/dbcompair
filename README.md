dbcompair
=========

Object Oriented PHP project which will compair two databases for changes

base
====

base file which is used to extend the classes for other scripts. which 
will manage the connect settings

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


CHECKLIST
=========

Stage 1
-------
* list all the tables in db 1
* list all the tables in db 2
* find which tables are in db1 and NOT in db2
* find which tables are in db2 and NOT in db1
* create a text file to create missing tables in db1
* create a text file to create missing tables in db2
* loop through all the tables in db1
* compare the columns in each table
* identify the difference and create alter table queries
Stage 2
-------
* identify the key (which has the auto increment)
* if there.s no auto increment, it will identify the foreign keys
* get the key and query that row from the other db
* list all the changes in the row
* create a update query
* list all the missing records
* create a insert query
Stage 3
-------
* create backups of the database 1
* create backups of the database 2
* run the queries in dbs
