Apriori data transormation
==========================

To run the project:

       * install composer from https://getcomposer.org/download/
       * run composer install

       * Create a database called apriori-transformation.
       
Position yourself into src directory of the project and run the following command: 

       * vendor/bin/doctrine orm:schema-tool:create
       
If you want to remove all data from database run:

        *  vendor/bin/doctrine orm:schema-tool:drop --force
        *  vendor/bin/doctrine orm:schema-tool:create

To import data from csv into database, go to localhost/import.php and follow instructions.

       