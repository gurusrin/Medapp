<?php
/**
 * PHP
 * Date: Nov 23, 2014
 * Created by: gurusrin
 * 
 * Description
 * This class helps the programs to fetch the information from the database.
 * And, returns the information as JSON. The front end needs to parse the
 * input information and update the web page.
 *
 * Change History
 * Date       Author        Change Description
 * --------  -----------    ---------------------------------------------
 *
 */
error_reporting(E_ALL);

include 'classes/db/Dao.php';

class Search extends Dao
{
    /* Global variables. */
    public $queries = Array(); /* Array for list of stored procedures. */

    /* Default constructor. */
    public function __construct()
    {
        parent::__construct();

        /*
         * Initialize the list of queries that can be made.
         */
        $this->queries["GET_SPLN_LIST"] = "GET_SPECIALIZATION_LIST";
        $this->queries["GET_DOC_INFO"]  = "GET_DOCTOR_INFO";
        $this->queries["GET_MC_INFO"]   = "GET_HOSPITAL_INFO";
        $this->queries["SEARCH_INFO"]   = "SEARCH_INFO";
    } /* End of function: __construct() */

    /**
     * Fetches the list of specializations from the database.
     */
    public function get_specializations()
    {
        $rslt_json = array();

        /* Compose the DML. */
        $query = "CALL " . $this->queries["GET_SPLN_LIST"] . "()";

        /* Execute the query and get the results. */
        $this->execQuery($query);

        /* Loop through and fetch the records. */
        while ($row = $this->resultsHnd->fetch_row())
        {
            $rslt_json[] = array(
                "id" => $row[0],
                "name" => $row[1],
            );
        }

        return json_encode($rslt_json);
    } /* End of function: get_specializations() */

    /**
     * Gets the address and contact number of the doctor
     * along with the availability on the given date.
     */
    public function get_doc_info($doc_mci_num, $srch_date)
    {
        $rslt_json = array();

        /* Compose the stored procedure. */
        $query = "CALL " . $this->queries["GET_DOC_INFO"] .
                 "(" .
                 "'" . $doc_mci_num . "', " .
                 "'" . $srch_date . "'" .
                 ")";

        /* Execute the query. */
        $this->execQuery($query);

        /* Get the results. */
        $row = $this->resultsHnd->fetch_row();

        /*
         * If there are only couple of columns in the row,
         * then it is possible that the error has occurred.
         */
        if (count($row) == 2)
        {
            $rslt_json = array(
                "type" => "error",
                "code" => $row[0],
                "msg"  => $row[1],
            );
        }
        else
        {
            $rslt_json = array(
                "type" => "info",
                "name" => $row[0],
                "edu"  => $row[1],
                "addr" => $row[2],
                "contact" => $row[3],
                "sched_today" => (strlen($row[4]) !== 0 ? $row[4] : "No schedule available for today."),
                "vacation" => $row[5],
            );
        }

        return json_encode($rslt_json);
    } /* End of function: get_doc_info() */

    /**
     * Fetches the information about the medical centre.
     */
    public function get_mc_info($mc_regn)
    {
        $rslt_json = array();

        /* Compose the stored procedure. */
        $query = "CALL " . $this->queries["GET_MC_INFO"] .
                 "(" . "'" . $mc_regn . "'" . ")";

        /* Execute the query. */
        $this->execQuery($query);

        /* Get the results. */
        $row = $this->resultsHnd->fetch_row();

        /*
         * If there are only couple of columns in the row,
         * then it is possible that the error has occurred.
         */
        if (count($row) == 2)
        {
            $rslt_json = array(
                "type" => "error",
                "code" => $row[0],
                "msg"  => $row[1],
            );
        }
        else
        {
            $rslt_json = array(
                "type" => "info",
                "name" => $row[0],
                "addr" => $row[1],
                "contact" => $row[2],
            );
        }

        return json_encode($rslt_json);
    } /* End of function: get_mc_info() */

    public function srch_data($pincode, $spln, $srch_date)
    {
        $rslt_json = array();
        $data      = array();

        /* Compose the DML. */
        $query = "CALL " . $this->queries["SEARCH_INFO"] .
                 "(" .
                 "'" . $pincode . "', " .
                 "'" . $spln . "', " .
                 "'" . $srch_date . "', " .
                 "'B'" .
                 ")";

        /* Execute the query and get the results. */
        $this->execQuery($query);

        /* Loop through and fetch the records. */
        while ($row = $this->resultsHnd->fetch_row())
        {
            /* Possible error. */
            if (count($row) === 2)
            {
                /* Compose the JSON and exit the loop. */
                $rslt_json = array(
                    "type" => "error",
                    "code" => $row[0],
                    "msg"  => $row[1],
                );

                return json_encode($rslt_json);
            }

            $data[] = array(
                "is" => $row[0],
                "id" => $row[1],
                "name" => $row[2],
                "edu" => ($row[0] === "M" ? "--" : $row[3]),
                "spln" => ($row[0] === "M" ? "--" : $row[4]),
                "state" => $row[5],
            );
        }

        $rslt_json = array(
            "type" => "info",
            "data" => $data,
        );

        return json_encode($rslt_json);
    } /* End of function: srch_data() */

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    } /* End of function: __destruct() */
}
?>