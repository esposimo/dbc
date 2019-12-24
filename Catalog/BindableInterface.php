<?php
namespace smn\lazyc\dbc\Catalog;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author simon
 */
interface BindableInterface {
    
    
    /**
     * Aggiunge un parametro da bindare
     * @param \smn\lazyc\dbc\String $name
     * @param \smn\lazyc\dbc\String $value
     */
    public function addBindParam(String $name, String $value);
    
    /**
     * Restituisce true o false se un parametro esiste
     * @param \smn\lazyc\dbc\String $name
     * @return bool
     */
    public function hasBindParam(String $name);
    
    /**
     * Restituisce un singolo parametro
     * @param \smn\lazyc\dbc\String $name
     */
    public function getBindParam(String $name);
    
    /**
     * Rimuove un parametro
     * @param \smn\lazyc\dbc\String $name
     */
    public function removeBindParam(String $name);
    
    /**
     * Restituisce tutti i parametri
     */
    public function getBindParams();
    
}
