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

class TrainingReport extends Dao
{

  private $queries = Array();

  /**
   * Default constructor.
   * 
   * Initializes the database connection and also sets
   * the new queries as a global array variable.
   * 
   * @see Dao::__construct()
   */
  public function __construct ()
  {
    /* Call the parent constructor. */
    parent::__construct();
    
    /* Define the queries.*/
    $this->queries['TRG_LIST'] = <<<EOQ1
      SELECT TRG_CODE,
             TRG_NAME,
        FROM TRAINING_DETAILS;
EOQ1;
    
    $this->queries['USER_TRG_LIST_QUERY'] = <<<EOQ2
       SELECT USER_INFO.USER_SERIAL,
                        USER_NAME,
       TRAINING_DETAILS.TRG_CODE,
                        TRG_NAME,
                        PREFERRED_MONTH,
                        PREFERRED_YEAR,
                       TRG_APPROVAL_STATUS
       FROM USER_TRG_REQUESTS,
            TRAINING_DETAILS,
            USER_INFO
       WHERE TRG_CODE = '##TRG_CODE##' 
         AND USER_INFO.USER_SERIAL = USER_TRG_REQUESTS.TRG_CODE AND
             USER_TRG_REQUESTS.TRG_CODE = TRAINING_DETAILS.TRG_CODE AND
          (
             (PREFERRED_MONTH >= '##FROM_MON##' AND PREFERRED_YEAR >= '##FROM_YEAR##') AND
             (PREFERRED_MONTH <= '##TO_MON##' AND PREFERRED_YEAR <= '##TO_YEAR##')
           );
    
EOQ2;
  } /* End of function: __construct() */

  /**
   *
   * @param string $trgCode
   *          The training code.
   * @param string $fromPrefMonth
   *          The starting month for report search.
   * @param string $fromPrefYear
   *          The starting year for report search.
   * @param string $toPrefMonth
   *          The ending month for report search.
   * @param string $toPrefMonth
   *          The ending year for report search.
   * @return mixed array
   *         The list of trainings as per search criteria.
   */
  public function getUsrTrngRpt (
                                $trgCode, 
                                $fromPrefMonth, 
                                $fromPrefYear, 
                                $toPrefMonth, 
                                $toPrefMonth)
  {
    /* Array to return the results. */
    $retResults = Array(
        'USER_TRNGRPT' => Array()
    );

    /* List the parameters to replace. */
    $paramList = array(
        '/##TRG_CODE##/',
        '/##FROM_MON##/',
        '/##FROM_YEAR##/',
        '/##TO_MON##/',
        '/##TO_YEAR##/'
    );
    
    /* List of values to be used as replacement. */
    $valueList = array(
        $trgCode,
        $fromPrefMonth,
        $fromPrefYear,
        $toPrefMonth,
        $toPrefMonth
    );
    
    /* Perform the replacement.*/
    $query = preg_replace($paramList, 
                          $valueList, 
                          $this->queries['FETCH_REQUESTS']);

    /* Execute the query. */
    $this->execQuery($this->queries['USER_TRG_LIST_QUERY']);

    /* Loop through and fetch all the rows. */
    while ($row = $resultSet->fetch_row())
    {
      $retResults['USER_TRNGRPT'][] = $row;
    }
    
    /* Return the fetched results. */
    return $retResults;
  } /* End of function: getUsrTrngRpt() */

  /**
   * Returns the list of trainings that user wants.
   * 
   * @return mixed array
   */
  public function getTrgList ()
  {
    $retResults = Array(
        'TRG_INFO' => Array()
    );
    
    /* Execute the queries and get the result sets. */
    $this->execQuery($this->queries['TRG_LIST']);
    
    // Loop through and fetch all the training records.
    while ($row = $resultSet->fetch_row())
    {
      $retResults['TRG_INFO'][] = $row;
    }
    
    return $retResults;
  } /* End of function: getTrgList() */

  /**
   * Destructor.
   * 
   * @see Dao::__destruct()
   */
  public function __destruct ()
  {
    parent::__destruct();
  } /* End of function: __destruct() */
}
?>