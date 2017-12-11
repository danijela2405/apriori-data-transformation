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
    <form class="form-horizontal" action="finishedImport.php" method="post" id="uploadForm">
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
                <button type="submit" class="btn btn-primary" id="submit">Upload</button>
            </div>
        </div>
    </form>

    <div id="finishedImport" style="display: none">
        <h3>Successfully imported!</h3>
    </div>

    <h3> Instructions </h3>
    1. Keep this php file and Your csv file in one folder <br>
    2. Create a table in your mysql database to which you want to import <br>
    3. Open the php file from your localhost server <br>
    4. Enter all the fields <br>
    5. click on upload button
</div>
</body>
</html>
