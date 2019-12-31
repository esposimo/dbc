<?php

/*
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCL  UDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 */

namespace smn\lazyc\dbc\Catalog;
use smn\lazyc\dbc\Operator\OperatorInterface;

/**
 * Description of AbstractCatalogObject
 * La classe AbstractCatalogObject si occupa di gestire un oggetto di catalogo 
 * generico. Estendere questa classe permette di rappresentare qualsiasi oggetto
 * di catalogo di un database (tabelle, colonne, viste, procedure, etc)
 *
 * @author Simone Esposito
 * @email simone.esposito1986@gmail.com
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class AbstractCatalogObject implements CatalogObjectInterface {

    /**
     * Lista dei figli
     * @var CatalogObjectInterface[] 
     */
    protected $children = [];

    /**
     * Oggetto padre dell'oggeto di catalogo
     * @var CatalogObjectInterface
     */
    protected $parent = null;

    /**
     * Unique id per creare i placeholder diversi da altre istanze. Ciò garantisce
     * che un'istanza padre e/o figlio se ha lo stesso placeholder non 
     * entrerà in conflitto in fase di rendering dei placeholder
     * @var String 
     */
    protected $unique_id;

    /**
     * Array associativo placeholder => valore
     * @var Array 
     */
    protected $placeholders = [];

    /**
     * Pattern da utilizzare per il rendering
     * @var String 
     */
    protected $pattern = '%s';

    /**
     * Lista degli operatori
     * @var smn\lazyc\dbc\OperatorInterface[]
     */
    protected $operators = [];

    /**
     * Nome dell'oggetto di catalogo
     * @var String 
     */
    protected $name;

    /**
     * Inizializza la classe
     * Crea l'unique_id e configura come nome il $name passato
     */
    public function __construct($name) {
        $this->setName($name);
        $this->unique_id = uniqid();
    }

    /**
     * Aggiunge un figlio all'oggetto. Configura per la classe figlio se stessa
     * come padre
     * @param String $name
     * @param CatalogObjectInterface $catalog
     * @return self
     */
    public function addChild(String $name, CatalogObjectInterface $catalog) {
        if (!$this->hasChild($name)) {
            $this->children[$name] = $catalog;
            $catalog->setParent($this);
        }
        return $this;
    }

    /**
     * Restituisce un figlio se esiste, altrimenti false
     * @param String $name
     * @return Bool|CatalogObjectInterface
     */
    public function getChild(String $name) {
        return ($this->hasChild($name)) ? $this->children[$name] : false;
    }

    /**
     * Restituisce true o false se il figlio $name esiste
     * @param String $name
     * @return Bool
     */
    public function hasChild(String $name) {
        return array_key_exists($name, $this->children);
    }

    /**
     * Rimuove un figlio di nome $name. Se non esiste non genera errore
     * @param String $name
     * @return self
     */
    public function removeChild(String $name) {
        if ($this->hasChild($name)) {
            unset($this->children[$name]);
        }
        return $this;
    }

    /**
     * Restituisce tutti i figli dell'oggetto di catalogo
     * @return array
     */
    public function getChildren() {
        return $this->children;
    }

    /**
     * Restituisce true o false se l'oggetto ha o meno un padre
     * @return bool
     */
    public function hasParent() {
        return (is_null($this->parent)) ? false : true;
    }

    /**
     * Restituisce il padre
     * @return CatalogObjectInterface
     */
    public function getParent() {
        return $this->parent;
    }

    /**
     * Configura il padre dell'oggetto 
     * @param CatalogObjectInterface $catalog
     * @return self
     */
    public function setParent(CatalogObjectInterface $catalog) {
        $this->parent = $catalog;
        return $this;
    }

    /**
     * Aggiunge un placeholder
     * @param String $name
     * @param String $value
     * @return self
     */
    public function addPlaceHolder($name, $value) {
        if (!$this->hasPlaceHolder($name)) {
            $this->placeholders[$name] = $value;
        }
        return $this;
    }

    /**
     * Pulisce l'array dei placeholder
     * @return self
     */
    public function cleanPlaceHolder() {
        $this->placeholders = array();
        return $this;
    }

    /**
     * Restituisce il pattern dell'oggetto.
     * Se use_map è true, restituisce il pattern con i placeholder
     * già mappati
     * @param bool $use_map
     * @return String
     */
    public function getPattern($use_map = true) {
        if ($use_map == false) {
            return $this->pattern;
        }
        $pattern = $this->getPattern(false);
        $placeholders = $this->getPlaceHolders(false);
        $remap = array_combine(array_keys($placeholders), array_keys($this->getPlaceHolders(true)));
        $remap_str = preg_replace_callback('/(^|[^%])%([a-zA-Z0-9_-]+)\$/',
                function($m) use ($remap) {
            return $m[1] . '%' . $remap[$m[2]] . '$';
        },
                $pattern);
        return $remap_str;
    }

    /**
     * Restituisce il valore di un placeholder. Se il placeholder non esiste
     * restituisce false
     * @param String $name
     * @return String|Bool
     */
    public function getPlaceHolder($name) {
        if ($this->hasPlaceHolder($name)) {
            return $this->placeholders[$name];
        }
        return false;
    }

    /**
     * Restituisce tutti i placeholder. Se $use_map è false, non aggiunge il prefisso
     * ai placeholder
     * @return Array
     */
    public function getPlaceHolders($use_map = true) {
        if ($use_map == false) {
            return $this->placeholders;
        }
        $key_arrays = array_map(
                function($k) {
            return sprintf('%s_%s', $this->unique_id, $k);
        }, array_keys($this->placeholders)
        );
        return array_combine($key_arrays, $this->placeholders);
    }

    /**
     * Restituisce true o false se un placeholder esiste
     * @param String $name
     * @return bool
     */
    public function hasPlaceHolder($name) {
        return array_key_exists($name, $this->placeholders);
    }

    /**
     * Rimuove un placeholder
     * @param String $name
     * @return self
     */
    public function removePlaceHolder($name) {
        if ($this->hasPlaceHolder($name)) {
            unset($this->placeholders[$name]);
        }
        return $this;
    }

    /**
     * Configura il pattern della classe
     * @param String $pattern
     * @return self
     */
    public function setPattern($pattern) {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Renderizza la stringa
     * @return String
     */
    public function toString() {
        return AbstractCatalogObject::renderInstance($this);
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
     * @param String $name
     * @return self
     */
    public function setName(String $name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Questo è un algoritmo preso dalla documentazione ufficiale della funzione vsprintf()
     * @link https://www.php.net/manual/en/function.vsprintf.php A little help from user
     * @param CatalogObjectInterface $instance
     * @return String
     */
    public static function renderInstance(CatalogObjectInterface $instance) {

        foreach ($instance->getOperators() as $operator) {
            $operator->configureInstance($instance);
        }

        $map = array_flip(array_keys($instance->getPlaceHolders(true)));
        $new2_str = preg_replace_callback('/(^|[^%])%([a-zA-Z0-9_-]+)\$/',
                function($m) use ($map) {
            return $m[1] . '%' . ($map[$m[2]] + 1) . '$';
        },
                $instance->getPattern(true));
        return vsprintf($new2_str, $instance->getPlaceHolders(true));
    }

    /**
     * Aggiunge un Operator a l'oggetto di catalogo. L'operator è gestibile<br>
     * tramite il $name
     * @param String $name Nome dell'operator
     * @param OperatorInterface $operator Classe che implementa OperatorInterface
     * @return self
     */
    public function addOperator($name, $operator) {
        if (!$this->hasOperator($name)) {
            $this->operators[$name] = $operator;
        }
        return $this;
    }

    /**
     * Restituisce true o false se l'Operator con nome $name esiste
     * @param String $name Nome dell'operator
     * @return Bool
     */
    public function hasOperator($name) {
        return array_key_exists($name, $this->operators);
    }

    /**
     * Rimuove un operator con nome $name
     * @param String $name Nome dell'operator
     * @return self
     */
    public function removeOperator($name) {
        if ($this->hasOperator($name)) {
            unset($this->operators[$name]);
        }
        return $this;
    }

     /**
     * Restituisce l'operator precedentemente aggiunto con nome $name
     * @param String $name Nome dell'operator
     * @return Bool|OperatorInterface
     */
    public function getOperator($name) {
        if ($this->hasOperator($name)) {
            return $this->operators[$name];
        }
        return false;
    }

    /**
     * Restituisce la lista di tutti gli operator aggiunti all'oggetto di<br>
     * catalogo
     * @return OperatorInterface[]
     */
    public function getOperators() {
        return $this->operators;
    }

}
