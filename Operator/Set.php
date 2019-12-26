<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace smn\lazyc\dbc\Operator;

/**
 * Description of Set
 *
 * @author simon
 */

class Set extends \smn\lazyc\dbc\Clause\Clause {

    public function __construct($bindparams) {
        parent::__construct();
        foreach ($bindparams as $bindName => $bindValue) {
            $this->addBindParam($bindName, $bindValue);
        }
    }

    public function toString() {

        $sets = [];
        foreach ($this->keybind as $key) {
            $sets[] = sprintf("%s = %s", $key, $this->generateBindKey($key));
        }
        return implode(",", $sets);
    }

}