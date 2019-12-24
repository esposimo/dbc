<?php

/*
 * L'interfaccia Parental permette di gestire un padre (singolo) e tanti figli
 * di tipo CatalogInterface ad una classe che rappresenta un oggetto di un database
 * Ad esempio uno schema DB avrà tanti figli (tabelle, viste, procedure) ma non avrà nessun padre.
 * Una colonna invece non avrà figli ma avrà sicuramente un padre,  ovvero una tabella
 * Una tabella invece avrà sia un padre (lo schema) che dei figli (colonne)
 * I figli vengono aggiunti tramite un nome univoco all'interno dell'istanza della classe,
 * per permetterne una eventuale rimozione
 */

/**
 *
 * @author simon
 */
interface Parentalnterface {
    public function setParent(CatalogInterface $catalog);
    
    public function getParent();
    
    public function addChild(String $name, CatalogInterface $catalog);
    
    public function hasChild(String $name);
    
    public function getChild(String $name);
    
    public function removeChild(String $name);
}
