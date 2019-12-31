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
 * Questa interfaccia espone metodi per permettere ad un oggetto di catalogo<br>
 * di bindare un singolo parametro. E' possibile anche configurare il tipo di<br>
 * parametro<br>
 *
 * @author Simone Esposito
 * @email simone.esposito1986@gmail.com
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
interface BindableInterface {

    /**
     * Imposta il nome da bindare
     * @param String $name
     * @return self
     */
    public function setBindName(String $name);

    /**
     * Imposta il valore da bindare
     * @param Mixed $value
     * @return self
     */
    public function setBindValue($value);

    /**
     * Restituisce il nome bindato
     * @return String
     */
    public function getBindName();

    /**
     * Restituisce il valore bindato
     * @return Mixed
     */
    public function getBindValue();

    /**
     * Imposta la tipologia di parametro in base ai PDO::PARAM_*
     * @param Int
     * @return self
     */
    public function setTypeParam(int $type);

    /**
     * Restituisce il tipo di parametro
     * @return Int|Null
     */
    public function getTypeParam();

    /**
     * Imposta a true o false l'autodeterminazione della colonna in base
     * al bind value assegnato
     * @param Bool $auto_type
     * @return self
     */
    public function enableAutoType(bool $auto_type = true);
}