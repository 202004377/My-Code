<?php
    session_start();
    DEFINE ('DB_USER', 'root');
    DEFINE ('DB_PSWD', ''); 
    DEFINE ('DB_HOST', 'localhost'); 
    DEFINE ('DB_NAME', 'iot_ps'); 

    date_default_timezone_set('Africa/Mbabane'); 
    $conn =  new mysqli(DB_HOST,DB_USER,DB_PSWD,DB_NAME);
    
    if($conn->connect_error){
        die("Failed to connect database. ".$conn->connect_error );
    } 

?>