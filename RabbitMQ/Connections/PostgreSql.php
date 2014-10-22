<?php

namespace Connections {

    class PostgreSql extends AbstractSql
    {
        public function __construct($server, $database, $user, $password)
        {
            parent::__construct($server, $database, $user, $password);
        }

        public function connect()
        {
            $conn_string = "host=$this->server port=5433 dbname=$this->database user=$this->user password=$this->password";
            $this->driver = pg_connect($conn_string) or die('connection failed');
        }

        public function disconnect()
        {
            pg_close($this->driver);
        }

        public function runSql($sql)
        {
            return pg_query($this->driver, $sql);
        }

        public function nextResultRow($result)
        {
            return pg_fetch_assoc($result);
        }
    }
}
