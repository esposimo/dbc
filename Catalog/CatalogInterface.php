<?php

/*
 * La CatalogInterface è una clase che si occupa solamente di gestire il nome
 * dell'oggetto di catalogo (nome dello schema, della tabella, procedura, etc)
 */

/**
 *
 * @author simon
 */
interface CatalogInterface {
    
    
    public function setName(String $name);
    
    public function getName();
    
    
}
