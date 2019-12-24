<?php
namespace smn\lazyc\dbc\Adapter;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * this is a class that access to PDO object for retrive information and run query/transaction
 * @author simon
 */
interface AdapterInterface {
    
    
    /**
     * construct
     * 
     * connection
     *      host
     *      port
     *      dbname
     *      username
     *      password
     * 
     * 
     * 
     */
    
    
    /**
     * Esegue qualunque tipo di query
     */
    public function exec(Database\Statement $stmt);
    
    /**
     * Inizia una transaction
     */
    public function transaction();
    
    
    /**
     * Esegue la commit
     */
    public function commit();
    
    /**
     * Effettua un rollback
     */
    public function rollback();
    
    /**
     * Restituisce true o false se è attiva o meno una Transazione
     * @return Bool
     */
    public function isTransaction();
    
    /**
     * Restituisce informazioni sull'errore
     */
    public function errorInfo();
    
    /**
     * Restituisce il codice di errore
     */
    public function errorCode();
    
    /**
     * Restituisce il codice d'errore del driver
     */
    public function driverErrorCode();
    
    /**
     * Restituisce il messaggio d'errore del driver
     */
    public function driverErrorMessage();
    
    /**
     * Configura il database da associare a questa istanza
     * @param string $dbname
     */
    public function setDbName(string $dbname);


    /**
     * Return real PDO Instance
     * @return \PDO
     */
    public function getPDOInstance() : \PDO;
    
    
    /**
     * Restituisce l'istanza PDOStatement utilizzata per effettuare le query
     * @return \PDOStatement
     */
    public function getPDOStatementInstance() : \PDOStatement;
    
    
    /**
     * Metodo utilizzato per creare il DSN di connessione
     * @param array $connection_info
     * @return string
     */
    public function makeDSN(array $connection_info) : string;
    
    
}
