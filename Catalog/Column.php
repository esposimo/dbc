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
use PDO;

/**
 * La classe Column rappresenta una colonna di una tabella del database.<br>
 * Estende la AbstractCatalogObject e implementa la BindableInterface per<br>
 * bindare un parametro ad essa
 *
 * @author Simone Esposito
 * @email simone.esposito1986@gmail.com
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class Column extends AbstractCatalogObject implements BindableInterface {

    /**
     * Nome da bindare alla colonna
     * @var String
     */
    protected $bindname;

    /**
     * Valore da bindare alla colonna. Può essere una stringa, un numero<br>
     * o una resource come ad es. un file pointer, per storicizzare campi<br>
     * LOB
     * @var Mixed 
     */
    protected $bindvalue;

    /**
     * Variabile che contiene il bindtype. Seguono la logica delle<br>
     * PDO::PARAM_*. Di default è PDO::PARAM_STR
     * @var Int 
     */
    protected $bindType = PDO::PARAM_STR;

    /**
     * Variabile di configurazione per l'autodeterminazione. Se true,<br>
     * la classe gestisce in automatico il bindType
     * @var Bool 
     */
    protected $auto_type = true;

    /**
     * Costruttore della classe Column. La colonna ha un nome e un valore<br>
     * che verranno configurati insieme al pattern e al placeholder
     * @param String $name Nome della colonna
     * @param String $value Valore della colonna
     */
    public function __construct($name, $value = null) {
        parent::__construct($name);
        $this->unique_id = uniqid();
        $this->setBindName($name);
        $this->setBindValue($value);
        $this->setPattern('%column$s');
        $this->addPlaceHolder('column', $this->getName());
    }

    /**
     * Metodo privato che autodetermina il tipo di dato da bindare
     * @return Int
     */
    private function checkTypeColumn() {
        $value = $this->getBindValue();
        if (is_string($value)) {
            $param_type = PDO::PARAM_STR;
        } else if (is_numeric($value)) {
            if (is_int($value)) {
                $param_type = PDO::PARAM_INT;
            } else {
                $param_type = PDO::PARAM_STR;
            }
        } else if (is_null($value)) {
            $param_type = PDO::PARAM_NULL;
        } else if (is_bool($value)) {
            $param_type = PDO::PARAM_BOOL;
        } else if (is_resource($value())) {
            $param_type = PDO::PARAM_LOB;
        } else {
            $param_type = PDO::PARAM_STR;
        }
        return $param_type;
    }

    /**
     * Configura il padre e ne eredita i placeholder. Modifica il pattern
     * @param ParentalInterface $catalog
     * @return self
     */
    public function setParent(ParentalInterface $catalog) {
        $schema_operator = new \smn\lazyc\dbc\Operator\AbstractOperator();
        $schema_operator->setPattern('%tablename$s.%inherit$s');
        $schema_operator->addPlaceHolder('tablename', $catalog->getName());
        $this->addOperator('table', $schema_operator);
        parent::setParent($catalog);
        return $this;
    }

    /**
     * Restituisce la stringa tenendo conto del parent
     * @see PrintableInterface::toString()
     * @return String
     */
    public function toString() {
//        if ($this->hasParent()) {
//            $newpattern = sprintf('%s.%s', $this->getParent()->getPattern(true), $this->getPattern(false));
//            $this->setPattern($newpattern);
//            foreach ($this->getPlaceHolders() as $key => $value) {
//                $this->addPlaceHolder($key, $value);
//            }
//        }
        return AbstractCatalogObject::renderInstance($this);
    }

    /**
     * Configura a true o false l'autodeterminazione del tipo di dato
     * @param bool $auto_type
     * @return self
     */
    public function enableAutoType(bool $auto_type = true) {
        $this->auto_type = $auto_type;
        return $this;
    }

    /**
     * Restituisce il nome del bindName
     * @return String
     */
    public function getBindName() {
        return $this->getBindName();
    }

    /**
     * Restituisce il valore bindato
     * @return Mixed
     */
    public function getBindValue() {
        return $this->bindvalue;
    }

    /**
     * Restituisce il valore di una delle costanti PDO::PDO_PARAM_* in base
     * al tipo di colonna
     * @return Int|Null
     */
    public function getTypeParam() {
        return $this->bindType;
    }

    /**
     * Configura il bind name
     * @param String $name
     */
    public function setBindName($name) {
        $real_name = sprintf(':%s_%s', $this->unique_id, $name);
        $this->bindname = $real_name;
        return $this;
    }

    /**
     * Configura il bind value
     * @param Mixed $value
     */
    public function setBindValue($value) {
        $this->bindvalue = $value;
        if ($this->auto_type === true) {
            $this->setTypeParam($this->checkTypeColumn());
        }
        return $this;
    }

    /**
     * Imposta la tipologia di parametro in base ai PDO::PARAM_*
     * @param Int
     * @return self
     */
    public function setTypeParam($type) {
        $this->bindType = $type;
        return $this;
    }

   

}