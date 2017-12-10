<html>
<head>
    <title>Import .csv file to db</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
</head>
<body>
<div style="padding: 10%">
    <h1> CSV to Mysql </h1>
    <p> This script will import alarms.csv into the database</p>

    </br>
    <form class="form-horizontal" action="import.php" method="post">
        <div class="form-group">
            <label for="mysql" class="control-label col-xs-2">Mysql Server address (or)<br>Host name</label>
            <div class="col-xs-3">
                <input type="text" class="form-control" name="mysql" id="mysql" placeholder="">
            </div>
            (localhost)
        </div>

        <div class="form-group">
            <label for="username" class="control-label col-xs-2">Username</label>
            <div class="col-xs-3">
                <input type="text" class="form-control" name="username" id="username" placeholder="">
            </div>
            (root)
        </div>

        <div class="form-group">
            <label for="password" class="control-label col-xs-2">Password</label>
            <div class="col-xs-3">
                <input type="text" class="form-control" name="password" id="password" placeholder="">
            </div>
            (root)
        </div>

        <div class="form-group">
            <label for="db" class="control-label col-xs-2">Database name</label>
            <div class="col-xs-3">
                <input type="text" class="form-control" name="db" id="db" placeholder="">
            </div>
            (apriori-transformation)
        </div>

        <div class="form-group">
            <label for="table" class="control-label col-xs-2">table name</label>
            <div class="col-xs-3">
                <input type="name" class="form-control" name="table" id="table">
            </div>
            (alarm)
        </div>
        <div class="form-group">
            <label for="csvfile" class="control-label col-xs-2">Name of the file</label>
            <div class="col-xs-3">
                <input type="name" class="form-control" name="csv" id="csv">
            </div>
            (alarms.csv)
        </div>
        <div class="form-group">
            <label for="login" class="control-label col-xs-2"></label>
            <div class="col-xs-3">
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </div>
    </form>


    <?php

    if (isset($_POST['username']) && isset($_POST['mysql']) && isset($_POST['db']) && isset($_POST['username'])) {
        $sqlname = $_POST['mysql'];
        $username = $_POST['username'];
        $table = $_POST['table'];
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
        } else {
            $password = '';
        }
        $db = $_POST['db'];
        $file = $_POST['csv'];
        $cons = mysqli_connect("$sqlname", "$username", "$password", "$db") or die(mysql_error());

        mysqli_query(
            $cons,
            '
    LOAD DATA LOCAL INFILE "'.$file.'"
        INTO TABLE '.$table.'
        FIELDS TERMINATED by \',\'
        LINES TERMINATED BY \'\n\'
'
        ) or die(mysql_error());

        $result2 = mysqli_query($cons, "select count(*) count from $table");
        $r2 = mysqli_fetch_array($result2);
        $count = (int)$r2['count'];

        if ($count != 0) {
            echo "<b> total $count records have been added to the table $table </b> ";
        }


    } else {
        echo "Mysql Server address/Host name ,Username , Database name ,Table name , File name are the Mandatory Fields";
    }

    ?>
    <h3> Instructions </h3>
    1. Keep this php file and Your csv file in one folder <br>
    2. Create a table in your mysql database to which you want to import <br>
    3. Open the php file from your localhost server <br>
    4. Enter all the fields <br>
    5. click on upload button  </p>
</div>
</body>
</html>