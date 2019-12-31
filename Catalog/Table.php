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

/**
 * Description of Table
 *
 * @author Simone Esposito
 * @email simone.esposito1986@gmail.com
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class Table extends AbstractCatalogObject {

    /**
     * Pattern della tabella
     * @var type 
     */
    protected $pattern = '%tablename$s';

    /**
     * Costruttore della classe. Richiama il parent e aggiunge un placeholder
     * @param String $name Nome della tabella
     */
    public function __construct($name) {
        parent::__construct($name);
        $this->addPlaceHolder('tablename', $name);
    }

    /**
     * Configura il padre della tabella, ovvero il nome dello schema
     * @param AbstractCatalogObject $catalog Nome dell'oggetto di catalogo padre
     * @return self
     */
    public function setParent(AbstractCatalogObject $catalog) {
        $schema_operator = new \smn\lazyc\dbc\Operator\AbstractOperator();
        $schema_operator->setPattern('%dbschema$s.%inherit$s');
        $schema_operator->addPlaceHolder('dbschema', $catalog->getName());
        $catalog->addOperator('dbschema', $schema_operator);
//        $this->placeholders = array_merge($this->placeholders, $catalog->getPlaceHolders(true));
        parent::setParent($catalog);
//        $newpattern = sprintf('%s.%s', $this->getParent()->getPattern(true), $this->getPattern(false));
//        $this->setPattern($newpattern);
        return $this;
    }

//    public function setParent(ParentalInterface $catalog) {
//        $this->placeholders = array_merge($this->placeholders, $catalog->getPlaceHolders(true));
//        parent::setParent($catalog);
//        $newpattern = sprintf('%s.%s', $this->getParent()->getPattern(true), $this->getPattern(false));
//        $this->setPattern($newpattern);
//        return $this;
//    }
}
