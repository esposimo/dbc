<?php

namespace smn\lazyc\dbc\Clause;

/**
 * Description of Select
 *
 * @author simon
 */
class Select extends Clause {
    
    /**
     * Se impostato a true crea una SELECT DISTINCT
     * @var bool 
     */
    protected $distinct = false;
    
    /**
     * Modello della Select
     * @var String 
     */
    protected $pattern = 'SELECT %s';
    
    
    /**
     * Configura una query SELECT DISTINCT. Se false non usa la DISTINCT
     * @param type $distinct
     */
    public function setDistinct($distinct = true) {
        $this->distinct = $distinct;
    }

    
    public function toString() {
        $pattern = 'SELECT %s';
        if ($this->distinct) { 
         $pattern = 'SELECT DISTINCT %s';   
        }
        return sprintf($pattern, parent::toString());
    }

}