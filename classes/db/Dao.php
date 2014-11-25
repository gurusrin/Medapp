<?php
include_once 'classes/conf/Config.php';

/**
 * This class handles all the database related activities. Classes which wish to
 * interact with the database should be inheriting this class and making the
 * necessary calls. Upon termination of session, the connections would
 * automatically get released.
 */
class Dao
{

  protected $connectHnd; // Connnection handle.
  protected $resultsHnd; // Handle for result set.
  
  /**
   * Constructor.
   * Opens up the connection with the database. Should the
   * establishment of connection fail, the exception is thrown with the reason.
   */
  public function __construct ()
  {
    $hostName = Config::$DB_HOSTNAME;
    $username = Config::$DB_USERNAME;
    $password = Config::$DB_PASSWORD;
    $database = Config::$DB_SCHEMA;
    $port = Config::$DB_PORT;
    
    /*
     * In order to access the BlueMix service seamlessly check if the
     * environment variable VCAP_SERVICES is available or not. If not, then use
     * the configuration variable available in the configuration file.
     */
    if (isset($_ENV['VCAP_SERVICES']))
    {
      $vcap_data = json_decode($_ENV['VCAP_SERVICES']);
      
      $credentials = $vcap_data->{'mysql-5.5'}[0]->credentials;

      $hostName = $credentials->host;
      $username = $credentials->username;
      $password = $credentials->password;
      $database = $credentials->name;
      $port = $credentials->port;
    }

    /* Attempt to open the connection. */
    $this->connectHnd = new mysqli($hostName, 
                                  $username, 
                                  $password, 
                                  $database, 
                                  $port);
    
    if (! $this->connectHnd)
    { /* Failed to establish the connection. */
      $errMsg = "Connection failed: " . $this->connectHnd->connect_error;
      
      throw new Exception($this->errMsg, $this->connectHnd->connect_errno);
    }
  } /* End of function: __construct() */

  /**
   * Call this function when the query needs to be executed.
   * Upon successful execution of the query, the results are
   * available through $resultsHnd.
   * Only the queries which return only one result set, can
   * be executed using this function.
   * 
   * @param $query The
   *          query to be executed.
   */
  public function execQuery ($query)
  {
    // Check if the query is provided or not.
    if (strlen($query) === 0)
    {
      $errMsg = "No query provided to execute.";
      
      throw new Exception($errMsg, 1);
    }
    
    /* Execute the query and get the results. */
    $this->resultsHnd = $this->connectHnd->query($query);
    
    /* Check if the execution was successful. */
    if (! $this->resultsHnd)
    {
      $errMsg = "Failed to execute query: " . $this->connectHnd->error;
      
      throw new Exception($errMsg, $this->connectHnd->errno);
    }
  } /* End of function: execQuery() */

  /**
   * Call this function when the query needs to be executed.
   * Upon successful execution of the query, the results are
   * available through $resultsHnd.
   *
   * Unlike the above function, this function should be used
   * when more than one resultset is expected to be returned.
   *
   * @param $query The query to be executed.
   */
  public function execMultiQuery ($query)
  {
    if (strlen($query) === 0)
    {
      $errMsg = "No query provided to execute.";
      
      throw new Exception($errMsg, 1);
    }
    
    /* Execute the query and get the results. */
    $this->resultsHnd = $this->connectHnd->multi_query($query);
    
    /* Check if the execution was successful. */
    if (! $this->resultsHnd)
    {
      $errMsg = "Failed to execute query: " . $this->connectHnd->error;
      
      throw new Exception($errMsg, $this->connectHnd->errno);
    }
  } /* End of function: execMultiQuery() */

  /**
   * Destructor.
   *
   * Destructs this object and also closes the connection established
   * with the database.
   */
  public function __destruct ()
  {
    /* Check if the connection handle is valid. */
    if ($this->connectHnd)
    {
      // Close the connection and unset the variable.
      $this->connectHnd->close();
      
      $this->connectHnd = null;
    }
  } /* End of function: __destruct() */
} /* End of class: Dao */
?>
