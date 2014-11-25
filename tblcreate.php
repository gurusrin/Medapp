<?php

$sql_list = Array(
    "DROP TABLE IF EXISTS DOC_AVAILABILITY_INFO;",
    "DROP TABLE IF EXISTS DOC_VACATION_DAYS;",
    "DROP TABLE IF EXISTS DOCTOR_DETAILS;",
    "DROP TABLE IF EXISTS MEDICAL_CENTRE;",
    "DROP TABLE IF EXISTS SPECIALIZATION;",
    "CREATE TABLE SPECIALIZATION
    (
        SPECIALIZATION_ID           INT NOT NULL,
        SPECIALIZATION_NAME         VARCHAR(50) NOT NULL,
        SPECIALIZATION_DESCRIPTION  VARCHAR(250) NOT NULL,

        PRIMARY KEY (SPECIALIZATION_ID)
    ) Engine=InnoDB
        COMMENT='LIST OF AVAILABLE SPECIALIZATIONS IN MEDICINE';",
    "CREATE TABLE DOCTOR_DETAILS
    (
        DOCTOR_MCI_NUMBER      INT           NOT NULL,
        DOCTOR_NAME            VARCHAR(50)   NOT NULL,
        DOCTOR_EDUCATION       VARCHAR(100)  NOT NULL,
        DOCTOR_SPECIALIZATION  INT           NOT NULL,
        DOCTOR_CONTACT_1       VARCHAR(20)   NOT NULL,
        DOCTOR_CONTACT_2       VARCHAR(20),
        DOCTOR_CONTACT_3       VARCHAR(20),
        ADDRESS_1ST_LINE       VARCHAR(50)   NOT NULL,
        ADDRESS_2ND_LINE       VARCHAR(50),
        ADDRESS_3RD_LINE       VARCHAR(50),
        ADDRESS_STATE          VARCHAR(25)   NOT NULL,
        ADDRESS_PIN            VARCHAR(6)    NOT NULL,
        DOCTOR_OTHER_INFO      VARCHAR(1500),

        PRIMARY KEY (DOCTOR_MCI_NUMBER),
        FOREIGN KEY (DOCTOR_SPECIALIZATION) REFERENCES SPECIALIZATION(SPECIALIZATION_ID)
    ) Engine=InnoDB
        COMMENT='DETAILS OF THE DOCTORS BEING SEARCHED';",
    "CREATE TABLE MEDICAL_CENTRE
    (
        MC_REGN_NUMBER     VARCHAR(50)   NOT NULL,
        MC_NAME            VARCHAR(100)  NOT NULL,
        MC_SPECIALIZATION  VARCHAR(200),
        ADDRESS_1ST_LINE   VARCHAR(50)   NOT NULL,
        ADDRESS_2ND_LINE   VARCHAR(50),
        ADDRESS_3RD_LINE   VARCHAR(50),
        ADDRESS_STATE      VARCHAR(25)   NOT NULL,
        ADDRESS_PIN        VARCHAR(6)    NOT NULL,
        PRIMARY_CONTACT    VARCHAR(20)   NOT NULL,
        CONTACT_NUM_1      VARCHAR(20),
        CONTACT_NUM_2      VARCHAR(20),

        PRIMARY KEY (MC_REGN_NUMBER)
    ) ENGINE=InnoDB
        COMMENT 'DETAILS OF THE MEDICAL CENTRE';",
    "CREATE TABLE DOC_AVAILABILITY_INFO
    (
        DOC_MCI_NUMBER      INT   NOT NULL,
        AVAIL_WKDAY         ENUM ('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun') NOT NULL,
        AVAIL_START_TIME_1  TIME NOT NULL,
        AVAIL_END_TIME_1    TIME NOT NULL,
        AVAIL_START_TIME_2  TIME,
        AVAIL_END_TIME_2    TIME,
        AVAIL_START_TIME_3  TIME,
        AVAIL_END_TIME_3    TIME,

        PRIMARY KEY (DOC_MCI_NUMBER, AVAIL_WKDAY),
        FOREIGN KEY (DOC_MCI_NUMBER) REFERENCES DOCTOR_DETAILS(DOCTOR_MCI_NUMBER)
    ) ENGINE=InnoDB
        COMMENT 'DETAILS OF THE DOCTOR AVAILABILITY';",
    "CREATE TABLE DOC_VACATION_DAYS
    (
        DOC_MCI_NUMBER INT NOT NULL,
        VACATION_DAY   DATE NOT NULL,
        VACATION_REASON VARCHAR(100),

        FOREIGN KEY (DOC_MCI_NUMBER) REFERENCES DOCTOR_DETAILS(DOCTOR_MCI_NUMBER)
    ) ENGINE=InnoDB
        COMMENT 'DETAILS OF DOCTOR VACATION DAYS';",
    "INSERT INTO SPECIALIZATION
    VALUES(1, 'CARDIALOGY', 'SPECIALIZES IN HEART RELATED DISEASES.'),
          (2, 'NEPHROLOGY', 'SPECIALIZES IN KIDNEY RELATED DISEASES.'),
          (3, 'PEDIATRICS', 'INFANT AND YOUNG CHILD RELATED DISEASES SPECIALIZATION.'),
          (4, 'ONCOLOGY', 'CANCER SPECIALISTS.'),
          (5, 'DENTAL', 'SPECIALIZATIONS IN TEETH AND OTHER DENTAL RELATED DISEASES.'),
          (6, 'GENERAL PHYSICIAN', 'DEALS WITH THE COMMON DISEASES'),
          (7, 'OPTHALMOLOGY', 'SPECIALIZATIONS IN EYE RELATED DISEASES');",
    "INSERT INTO DOCTOR_DETAILS
    VALUES('10001', 'Dr. CK Mohan', 'MBBS, MD', '2', '9940123456', NULL, NULL, '10/1, First cross', 'North Usman Road, T. Nagar', 'Chennai', 'TN', '600006', 'Panel member of many PSUs.'),
          ('10365', 'Dr. Thirumala Venkata Raju', 'MBBS, MD, FRCP', '1', '040-23232323', '040-32323232', NULL, '12-1-24-65, Lumbini Apartments', 'Somajiguda', 'Hyderabad', 'TG', '500016', 'Educated in US.'),
          ('120007', 'Dr. Suryodipto Bhar', 'BDS', 6, '9830111111', NULL, NULL, 'CL-255, Sector 2', 'Salt Lake City', 'Kolkata', 'WB', '700091', 'Formerly worked at AIIMS, New Delhi'),
          ('1000467', 'Dr. Arjun Pawaskar', 'MBBS, MD, FRCP', 4, '9820999999', NULL, NULL, '1234, Shivaji Villa', 'Backbay Reclamation', 'Mumbai', 'MH', '200001', NULL);",
    "INSERT INTO DOC_VACATION_DAYS
    VALUES('120007', '2014-11-30', NULL),
          ('120007', '2014-12-25', 'Christmas'),
          ('120007', '2014-12-31', NULL),
          ('120007', '2015-01-01', NULL),
          ('120007', '2015-01-15', 'Makar Sankranti'),
          ('120007', '2015-01-23', 'Netaji Birthday'),
          ('120007', '2015-01-26', 'Republic Day'),
          ('120007', '2015-02-14', 'Valentine Day'),
          ('10001', '2015-01-15', 'Pongal'),
          ('10001', '2015-04-14', 'Tamil New Year'),
          ('10365', '2015-01-15', 'Pongal'),
          ('10365', '2015-03-15', 'Telugu New Year'),
          ('1000467', '2015-03-15', 'Gudi Padwa');",
    "INSERT INTO MEDICAL_CENTRE
    VALUES('MC11001', 'VIJAYA HOSPITALS', '|0|', '180 NSK SALAI', 'NEAR AVM STUDIOS', 'VADAPALANI, CHENNAI', 'TN', '600026',  '044 24802165', NULL, NULL),
          ('MC12005', 'BREACH CANDY HOSPITALS', '|0|', 'CUMBALLA HILLS', 'MUMBAI', '', 'MH', '400001',  '022 39601234', NULL, NULL),
          ('MC13007', 'AMRI HOSPITALS', '|0|', 'JC-16 AND 17', 'NEAR SALT LAKE STADIUM, SALT LAKE CITY', 'KOLKATA', 'WB', '700091',  '033 23391234', NULL, NULL),
          ('MCI4032', 'SANKARA NETHRALAYA', '|8|', 'NO. 18, COLLEGE ROAD', 'NUNGAMBAKKAM', 'CHENNAI', 'TN', '600006', '044 28271616', NULL, NULL);",

    "DROP FUNCTION IF EXISTS IS_DOC_VACATION_DAY;",
    "CREATE FUNCTION IS_DOC_VACATION_DAY (DOC_MCI_ID INT,
                                          CHECK_DATE DATE)
         RETURNS INT
         COMMENT 'CHECKS IF DOCTOR IS ON VACATION ON THE GIVEN DATE.'
     BEGIN
         DECLARE IS_VACATION_DAY INT DEFAULT 0;
         DECLARE EXIT HANDLER FOR NOT FOUND
             BEGIN
                 RETURN 0;
             END;

         SELECT 1
           INTO IS_VACATION_DAY
           FROM DOC_VACATION_DAYS
          WHERE DOC_MCI_NUMBER = DOC_MCI_ID AND
                VACATION_DAY = CHECK_DATE;

         RETURN IS_VACATION_DAY;
     END;",
    "DROP FUNCTION IF EXISTS GET_DOC_AVAIL_INFO;",
    "CREATE FUNCTION GET_DOC_AVAIL_INFO (DOC_MCI_NUM INT,
                                        CHECK_DATE  DATE)
        RETURNS VARCHAR(50)
        COMMENT 'RETURNS THE DOCTOR SCHEDULE.'
    BEGIN
        DECLARE SCHEDULE_INFO VARCHAR(25) DEFAULT NULL;
        DECLARE SEL_WKDAY     VARCHAR(3)  DEFAULT '';
        DECLARE CONTINUE HANDLER FOR NOT FOUND BEGIN END;

        SET @RET_INFO = '';

        -- Get the weekday of the selected date.
        SELECT DATE_FORMAT(IFNULL(CHECK_DATE, CURRENT_DATE), '%a')
          INTO SEL_WKDAY;


        SELECT CONCAT(TIME_FORMAT(AVAIL_START_TIME_1, '%h:%i %p'),
                      ' - ', TIME_FORMAT(AVAIL_END_TIME_1, '%h:%i %p'))
          INTO @RET_INFO
          FROM DOC_AVAILABILITY_INFO
         WHERE DOC_MCI_NUMBER = DOC_MCI_NUM AND
               AVAIL_WKDAY = SEL_WKDAY;

        -- Get the next schedule of the doctor.
        SELECT CONCAT(TIME_FORMAT(AVAIL_START_TIME_2, '%h:%i %p'),
                      ' - ', TIME_FORMAT(AVAIL_END_TIME_2, '%h:%i %p'))
          INTO SCHEDULE_INFO
          FROM DOC_AVAILABILITY_INFO
         WHERE DOC_MCI_NUMBER = DOC_MCI_NUM AND
               AVAIL_WKDAY = SEL_WKDAY AND
               NOT AVAIL_START_TIME_2 IS NULL;

        -- If the last fetch was not null, then concatenate it to the
        -- return string.
        IF NOT SCHEDULE_INFO IS NULL OR SCHEDULE_INFO = '' THEN
            SET @RET_INFO = CONCAT(@RET_INFO,
                                   ', ',
                                   SCHEDULE_INFO);

            -- Reset the variable.
            SELECT '' INTO SCHEDULE_INFO;

            -- Only if the second schedule is available, check if the third
            -- schedule is available.
            SELECT CONCAT(TIME_FORMAT(AVAIL_START_TIME_3, '%h:%i %p'),
                      ' - ', TIME_FORMAT(AVAIL_END_TIME_3, '%h:%i %p'))
              INTO SCHEDULE_INFO
              FROM DOC_AVAILABILITY_INFO
             WHERE DOC_MCI_NUMBER = DOC_MCI_NUM AND
                   AVAIL_WKDAY = SEL_WKDAY AND
                   NOT AVAIL_START_TIME_2 IS NULL;

            -- Append the 3rd schedule if available.
            IF NOT SCHEDULE_INFO IS NULL OR SCHEDULE_INFO = '' THEN
                SET @RET_INFO = CONCAT(@RET_INFO,
                                       ', ',
                                       SCHEDULE_INFO);
            END IF;
        END IF;

        RETURN @RET_INFO;
    END;",

    "DROP PROCEDURE IF EXISTS SEARCH_INFO;",
    "CREATE PROCEDURE SEARCH_INFO (SRCH_PIN             VARCHAR(6),
                                  SRCH_SPECIALIZATION  INT,
                                  SRCH_DATE            DATE,
                                  DOC_OR_MC            ENUM('D', 'M', 'B'))
        COMMENT 'SEARCHES THE DATABASE FOR THE RECORDS.'
    BEGIN
        DECLARE IS_DOC_VACATION    INT   DEFAULT 0;  -- FLAG FOR DOCTOR'S VACATION.

        SET @QUERY = '';

        /*
         * The query may request for either doctor or medical centre or
         * sometimes both near the locality. Hence, the query should be
         * composed in such a manner that query caters both the requests.
         *
         * As an indication, below are the values that indicate the
         * type of query requested:
         *  'D' -->> Return only the list of doctors.
         *  'M' -->> Return only the list of medical centres.
         *  'B' -->> Return both list of doctors and medical centres.
         */
        IF DOC_OR_MC = 'D' OR DOC_OR_MC = 'B' THEN
            SET @QUERY = CONCAT(\"SELECT 'D' AS INFO_TYPE,\",
                                \" DD.DOCTOR_MCI_NUMBER,\",
                                \" DD.DOCTOR_NAME,\",
                                \" DD.DOCTOR_EDUCATION,\",
                                \" SP.SPECIALIZATION_NAME,\",
                                \" CONCAT(DD.ADDRESS_STATE, ' - ', DD.ADDRESS_PIN) AS ADDRESS\",
                                \" FROM DOCTOR_DETAILS DD, SPECIALIZATION SP\",
                                \" WHERE DD.DOCTOR_SPECIALIZATION = SP.SPECIALIZATION_ID\",
                                \" AND IS_DOC_VACATION_DAY(DD.DOCTOR_MCI_NUMBER, '\",
                                IFNULL(SRCH_DATE, CURRENT_DATE),
                                \"') = 0\");

            -- If the PIN code is given, then add it as the query filter.
            IF SRCH_PIN <> '' THEN
                SET @QUERY = CONCAT(@QUERY,
                                    \" AND DD.ADDRESS_PIN = '\",
                                    SRCH_PIN,
                                    \"'\");
            END IF;

            -- If the specialization is provided then add it to the query filter.
            IF SRCH_SPECIALIZATION <> '' THEN
                SET @QUERY = CONCAT(@QUERY,
                                    \" AND DD.DOCTOR_SPECIALIZATION = '\",
                                    SRCH_SPECIALIZATION,
                                    \"'\");
            END IF;
        END IF;

        /*
         * When both doctors and medical centres are requested, then
         * a union of both queries is required.
         */
        IF DOC_OR_MC = 'B' THEN
            SET @QUERY = CONCAT(@QUERY, ' UNION ');
        END IF;

        /*
         * If the medical centre is requested, then we should skip the
         * vacation date because medical centre are normally open all
         * days.
         */
        IF DOC_OR_MC = 'M' OR DOC_OR_MC = 'B' THEN
            SET @QUERY = CONCAT(@QUERY,
                                \"SELECT 'M' AS INFO_TYPE,\",
                                \" MC_REGN_NUMBER,\",
                                \" MC_NAME,\",
                                \" '' AS DUMMY,\",
                                \" '' AS DUMMY,\",
                                \" CONCAT(ADDRESS_STATE, ' - ', ADDRESS_PIN) AS ADDRESS\",
                                \" FROM MEDICAL_CENTRE\");

            -- Check if the PIN was provided to list the medical centres.
            IF SRCH_PIN <> '' THEN
                SET @QUERY = CONCAT(@QUERY,
                                    \" WHERE ADDRESS_PIN = '\",
                                    SRCH_PIN,
                                    \"'\");
            END IF;

            -- If the specialization is given, then ensure that the specific
            -- discipline hospital and medical centre with all the disciplines.
            IF SRCH_SPECIALIZATION <> '' THEN
                IF SRCH_PIN <> '' THEN
                    SET @QUERY = CONCAT(@QUERY, \" AND \");
                ELSE
                    SET @QUERY = CONCAT(@QUERY, ' WHERE ');
                END IF;

                SET @QUERY = CONCAT(@QUERY,
                                    \" MC_SPECIALIZATION = '|0|'\",
                                    \" OR MC_SPECIALIZATION LIKE '%|\",
                                    SRCH_SPECIALIZATION,
                                    \"|%'\");
            END IF;
        END IF;

        -- SELECT @QUERY;
        PREPARE STMT FROM @QUERY;
        
        EXECUTE STMT;
    END;",

    "DROP PROCEDURE IF EXISTS GET_DOCTOR_INFO;",
    "CREATE PROCEDURE GET_DOCTOR_INFO (MCI_REGN INT,
                                      CHECK_DATE DATE)
        COMMENT 'RETURNS THE DOCTOR ADDRESS AND AVAILABILITY.'
    BEGIN
        DECLARE EXIT HANDLER FOR NOT FOUND BEGIN END;

        SELECT DOCTOR_NAME,
               DOCTOR_EDUCATION,
               CONCAT(ADDRESS_1ST_LINE,
                      ', ',
                      IFNULL(ADDRESS_2ND_LINE, ''),
                      ', ',
                      IFNULL(ADDRESS_3RD_LINE, ''),
                      ', ',
                      ADDRESS_STATE,
                      ', ',
                      ADDRESS_PIN) AS DOCTOR_ADDRESS,
               CONCAT(DOCTOR_CONTACT_1,
                      IF(DOCTOR_CONTACT_2 IS NULL, '', CONCAT(', ', DOCTOR_CONTACT_2)),
                      IF(DOCTOR_CONTACT_3 IS NULL, '', CONCAT(', ', DOCTOR_CONTACT_3))) AS CONTACT_NUM,
               GET_DOC_AVAIL_INFO(MCI_REGN, CHECK_DATE) AS SCHEDULE,
               IF(IS_DOC_VACATION_DAY(MCI_REGN, CHECK_DATE) = 1,
                  'On vacation',
                  'Available') AS IS_AVAILABLE
          FROM DOCTOR_DETAILS
         WHERE DOCTOR_MCI_NUMBER = MCI_REGN;
    END;",

    "DROP PROCEDURE IF EXISTS GET_HOSPITAL_INFO;",
    "CREATE PROCEDURE GET_HOSPITAL_INFO (REGN_NUM VARCHAR(50))
        COMMENT 'RETRIEVES THE LIST OF HOSPITALS.'
    BEGIN
        DECLARE EXIT HANDLER FOR NOT FOUND BEGIN END;

        SELECT MC_NAME,
               CONCAT(ADDRESS_1ST_LINE,
                      ', ',
                      IFNULL(ADDRESS_2ND_LINE, ''),
                      ', ',
                      IFNULL(ADDRESS_3RD_LINE, ''),
                      ', ',
                      ADDRESS_STATE,
                      ', ',
                      ADDRESS_PIN) AS MC_ADDRESS,
               CONCAT(PRIMARY_CONTACT,
                      IF(CONTACT_NUM_1 IS NULL OR CONTACT_NUM_1 = '', '', CONCAT(', ', CONTACT_NUM_1)),
                      IF(CONTACT_NUM_2 IS NULL OR CONTACT_NUM_2 = '', '', CONCAT(', ', CONTACT_NUM_2))) AS CONTACT_NUM
          FROM MEDICAL_CENTRE
         WHERE MC_REGN_NUMBER = REGN_NUM;
    END;",

    "DROP PROCEDURE IF EXISTS GET_SPECIALIZATION_LIST;",
    "CREATE PROCEDURE GET_SPECIALIZATION_LIST()
        COMMENT 'RETURNS THE LIST OF ALL THE SPECIALIZATION'
    BEGIN
        SELECT SPECIALIZATION_ID, SPECIALIZATION_NAME
          FROM SPECIALIZATION;
    END;",

    "DROP PROCEDURE IF EXISTS INSERT_DOCTOR_INFO;",
    "CREATE PROCEDURE INSERT_DOCTOR_INFO(MCI_NUM        INT,
                                        DOC_NAME       VARCHAR(50),
                                        DOC_EDUCATION  VARCHAR(100),
                                        DOC_SPECIAL_ID INT,
                                        ADDR_LINE_1    VARCHAR(50),
                                        ADDR_LINE_2    VARCHAR(50),
                                        ADDR_LINE_3    VARCHAR(50),
                                        ADDR_STATE     VARCHAR(25),
                                        ADDR_PIN       VARCHAR(6),
                                        DOC_PHONE_1    VARCHAR(20),
                                        DOC_PHONE_2    VARCHAR(20),
                                        DOC_PHONE_3    VARCHAR(20),
                                        DOC_OTHER_INFO VARCHAR(1500))
        COMMENT 'INSERT THE RECORD FOR THE DOCTOR.'
    BEGIN
        DECLARE VALID_SP_CODE INT DEFAULT 0;
        DECLARE USER_PRESENT  INT DEFAULT 0;

        -- Handle the not found handler.
        DECLARE CONTINUE HANDLER FOR NOT FOUND BEGIN END;

        -- Handle the exception.
        DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            SELECT '-1' AS CODE,
                   'ERROR: Failed to insert the record.' AS MSG;

            ROLLBACK;
        END;

        -- Handle the warnings.
        DECLARE EXIT HANDLER FOR SQLWARNING
        BEGIN
            SELECT '-1' AS CODE,
                   'WARN: Failed to insert the record.' AS MSG;
        END;

        START TRANSACTION;

        -- Check if the given specialization code exists in the database.
        SELECT COUNT(*)
          INTO VALID_SP_CODE
          FROM SPECIALIZATION
         WHERE SPECIALIZATION_ID = DOC_SPECIAL_ID;

        IF VALID_SP_CODE = 1 THEN
            -- Ensure that the MCI code is not registered already.
            SELECT COUNT(*)
              INTO USER_PRESENT
              FROM DOCTOR_DETAILS
              WHERE DOCTOR_MCI_NUMBER = MCI_NUM;

            IF USER_PRESENT = 0 THEN
                -- Attempt to insert the record into the database.
                INSERT INTO DOCTOR_DETAILS(DOCTOR_MCI_NUMBER,
                                           DOCTOR_NAME,
                                           DOCTOR_EDUCATION,
                                           DOCTOR_SPECIALIZATION,
                                           ADDRESS_1ST_LINE,
                                           ADDRESS_2ND_LINE,
                                           ADDRESS_3RD_LINE,
                                           ADDRESS_STATE,
                                           ADDRESS_PIN,
                                           DOCTOR_CONTACT_1,
                                           DOCTOR_CONTACT_2,
                                           DOCTOR_CONTACT_3,
                                           DOCTOR_OTHER_INFO)
                VALUES(MCI_NUM,
                       DOC_NAME,
                       DOC_EDUCATION,
                       DOC_SPECIALIZATION,
                       ADDR_LINE_1,
                       ADDR_LINE_2,
                       ADDR_LINE_3,
                       ADDR_STATE,
                       ADDR_PIN,
                       DOC_PHONE_1,
                       DOC_PHONE_2,
                       DOC_PHONE_3,
                       DOC_OTHER_INFO);
            ELSE
                SELECT '0' AS CODE,
                       'MCI Number already exists.' AS MSG;

                ROLLBACK;
            END IF;
        ELSE
            SELECT '0' AS CODE,
                   'Specialization code is invalid.' AS MSG;

            ROLLBACK;
        END IF;
    END;",

    "DROP PROCEDURE IF EXISTS INSERT_MC_INFO;",
    "CREATE PROCEDURE INSERT_MC_INFO (MC_REGN       VARCHAR(50),
                                     MC_FULLNAME   VARCHAR(100),
                                     MC_SPECIALS   VARCHAR(200),
                                     ADDR_LINE_1   VARCHAR(50),
                                     ADDR_LINE_2   VARCHAR(50),
                                     ADDR_LINE_3   VARCHAR(50),
                                     ADDR_STATE    VARCHAR(25),
                                     ADDR_PIN      VARCHAR(6),
                                     MC_PHONE_1    VARCHAR(20),
                                     MC_PHONE_2    VARCHAR(20),
                                     MC_PHONE_3    VARCHAR(20))
        COMMENT 'INSERTS THE HOSPITAL INFORMATION.'
    BEGIN
        DECLARE MC_EXISTS INT DEFAULT 0;

        DECLARE EXIT HANDLER FOR NOT FOUND
        BEGIN
            SELECT '0' AS CODE,
                   'Record not found.' AS MSG;
        END;

        DECLARE EXIT HANDLER FOR SQLEXCEPTION
        BEGIN
            SELECT '-1' AS CODE,
                   'ERROR: Failed to insert the record.' AS MSG;

            ROLLBACK;
        END;

        DECLARE EXIT HANDLER FOR SQLWARNING
        BEGIN
            SELECT '-1' AS CODE,
                   'WARN: Failed to insert the record.' AS MSG;

            ROLLBACK;
        END;

        SET @QUERY = '';

        START TRANSACTION;

        -- Check if the medical centre is already registered.
        SELECT COUNT(*)
          INTO MC_EXISTS
          FROM MEDICAL_CENTRE
         WHERE MC_REGN_NUMBER = MC_REGN;

        IF MC_EXISTS = 0 THEN
            SET @QUERY = CONCAT('INSERT INTO MEDICAL_CENTRE(MC_REGN_NUMBER, MC_NAME, MC_SPECIALIZATION, ADDRESS_1ST_LINE, ADDRESS_2ND_LINE,',
                                'ADDRESS_3RD_LINE, ADDRESS_STATE, ADDRESS_PIN, PRIMARY_CONTACT, CONTACT_NUM_1, CONTACT_NUM_2) VALUES(',
                                \"'\", MC_REGN, \"', \",
                                \"'\", MC_FULLNAME, \"', \",
                                \"'\", MC_SPECIALS, \"', \",
                                \"'\", ADDR_LINE_1, \"', \",
                                \"'\", IFNULL(ADDR_LINE_2, ''), \"', \",
                                \"'\", IFNULL(ADDR_LINE_3, ''), \"', \",
                                \"'\", ADDR_STATE, \"', \",
                                \"'\", ADDR_PIN, \"', \",
                                \"'\", IFNULL(MC_PHONE_1, ''), \"', \",
                                \"'\", IFNULL(MC_PHONE_2, ''), \"', \",
                                \"'\", IFNULL(MC_PHONE_3, ''), \"'\",
                                \")\");

            INSERT INTO MEDICAL_CENTRE(MC_REGN_NUMBER,
                                       MC_NAME,
                                       MC_SPECIALIZATION,
                                       ADDRESS_1ST_LINE,
                                       ADDRESS_2ND_LINE,
                                       ADDRESS_3RD_LINE,
                                       ADDRESS_STATE,
                                       ADDRESS_PIN,
                                       PRIMARY_CONTACT,
                                       CONTACT_NUM_1,
                                       CONTACT_NUM_2)
            VALUES(MC_REGN,
                   MC_FULLNAME,
                   MC_SPECIALS,
                   ADDR_LINE_1,
                   IFNULL(ADDR_LINE_2, ''),
                   IFNULL(ADDR_LINE_3, ''),
                   ADDR_STATE,
                   ADDR_PIN,
                   MC_PHONE_1,
                   IFNULL(MC_PHONE_2, ''),
                   IFNULL(MC_PHONE_3, ''));

            SELECT '1' AS CODE,
                   'Successfully updated.' AS MSG;

            COMMIT;
        ELSE
            SELECT '0' AS CODE,
                   'Hospital already exists.' AS MSG;

            ROLLBACK;
        END IF;
    END;",
);

/* Get the VCAP information to get the login credentials. */
$vcap_services = json_decode($_ENV["VCAP_SERVICES"]);
print_r($vcap_services);
$db = $vcap_services->{'mysql-5.5'}[0]->credentials;
//$db = $vcap_services->{'cleardb'}[0]->credentials;

/* Get all the important parameters. */
$mysql_database = $db->name;
$mysql_port = $db->port;
$mysql_server_name = $db->host . ':' . $db->port;
$mysql_username = $db->username;
$mysql_password = $db->password;

/* Get all the important parameters. */
/*
$mysql_database = "srinitest";
$mysql_port = "3306";
$mysql_server_name = 'localhost';
$mysql_username = 'root';
$mysql_password = 'cul8tr';
*/

echo "DB: ", $mysql_database, "<br/>",
     "Username: ", $mysql_username, "<br/>",
     "Password: ", $mysql_password, "<br/>",
     "Server: ", $mysql_server_name, "<br/>";

/* Connect to the MySQL database. */
$con = new mysqli($mysql_server_name, $mysql_username, $mysql_password, $mysql_database);

/* Check if the connection was successful. */
if (mysqli_connect_errno())
{
  echo'Connection failed: ' . mysqli_connect_error();
  exit(1);
}

echo "Connection was successful!\n";

foreach ($sql_list as &$next_stmt)
{
  echo $next_stmt . "\n";
  
  $result = $con->query($next_stmt);
  
  if (! $result)
  {
    echo "Failed to execute statement: " . $next_stmt . "\n\tError: " .
         $con->error . "\n";
    exit(1);
  }
} /* End of foreach */

$con->close();
?>