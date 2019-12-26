<?php

namespace smn\lazyc\dbc\Operator;

use smn\lazyc\dbc\Catalog\Column;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WildCard
 *
 * @author simon
 */

class Wildcard extends Column {
    
    public function __construct() {
        parent::__construct('*');
    }
    
}

