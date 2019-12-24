<?php
namespace smn\lazyc\dbc\Catalog;
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
interface Parentalnterface extends CatalogInterface {
    /**
     * Configura il padre dell'oggetto di catalogo
     */
    public function setParent(CatalogInterface $catalog);
    
    /**
     * Restituisce il padre dell'oggetto di catalogo
     * @return self
     */
    public function getParent();
    
    /**
     * Restituisce true o false se l'oggetto ha o meno un parente
     * @return ParentalInterface
     */
    public function hasParent();
    
    /**
     * Aggiunge un figlio ad un oggetto
     * @param \smn\lazyc\dbc\Catalog\String $name
     * @param \smn\lazyc\dbc\Catalog\ParentalInterface $catalog
     */
    public function addChild(String $name, Parentalnterface $catalog);
    
    /**
     * Restituisce true o false se il figlio esiste
     * @param \smn\lazyc\dbc\Catalog\String $name
     * @return Bool
     */
    public function hasChild(String $name);
    
    /**
     * Restituisce un figlio in base al $name
     * @param \smn\lazyc\dbc\Catalog\String $name
     * @return CatalogInterface
     */
    public function getChild(String $name);
    
    /**
     * Rimuove un figlio in base al $name
     * @param \smn\lazyc\dbc\Catalog\String $name
     */
    public function removeChild(String $name);
    
    /**
     * Restituisce un array con tutti i figli
     * @return Array
     */
    public function getChildren();
}
