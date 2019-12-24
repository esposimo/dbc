<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace smn\lazyc\dbc\Catalog;

/**
 * La classe schema rappresenta uno schema di un database
 *
 * @author simon
 */
class Schema extends AbstractCatalogObject {
    
    public function toString() {
        return sprintf('%s', $this->getName());
    }

}
