<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace smn\lazyc\dbc\Catalog;

/**
 * Rappresenta una procedura
 *
 * @author simon
 */
class Procedura extends AbstractCatalogObject {
    
    public function toString() {
        if ($this->hasParent()) {
            return sprintf('%s.%s', $this->getParent()->toString(), $this->getName());
        }
        return sprintf('%s', $this->getName());
    }  
}