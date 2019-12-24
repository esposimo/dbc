<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace smn\lazyc\dbc;

/**
 *
 * @author simon
 */
interface ClauseInterface {
    
    /**
     * Nome della clausola
     * @param \smn\lazyc\dbc\String $name
     */
    public function setName(String $name);
    
    /**
     * Restituisce il nome della clausola
     * @return String
     */
    public function getName();
    
    
    /**
     * Formatta la stringa
     */
    public function formatString();
    
}
