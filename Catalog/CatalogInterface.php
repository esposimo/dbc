<?php

namespace smn\lazyc\dbc\Catalog;
/*
 * La CatalogInterface è una clase che si occupa solamente di gestire il nome
 * dell'oggetto di catalogo (nome dello schema, della tabella, procedura, etc)
 */

/**
 *
 * @author simon
 */
interface CatalogInterface {
    
    /**
     * Configura il nome
     * @param \smn\lazyc\dbc\Catalog\String $name
     */
    public function setName(String $name);
    
    
    /**
     * Restituisce il nome
     */
    public function getName();
    
    
}
