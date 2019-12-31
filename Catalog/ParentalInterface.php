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
 * Questa interfaccia espone metodi per gestire i figli di un oggetto ed il suo<br>
 * singolo padre<br>
 *
 * @author Simone Esposito
 * @email simone.esposito1986@gmail.com
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
interface ParentalInterface extends CatalogInterface {

    /**
     * Configura il padre dell'oggetto di catalogo
     * @param ParentalInterface
     * @return self
     */
    public function setParent(ParentalInterface $catalog);

    /**
     * Restituisce il padre dell'oggetto di catalogo
     * @return self
     */
    public function getParent();

    /**
     * Restituisce true o false se l'oggetto ha o meno un parente
     * @return Bool
     */
    public function hasParent();

    /**
     * Aggiunge un figlio ad un oggetto. L'oggetto viene mappato tramite il 
     * $name così può essere eliminato quando necessario
     * @param String $name
     * @param ParentalInterface $catalog
     * @return self
     */
    public function addChild(String $name, ParentalInterface $catalog);

    /**
     * Restituisce true o false se il figlio con nome $name esiste
     * @param String $name
     * @return Bool
     */
    public function hasChild(String $name);

    /**
     * Restituisce il figlio con nome $name
     * @param String $name
     * @return bool|ParentalInterface
     */
    public function getChild(String $name);

    /**
     * Rimuove il figlio $name
     * @param String $name
     * @return self
     */
    public function removeChild(String $name);

    /**
     * Restituisce un array con tutti i figli
     * @return Array
     */
    public function getChildren();
}