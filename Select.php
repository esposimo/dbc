<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace smn\lazyc\dbc;

/**
 * Description of Select
 *
 * @author simon
 */
class Select implements \smn\lazyc\dbc\ClauseInterface {

    protected $name;

    public function formatString() {
        
    }

    public function getName(): String {
        return $this->name;
    }

    public function setName(String $name) {
        $this->name = $name;
    }

}
