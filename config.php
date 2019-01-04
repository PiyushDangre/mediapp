<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// define('DB_SERVER', 'localhost');
// define('DB_USERNAME', 'id8366077_mediapp1');
// define('DB_PASSWORD', 'Mumbai123#');
// define('DB_NAME', 'mediapp1');
 
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'mediapp');


/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if(mysqli_connect_errno()){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>