<?php

namespace smn\lazyc\dbc\Catalog;

/**
 * La classe AbstractCatalogObject rappresente un oggetto di catalogo che può avere più figli 
 * ed un solo padre.
 * Inoltre espone un metodo toString() per la stampa dell'oggetto
 *
 * @author simon
 */

abstract class AbstractCatalogObject implements Parentalnterface, PrintableInterface {

    /**
     * Nome dell'oggetto di catalogo
     * @var String
     */
    protected $name;
    
    
    /**
     * Lista dei figli
     * @var ParentalInterface[] 
     */
    protected $children = [];
    
    
    /**
     * Oggetto padre
     * @var ParentalInterface 
     */
    protected $parent = null;
    
    
    /**
     * Inizializza l'oggetto con nome indicato
     * @param type $name
     */
    public function __construct($name) {
        $this->setName($name);
    }
    
    /**
     * Restituisce il nome dell'oggetto
     * @return String
     */
    public function getName() {
        return $this->name;
    }
    /**
     * Configura il nome dell'oggetto
     * @param \smn\lazyc\dbc\Catalog\String $name
     */
    public function setName(String $name) {
        $this->name = $name;
    }
    
    /**
     * Aggiunge un figlio all'oggetto
     * @param \smn\lazyc\dbc\Catalog\String $name
     * @param \smn\lazyc\dbc\Catalog\Parentalnterface $catalog
     */
    public function addChild(String $name, Parentalnterface $catalog) {
        if (!$this->hasChild($name)) {
            $this->children[$name] = $catalog;
        }
    }

    /**
     * Restituisce true o false se un figlio esiste
     * @param \smn\lazyc\dbc\Catalog\String $name
     * @return Bool
     */
    public function hasChild(String $name) {
        return array_key_exists($name, $this->children);
    }
    /**
     * Restituisce un figlio oppure false
     * @param \smn\lazyc\dbc\Catalog\String $name
     * @return type
     */
    public function getChild(String $name) {
        return ($this->hasChild($name)) ? $this->children[$name] : false;
    }
    
    /**
     * Rimuove un figlio
     * @param \smn\lazyc\dbc\Catalog\String $name
     */
    public function removeChild(String $name) {
        if ($this->hasChild($name)) {
            unset($this->children[$name]);
        }
    }

    /**
     * Restituisce la lista di tutti i figli
     * @return array
     */
    public function getChildren(): Array {
        return $this->children;
    }
    
    /**
     * Restituisce il padre
     * @return self
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Configura il padre dell'oggetto 
     */
    public function setParent(Parentalnterface $catalog) {
        $this->parent = $catalog;
    }

    /**
     * Non avendo parenti lo schema, restituisce sempre false
     * @return boolean
     */
    public function hasParent() {
        return (is_null($this->parent)) ? false : true;
    }

    /**
     * Ogni oggetto di catalogo stampa se stesso in un modo
     */
    abstract public function toString();

}
