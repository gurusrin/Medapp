<?php
require_once 'classes/conf/Config.php';

class IBMProfile
{
  /*
   * Function to fetch the W3 Profile for the given user. Since, this is a
   * static function not object of the class is required. This function returns
   * the data in the following format:
   * <HKEY>|<GEO>|<CTRY-CODE>|<BUILDING>|<LANGUAGE> where: HKEY -- The hash key
   * for the profile which is a persistent text and does not change. GEO -- The
   * geography of the user whose data is being requested. CTRY-CODE -- The base
   * country of the user. BUILDING -- The building where the user sits. LANGUAGE
   * -- The preferred language of the web pages. The above profile information
   * is based on the current requirement and may change in future. To add remove
   * any field from the output the configuration file should be updated.
   */
  public static function getW3Profile ($email)
  {
    /* List of manadatory fields to check the execution status. */
    $reqdFields = array(
        "STATUSTYPE",
        "STATUSID",
        "STATUSMESSAGE"
    );
    
    /* Array to store the fetched data. */
    $fetchedData = array();
    
    /* Check if the E-Mail ID has been provided. */
    if (! ($email && strlen($email)))
    {
      throw new Exception("No email ID given for fetching profile.", 255);
    }
    
    /* Compose the URL to request and the fields that would be used. */
    $baseUrl = Config::$W3_PROFILE_URL . $email;
    $reqdFields = array_merge(Config::$W3_PROFILE_FLD, $reqdFields);
    
    $regExp = "/^(" . implode("|", $reqdFields) . ")\\b/i";
    
    /* Instantiate the request. */
			/* Initialize the CURL object. */
			$curlReq = curl_init();
    
    /* Set the curl options. */
    curl_setopt($curlReq, CURLOPT_URL, $baseUrl);
    curl_setopt($curlReq, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlReq, CURLOPT_HEADER, 0);
    
    /* Make the HTTP request through curl. */
    $profileInfo = curl_exec($curlReq);
    
    /* Check for curl errors. */
    if (curl_errno($curlReq) != 0)
    { /* Throw the exception. */
      throw new Exception(
          "Failed to fetch the profile for email: " . $email, 
          $curl_error($curlReq));
    }
    
    /* Get the execution information. */
    $reqInfo = curl_getinfo($curlReq);
    
    /* Check for the status of the request. */
    if ($reqInfo['http_code'] == 200)
    {
      /* Select only the required fields. */
      $data = preg_grep($regExp, explode("\n", $profileInfo));
      
      /* Store selected fields into an array. */
      foreach ($data as &$nextInfo)
      {
        list ($key, $value) = preg_split("/\s*=\s*/", trim($nextInfo));
        $fetchedData[$key] = $value;
      }
      
      /* Check if the fetch was successful */
      if ($fetchedData["STATUSID"] != 0)
      {
        throw new Exception($fetchedData["STATUSMESSAGE"], 
            $fetchedData["STATUSID"]);
      }
      
      /* Return the profile string. */
      return $fetchedData["HKEY"] . "|" . $fetchedData["LOCATION_1_1"] . "|" .
           $fetchedData["LOCATION_1_2"] . "|" . $fetchedData["LOCATION_1_6"] .
           "|" . $fetchedData["LANGUAGE_1"];
    }
    else
    { /* Throw the exception. */
      throw new Exception(
          "Failed to fetch the profile for email: " . $email, $profileInfo);
    }
  } /* End of function: getW3Profile() */
} /* End of class: IBMProfile */
?>

