<?php

namespace smn\lazyc\dbc\Clause;

/**
 * L'interfaccia Clause serve per creare un oggetto di tipo Clause che gestisce
 * i dati in esso presenti.
 * Le clause possono essere indicizzate o meno, non è un obbligo. Se non si specifica
 * una key per un dato aggiunto alla Clause, non sarà possibile poi ricavarlo per modificarlo
 * o eliminarlo, o valutarne l'esistenza
 */
interface ClauseInterface {

    /**
     * Aggiunge dei dati alla Clause che poi saranno lavorati dall'oggetto per
     * generare la Clause
     * @param String $data
     * @param String|Clause $key
     */
    public function addData($data, $key = null);

    /**
     * Restituisce true o false se un dato esiste
     * @param String $key
     */
    public function hasData($key);

    /**
     * Restituisce un dato presente all'interno della Clause
     * @param String $key
     */
    public function getData($key);

    /**
     * Rimuove un dato presente nella Clause
     * @param String $key
     */
    public function removeData($key);

    /**
     * Modifica un dato presente nella Clause
     * @param String $key
     * @param Mixed $data
     */
    public function modifyData($key, $data);
    
    /**
     * Restituisce tutti i dati configurati
     * @return \Array
     */
    public function getAllData();
}