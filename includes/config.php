<?php

//define the constants
 define("SERVERNAME","localhost");
 define("USERNAME","root");
 define("PASSWORD","");
 define("DBNAME","login");

//create a connection to the database
 $conn = mysqli_connect(SERVERNAME,USERNAME,PASSWORD,DBNAME);

if(!$conn)
    die("Connection failed ".mysqli_connect_error());
else
     echo "Connected Successfully<br>";

$sql = "CREATE TABLE IF NOT EXISTS user(
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(10) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP);";

    if($conn->query($sql) == true){
        echo "Table created successfully";
    }else{
        echo "Error creating table".$conn->error;
    }

?>