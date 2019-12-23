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
     * exec a simple query
     */
    public function exec(Database\Statement $stmt);
    public function transaction();
    
    
    public function commit();
    public function rollback();
    public function isTransaction();
    public function errorInfo();
    public function errorCode();
    public function driverErrorCode();
    public function driverErrorMessage();
    public function setDbName(string $dbname);


    /**
     * Return real PDO Instance
     * @return \PDO
     */
    public function getPDOInstance() : \PDO;
    
    
    public function getPDOStatementInstance() : \PDOStatement;
    
    
    public function makeDSN(array $connection_info) : string;
    
    
}
