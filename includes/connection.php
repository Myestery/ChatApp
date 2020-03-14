<?php
 $servername= "localhost";
 $username="root";
 $password="Gwalian4.";

 $conn = new mysqli($servername, $username, $password);
 if($conn->connect_error){
     die ("Connection failed:" . $conn->connect_error);
 }
     $conn= mysqli_connect("localhost", "root", "Gwalian4.");
     mysqli_select_db( $conn, "chatapp");
     
     class Database {
private static $init = FALSE;
public static $conn;
public static function initialize()
{
if (self::$init===TRUE)return;
self::$init = TRUE;
self::$conn = new mysqli("localhost", "root", "Gwalian4.", "chatapp");
}
}
