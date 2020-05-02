<?php
     class Database {
private static $init = FALSE;
public static $conn;
public static function initialize()
{
if (self::$init===TRUE)return;
self::$init = TRUE;
self::$conn = new mysqli("localhost", "root", "Your-password", "chatapp");
}
}
