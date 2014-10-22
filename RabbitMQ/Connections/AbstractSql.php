<?php
/*
  Abstracción:
  se define un "contrato" abstracto en donde todas las clases "hijas" deben implementar los metodos descritos
  en el contrato.

  Esto se puede lograr mediante clases abstractas o bien Interfaces.

  Ejemplo:
  la clase abstracta SqlAbstract es implementada por las clases SqlMySql y SqlPostgres
*/

namespace Connections {

    abstract class AbstractSql
    {
        /*
          Herencia:
          las clases pueden heredar metodos y propiedades de los padres siempre y cuando estas sean public o protected

          Ejemplo:
          Todos los atributos tipo protected son accesibles desde las clases hijas, esto les permite acceder a ellas facilmente
        */
        protected $server;
        protected $database;
        protected $user;
        protected $password;
        //protected $port;
        protected $driver;
        public function __construct($server, $database, $user, $password)
        {
            $this->server   = $server;
            $this->database = $database;
            $this->user     = $user;
            $this->password = $password;
            //$this->port     = $port;
        }

        abstract public function connect();
        abstract public function disconnect();
        abstract public function runSql($sql);
        abstract public function nextResultRow($result);
    }
}
