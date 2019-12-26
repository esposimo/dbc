<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace smn\lazyc\dbc\Operator;

/**
 * Description of Alias
 *
 * @author simon
 */

class Alias implements PrintableInterface {
    
    /**
     * Nome della colonna 
     * @var String|Column 
     */
    protected $column = null;
    
    /**
     * Alias da assegnare
     * @var String|PrintableInterface 
     */
    protected $alias = null;
    /**
     * 
     * @param String|PrintableInterface $column
     * @param String|PrintableInterface $alias
     */
    public function __construct($column, $alias) {
        $this->setColumn($column);
        $this->setAlias($alias);
    }
    
    /**
     * Configura la colonna dell'alias
     * @param String|PrintableInterface $column
     */
    public function setColumn($column) {
        $this->column = $column;
    }
    
    /**
     * Configura l'alias della colonna
     * @param String|PrintableInterface $alias
     */
    public function setAlias($alias) {
        $this->alias = $alias;
    }
    
    /**
     * Restituisce la stringa in formato colonna
     * @return String
     */
    public function getColumn() {
        return ($this->column instanceof PrintableInterface) ? $this->column->toString() : $this->alias;
    }
    
    /**
     * Restituisce l'alias in formato stringa
     * @return type
     */
    public function getAlias() {
        return ($this->alias instanceof PrintableInterface) ? $this->alias->toString() : $this->alias;
    }

    /**
     * Restituisce l'Alias in formato stringa
     * @return type
     */
    public function toString() {
        $pattern = '%s AS %s';
        return sprintf($pattern, $this->getColumn(), $this->getAlias());
    }
    

}
