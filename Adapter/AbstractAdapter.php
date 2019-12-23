<?php

namespace smn\lazyc\dbc\Adapter;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Adapter
 *
 * @author simon
 */
abstract class AbstractAdapter implements Adapter\AdapterInterface {
/*
 * 
 * forse è l'adapter che deve eseguire query e transazioni e restituire il risultato
 * 
 * gli adapter specifici dovrebbero gestire opzioni che offri tramite l'adapter con metodi astratti es.
 * 
 * se c'è un lock
 * e altro
 * 
 */
    
    /**
     * 
     */
    const CONFIG_INDEX_ADAPTER = 'adapter';
    
    /**
     * 
     */
    const CONFIG_INDEX_STATEMENT = 'statement';
    
    
    
    /**
     * Variabile che contiene l'istanza PDO
     * @var \PDO
     */
    protected $pdo;

    /**
     * Variabile che contiene lo statement da eseguire
     * @var \PDOStatement 
     */
    protected $pdo_statement;

    /**
     * Connection info for construct dsn
     * @var Array 
     */
    protected $connection_info;
    
    
    /**
     * Nome del database al quale connettersi
     * @var String 
     */
    protected $dbname;

    /**
     * 
     * @param array $connection_info info for host port and dbname or unix_socket, database defined in tnsnames.ora, based on driver
     * @param string $username
     * @param string $password
     * @param array $options to send to $options parameter of PDO class
     */
    public function __construct(array $connection_info, string $username, string $password, array $options = []) {
        $this->pdo = new \PDO($this->makeDSN($connection_info), $username, $password, $options);
    }
    
    public function setDbName(string $dbname) {
        $this->dbname = $dbname;
    }

    public function commit() {
        $this->pdo->commit();
    }

    public function rollback() {
        $this->pdo->rollBack();
    }

    final public function getPDOInstance(): \PDO {
        return $this->pdo;
    }

    final public function getPDOStatementInstance(): \PDOStatement {
        return $this->pdo_statement;
    }
    
    public function isTransaction() : bool {
        return $this->pdo->inTransaction();
    }
    
    public function errorCode() : string {
        return $this->pdo->errorCode();
    }
    
    public function errorInfo() : array {
        return $this->pdo->errorInfo();
    }
    
    public function driverErrorCode() : string {
        return $this->pdo->errorInfo()[1];
    }
    
    public function driverErrorMessage() : string {
        return $this->pdo->errorInfo()[2];
    }

    abstract public function makeDSN(array $connection_info);

    // forse anche questi due astratti ? cambiare lo statement
    public function exec(Adapter\Database\Statement $stmt) {
        
    }

    public function transaction() {
        
    }

//
//    abstract public function exec(Statement $stmt);
//    abstract public function transaction();
   
//
//    abstract public function transaction();
//
//    abstract public function exec();
}
