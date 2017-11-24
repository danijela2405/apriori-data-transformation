Apriori data transormation
==========================

To run the project:

       * install composer from https://getcomposer.org/download/
       * run composer install

To import data from csv into database, position yourself into src/ directory and run:

       * php import.php
       
If you run out of memory while loading data, run the command in the following way:

       * php -d memory_limit=-1 import.php
       
To export data from database into csv, position yourself into src/ directory and run:

       * php export.php
       