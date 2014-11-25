<?php
/* Report only specific errors. */
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

class Config
{

  public static $DB_HOSTNAME = "127.0.0.1";

  public static $DB_PORT = 3306;

  public static $DB_USERNAME = "root";

  public static $DB_PASSWORD = "cul8tr";

  public static $DB_SCHEMA = "srinitest";
}
?>
