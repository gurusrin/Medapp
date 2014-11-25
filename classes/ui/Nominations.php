<?php

/**
 * PHP
 * Date: Jun 30, 2014
 * Created by: ibm
 * 
 * Description
 * 
 * Displays the information that user requires for nominate himself/herself
 * for. 
 *
 * Change History
 * Date       Author        Change Description
 * --------  -----------    ---------------------------------------------
 *
 */
include_once 'classes/db/Dao.php';

class Nominations extends Dao
{

  private $queries = Array();

  public function __construct ()
  {
    parent::__construct();
    
    $this->queries['TRG_LIST'] = <<<EOQ1
      SELECT TRG_CODE,
             TRG_NAME,
             TRG_TYPE
        FROM TRAINING_DETAILS;
EOQ1;
    
    $this->queries['TRG_LIST_BY_TYPE'] = <<<EOQ2
      SELECT TRG_CODE,
             TRG_NAME,
             TRG_TYPE
        FROM TRAINING_DETAILS
       WHERE TRG_TYPE = '##TRG_TYPE##';
EOQ2;
    
    $this->queries['GET_ALLOWED_MONTHS'] = <<<EOQ3
      SELECT DATE_FORMAT(ADDDATE(CURDATE(), INTERVAL 1 MONTH), '%c-%Y|%M %Y') AS 'M1',
             DATE_FORMAT(ADDDATE(CURDATE(), INTERVAL 2 MONTH), '%c-%Y|%M %Y') AS 'M2',
		         DATE_FORMAT(ADDDATE(CURDATE(), INTERVAL 3 MONTH), '%c-%Y|%M %Y') AS 'M3';
EOQ3;
  } /* End of function: __construct() */

  public function getTrgList ()
  {
    $retResults = Array(
        'TRG_INFO' => Array(),
        'SEL_MTHS' => Array()
    );

    /* Execute the queries and get the result sets. */
    $this->execMultiQuery(
                    $this->queries['TRG_LIST'] .
                     $this->queries['GET_ALLOWED_MONTHS']);
    
    /* Get the training list. */
    $resultSet = $this->connectHnd->store_result();
    
    // Loop through and fetch all the training records.
    while ($row = $resultSet->fetch_row())
    {
      $retResults['TRG_INFO'][] = $row;
    }

    /* Get the available months when the training can be taken. */
    $this->connectHnd->next_result();
    $resultSet = $this->connectHnd->store_result();
    
    $row = $resultSet->fetch_row();

    $mthList = array();

    /* Split the row and fetch the key-value pair. */
    for ($idx = 0; $idx < 3; ++ $idx)
    {
      list($mthCode, $mthValue) = explode("|", $row[$idx]);

      $mthList[$mthCode] = $mthValue; 
    }

    $retResults['SEL_MTHS'] = $mthList;

    return $retResults;
  } /* End of function: getTrgList() */

  public function __destruct ()
  {
    parent::__destruct();
  } /* End of function: __destruct() */
}
?>