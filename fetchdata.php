<?php
/**
 * PHP
 * Date: Nov 23, 2014
 * Created by: gurusrin
 * 
 * Description
 * Program to cater the requests sent by the client.
 *
 *
 * Change History
 * Date       Author        Change Description
 * --------  -----------    ---------------------------------------------
 *
 */
header("Content-type: application/json");
// header("Content-type: text/plain");

error_reporting(E_ALL);

include 'classes/ui/Search.php';

/* * * * * *  MAIN * * * * * */
// Instantiate the object.
$obj = new Search();

if (isset($_SERVER["PATH_INFO"]) && strlen($_SERVER["PATH_INFO"]))
{
    // Get the different parts of the PATH_INFO variable.
    $parts = explode("/", $_SERVER["PATH_INFO"]);

    if ($parts[1] === "spln")
    { // Fetch the specialization.
        echo $obj->get_specializations();
    }
    else if ($parts[1] === "di")
    { // Fetch the doctor information.
        echo $obj->get_doc_info($parts[2], $parts[3]);
    }
    else if ($parts[1] === "hi")
    { // Fetch the information of medical centre.
        echo $obj->get_mc_info($parts[2]);
    }
    else if ($parts[1] === "srch")
    { // Search the records.
        /* Declare the required variables. */
        $pincode   = "";
        $spln      = "";
        $srch_date = "";

        /* Do the basic validation. */
        if (isset($parts[2]) && strlen($parts[2]) !== 0 && $parts[2] !== "0")
            $pincode = $parts[2];

        if (isset($parts[3]) && strlen($parts[3]) !== 0 && $parts[3] !== "-1")
            $spln = $parts[3];

        /*
         * If the date is not provided, then get the current date.
         */
        if (isset($parts[4]) && strlen($parts[4]) !== 0)
            $srch_date = $parts[4];
        else
            $srch_date = date("Y-m-d");

        echo $obj->srch_data($pincode, $spln, $srch_date);
    }
}
else
{
    echo $obj->get_specializations();
}
?>