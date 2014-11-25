<?php
/**
 * PHP
 * Date: Jun 28, 2014
 * Created by: ibm
 * 
 * Description
 *
 *
 * Change History
 * Date       Author        Change Description
 * --------  -----------    ---------------------------------------------
 *
 */
error_reporting(E_ALL);

include 'classes/db/Dao.php';

class Dashboard extends Dao
{

  private $queries = Array();

  public function __construct ()
  {
    parent::__construct();
    
    $this->queries['FETCH_REQUESTS'] = <<<EOQ1
      SELECT *
        FROM USER_TRG_REQUESTS
       WHERE USER_SERIAL = '##SERIAL##';
EOQ1;
    $this->queries['FETCH_USER'] = <<<EOQ2
      SELECT USER_NAME, USER_EMAIL, MGR_NAME
        FROM USER_INFO
       WHERE USER_SERIAL = '##SERIAL##';
EOQ2;
  }

  public function getDashboard ($serialNum = '010556')
  {
    /* First perform the substitution in the query. */
    $query = preg_replace(array(
        '/##SERIAL##/'
    ), array(
        $serialNum
    ), $this->queries['FETCH_REQUESTS']);
    
    /* Execute the query. */
    $this->execQuery($query);
    
    while ($row = $this->resultsHnd->fetch_row)
    {
      print_r($row);
    }
  }

  public function getUserInfo ($serialNum)
  {
    /* First perform the substitution in the query. */
    $query = preg_replace(array(
        '/##SERIAL##/'
    ), array(
        $serialNum
    ), $this->queries['FETCH_USER']);
    
    /* Execute the query. */
    $this->execQuery($query);
    
    while ($row = $this->resultsHnd->fetch_row())
    {
      print_r($row);
    }
  }

  public function __destruct ()
  {
    parent::__destruct();
  }

  public function __toString ()
  {
    print_r($this->queries);
  }
}
?>