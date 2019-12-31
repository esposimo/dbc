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

namespace smn\lazyc\dbc\Operator;
use smn\lazyc\dbc\Operator\OperatorInterface;
use smn\lazyc\dbc\Catalog\AbstractCatalogObject;
use smn\lazyc\dbc\Catalog\PrintableInterface;

/**
 * La classe Operator si occupa di trasformare il pattern ed i placeholder di<br>
 * un oggetto di catalogo.<br>
 * Il placeholder 'inherit$s' è un placeholder speciale, esso sarà sostituito dal<br>
 * pattern dell'oggetto di catalogo al quale l'Operator viene assegnato
 *
 * @author Simone Esposito
 * @email simone.esposito1986@gmail.com
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
/**

 */
class AbstractOperator implements OperatorInterface {

    /**
     * Lista dei placeholder
     * @var Array 
     */
    protected $placeholders = array();

    /**
     * Pattern dell'operatore
     * @var String 
     */
    protected $pattern = '%inherit$s';

    /**
     * Unique id per garantire l'univocità dei placeholder
     * @var String 
     */
    protected $unique_id;

    /**
     * Costruttore della classe. L'operatore generico crea soltanto un uniqid
     */
    public function __construct() {
        $this->unique_id = uniqid();
    }

    /**
     * Questo metodo modifica il pattern dell'operatore
     * sostituendo "%inherit" con il pattern dell'oggetto di catalogo.
     * Dopo averlo sostituito, procede alla sostituzione dei suoi placeholder
     * con i placeholder inclusi di prefisso unique.
     * Infine passa i placeholder ed il nuovo
     * pattern all'istanza di catalogo
     * questo per evitare che due operatori possano usare lo stesso placeholder
     * inviando il prefisso dei placeholder non si perde la referenza
     * @param PrintableInterface $catalog
     */
    public function configureInstance($catalog) {

        $inherit = $catalog->getPattern(false);
        $newpattern = preg_replace('/%(inherit)\$s/', $inherit, $this->getPattern(false));
        $map = array_combine(
                array_keys($this->getPlaceHolders(false)),
                array_keys($this->getPlaceHolders(true))
        );

        array_walk($map, function($value, $key) use (&$newpattern) {
            $pattern = '/%(' . $key . ')\$s/';
            $newpattern = preg_replace($pattern, '%' . $value . '$s', $newpattern);
        });
        $catalog->setPattern($newpattern);
        foreach ($this->getPlaceHolders(true) as $key => $value) {
            $catalog->addPlaceHolder($key, $value);
        }
    }

    /**
     * Restituisce un placeholder dell'operatore
     * @param String $name
     * @return String
     */
    public function getPlaceHolder($name) {
        return $this->placeholders[$name];
    }

    /**
     * Aggiunge un placeholder con valore $value. Restituisce se stessa.
     * @param String $name Nome del placeholder
     * @param String $value Valore del placeholder
     * @return self
     */
    public function addPlaceHolder($name, $value) {
        if (!$this->hasPlaceHolder($name)) {
            $this->placeholders[$name] = $value;
        }
        return $this;
    }

    /**
     * Restituisce un array dove le chiavi sono i nome dei placeholder ed i valori<br>
     * i rispettivi sostituti.<br>
     * Se $use_map è true, le chiavi dell'array includeranno il prefisso.<br>
     * @param Bool $use_map
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
     * Cancella i placeholders
     * @return self
     */
    public function cleanPlaceHolder() {
        $this->placeholders = array();
        return $this;
    }

    /**
     * Restituisce il pattern dell'operatore. Se $use_map è true, restituisce<br>
     * il pattern con i placeholder inclusi di prefisso
     * @param Bool $use_map
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
     * Restituisce true o false se un placeholder esiste
     * @param String $name
     * @return Bool
     */
    public function hasPlaceHolder($name) {
        return array_key_exists($name, $this->placeholders);
    }

    /**
     * Rimuove un placeholder dall'operatore
     * @param String $name
     * @return self
     */
    public function removePlaceHolder($name) {
        unset($this->placeholders[$name]);
        return $this;
    }

    /**
     * Configura il pattern dell'operatore
     * @param String $pattern Pattern da configurare
     * @return self
     */
    public function setPattern($pattern) {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * Non fa nulla. Anzi no, restituisce false.
     * @return Bool
     */
    public function toString() {
        return false;
    }

}
