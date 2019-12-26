<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace smn\lazyc\dbc\Clause;

/**
 * Description of From
 *
 * @author simon
 */

class From extends smn\lazyc\dbc\Clause\Clause {

    /**
     * Modello della From
     * @var String 
     */
    protected $pattern = 'FROM %s';

    public function toString() {
        return sprintf($this->pattern, parent::toString());
    }

}