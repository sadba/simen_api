<?php
class Database{

    public $conn;
    const SITE_KEY = '0123456789';

    // get the database connection
    public function getConnection(){
        // specify your own database credentials
        $config = parse_ini_file('../fileinfo.ini');
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=" . $config['server'] . ";dbname=" . $config['dbname'], $config['username'], $config['password']);
            //$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    /**
     * Query the database
     *
     * @param $query The query string
     * @return mixed The result of the mysqli::query() function
     */
    public function query($query) {
        // Connect to the database
        $connection = $this -> conn();

        // Query the database
        $result = $connection -> query($query);

        return $result;
    }

    public function select($query) {
        $rows = array();
        $result = $this ->query($query);
        if($result === false)
        {
            return false;
        }

        while ($row = $result -> fetch_assoc())
        {
            $rows[] = $row;
        }
        return $rows;
    }

    /**
     * Fetch the last error from the database
     *
     * @return string Database error message
     */
    public function error() {
        $connection = $this -> conn();
        return $connection -> error;
    }

    /**
     * Quote and escape value for use in a database query
     *
     * @param string $value The value to be quoted and escaped
     * @return string The quoted and escaped string
     */
    public function quote($value) {
        $connection = $this -> conn();
        return "'" . $connection -> real_escape_string($value) . "'";
    }

    public function close()
    {
        $connection = $this -> conn();
        return $connection->close();
    }

    function apiToken($session_uid)
    {
        $key=md5(SITE_KEY.$session_uid);
        return hash('sha256', $key);
    }
}

