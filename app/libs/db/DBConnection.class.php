<?php

class DBConnection
{
    // DB connection related
    private $DBHost;
    private $DBUsername;
    private $DBPassword;
    private $DBPort;

    // DB related
    protected $DBName;      // Database name
    protected $DBLink;      // DB connection link, used to get the connection
    // link (persistence)
    protected $lastError;   // last error found

    //Data related
    public $lastQuery;      // last query used
    public $result;         // last query successful result
    public $lastInsertID;   // last autoincrement value got

    function __construct(
        $connectionParams, $persistant = true, $charset = "utf8")
    {
        $this->setParams($connectionParams);
        $connectionFailed = !$this->openConnection($persistant, $charset);
        if ($connectionFailed) { die($this->lastError); }
    }

    function __destruct()
    {
        $this->closeConnection();
    }

    function openConnection($persistent = true, $charset = "utf8")
    {
        $this->closeConnection();

        $host = $persistent ? "p:".$this->DBHost : $this->DBHost;
        $this->DBLink = mysqli_connect(
            $host,
            $this->DBUsername,
            $this->DBPassword,
            $this->DBName,
            $this->DBPort
        );

        /* check connection succeeded */
        if (mysqli_connect_errno()) {
            $this->lastError =
                "DB CONNECTION ERROR [" . mysqli_connect_errno() . "]: ".
                mysqli_connect_error();
            return false;
        }

        /* change character set to utf8 */
        if ($charset) {
            if (!$this->DBLink->set_charset($charset)) {
                $this->lastError =
                    "DB ERROR loading character set utf8: ".
                    $this->DBLink->error;
                return false;
            }
        }
        return true;
    }

    function closeConnection()
    {
        if ($this->DBLink) {
            $this->DBLink->close();
            return true;
        }
        return false;
    }

    function setHost($host)
    {
        $this->DBHost = $host;
    }

    function setUsername($username)
    {
        $this->DBUsername = $username;
    }

    function setPassword($password)
    {
        $this->DBPassword = $password;
    }

    function setPort($port)
    {
        $this->DBPort = $port;
    }
    function setDBName($DBName)
    {
        $this->DBName = $DBName;
    }

    function setParams($connection_params)
    {
        $this->setHost($connection_params["host"]);
        $this->setUsername($connection_params["username"]);
        $this->setPassword($connection_params["password"]);
        $this->setPort($connection_params["port"]);
        $this->setDBName($connection_params["database"]);
    }

    function useDB($DBName)
    {
        if (!$this->DBLink) { return false; }

        $this->DBName = $DBName;
        if (!$this->DBLink->select_db($this->DBName)) {
            $this->lastError =
                '[DB ERROR] Cannot use '.$this->DBName.' database:\n'.
                mysqli_error($this->DBLink);
            return false;
        }
        return true;
    }

    function getError()
    {
        return $this->lastError;
    }

    function getDB()
    {
        return $this->DBLink;
    }

    function getDBName()
    {
        return $this->DBName;
    }

    private function executeQuery($query)
    {
        $this->lastQuery = $query;
        $this->result = $this->DBLink->query($query);
        if (!$this->result) {
            $this->lastError = $this->DBLink->error;
        }
        return $this->result;
    }

    /**
     * Execute a query.
     *
     * Type of result:
     *  - MYSQLI_NUM: arrays with integers keys (default)
     *  - MYSQLI_ASSOC: associative arrays
     *  - MYSQLI_BOTH: both MYSQLI_NUM and MYSQLI_ASSOC
     *
     * @param bool $query Resource link to result for a query.
     * @param int $res_type Type of result (MYSQLI_NUM|MYSQLI_ASSOC|MYSQLI_BOTH).
     * @return array
     */
    function exec($query, $res_type = MYSQLI_NUM)
    {
        $res = $this->executeQuery($query);
        if ($res_type == MYSQLI_NUM) {
            return $res;
        }

        while ($values[] = $res->fetch_array($res_type)) {} // pass
        array_pop($values); // remove null value introduced last while iteration
        return $values;
    }
}
