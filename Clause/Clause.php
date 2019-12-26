<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace smn\lazyc\dbc\Clause;

use \smn\lazyc\dbc\Catalog\BindableInterface;
use \smn\lazyc\dbc\Catalog\PrintableInterface;


/**
 * La classe Clause è una classe generica che si occupa di
 * storicizzare tutti i campi che possono essere utilizzati in una Clause.
 * In SQL una clase è una istruzione a se stante o che può essere utilizzata insieme
 * ad altre Clause. La select ad esempio è una Clause che può essere utilizzata
 * da sola. La Clause From ,o Where, possono essere utilizzate solo con Select, Insert
 * Update
 * Per questo motivo la Clause può accettare qualunque tipo di dato in aggiunta ad esso
 * come altre Clause, o interi Statement. Ad esempio il valore di una From Clause 
 * può essere una tabella passata come stringa, una Table estesa di CatalogObject,
 * oppure un intero Statement.
 * In fase di creazione della stringa della Clause, sarà la classe stessa ad occuparsi
 * di ricavare eventuali parametri di binding.
 */
class Clause implements BindableInterface, PrintableInterface, ClauseInterface {

    /**
     * Contiene l'unique id che fa da prefisso ai parametri di binding.
     * Sufficiente per evitare conflitti con altri oggetti che bindano parametri
     * con lo stesso valore
     * @var String 
     */
    protected $unique_id = null;

    /**
     * Lista dei parametri di binding. La chiave è il valore che verrà inserito
     * nella Clause (o nell'interno Statement). I valori dell'array sono i valori 
     * effettivi
     * @var Array 
     */
    protected $bindparams = [];

    /**
     * Lista dei campi reali da bindare. Questo array è utilizzato solo per i campi
     * di questa clausola
     * @var Array 
     */
    protected $keybind = [];

    /**
     * Array misto di informazioni da aggiungere alla Clause. Possono essere presenti
     * stringhe, PrintableInterface, BindableInterface
     * @var Array 
     */
    protected $data = [];

    /**
     * Costruttore della classe. Genera un unique_id in fase di creazione dell'oggetto
     * Riceve eventuali dati da aggiungere appena creata
     * @param Array $data
     */
    public function __construct($data = []) {
        $this->unique_id = uniqid();
        foreach ($data as $key => $value) {
            $this->addData($value, $key);
        }
    }

    /**
     * Funzione che si occupa di ricavare il valore della chiave compresa
     * di unique_id per gestire le chiavi dell'array $bindparams
     * @param String $name
     * @return String
     */
    protected function generateBindKey($name) {
        return sprintf(':%s_%s', $this->unique_id, $name);
    }

    /**
     * Aggiunge un parametro da bindare
     * @param String $name
     * @param String $value
     */
    public function addBindParam(String $name, String $value) {
        if (!$this->hasBindParam($name)) {
            $bindkey = $this->generateBindKey($name);
            $this->keybind[$name] = $bindkey;
            $this->bindparams[$bindkey] = $value;
        }
    }

    /**
     * Restituisce un parametro da bindare
     * @param String $name
     * @return String
     */
    public function getBindParam(String $name) {
        if ($this->hasBindParam($name)) {
            $bindkey = $this->generateBindKey($name);
            return $this->bindparams[$bindkey];
        }
    }

    /**
     * Restituisce tutti i parametri da bindare. L'array risultante avrà come
     * chiave i nomi bindati nella Clause, come valori i rispettivi valori
     * @return Array
     */
    public function getBindParams() {
        $values = [];
        foreach ($this->keybind as $key => $bindKey) {
            $values[$bindKey] = $this->bindparams[$bindKey];
        }
        return $values;
    }

    /**
     * Restituisce true o false se una chiave esiste all'interno di questa Clause,
     * non in quelli ereditati
     * @param String $name
     * @return bool
     */
    public function hasBindParam(String $name): bool {
        return array_key_exists($name, $this->keybind);
    }

    /**
     * Rimuove un parametro bindato
     * @param String $name
     */
    public function removeBindParam(String $name) {
        if ($this->hasBindParam($name)) {
            $bindkey = $this->generateBindKey($name);
            unset($this->keybind[$name]);
            unset($this->bindparams[$bindkey]);
        }
    }

    /**
     * Genera la stringa della Clause
     * N.B. Gestire istanze dinamiche da aggiungere e valutare
     * Creare un array multidimensionale fatto da
     * indice: tipologia di oggetto (interfaccia o classe)
     * valori: lista di callback indicizzate o meno, per eliminarle se necessario
     * @return String
     */
    public function toString() {
        $prepared = [];
        foreach ($this->data as $data) {
            if (is_string($data)) {
                $prepared[] = $data;
            }
            if ($data instanceof BindableInterface) {
                $merge = array_merge($this->bindparams, $data->getBindParams());
                $this->bindparams = $merge;
            }
            if ($data instanceof PrintableInterface) {
                $prepared[] = $data->toString();
            }
        }
        return implode(',', $prepared);
    }

    /**
     * Aggiunge dei dati alla Clause che poi saranno lavorati dall'oggetto per
     * generare la Clause
     * @param String $key
     * @param String|Clause $data
     */
    public function addData($data, $key = null) {
        if ((!$key) || ($key == 0)) {
            $this->data[] = $data;
        } else if ((is_string($key)) || (is_numeric($key))) {
            $this->data[$key] = $data;
        }
        else {
            throw new \Exception('Chiave con valore non accettato');
        }
    }

    /**
     * Restituisce true o false se la $key esiste
     * @param type $key
     * @return Bool
     */
    public function hasData($key) {
        return array_key_exists($key, $this->data);
    }

    /**
     * Restituisce il dato relativo a l'indice dell'array $key, altrimenti restituisce false
     * @param String $key
     * @return Bool
     */
    public function getData($key) {
        if ($this->hasData($key)) {
            return $this->data[$key];
        }
        return false;
    }

    /**
     * Rimuove il dato configurato a l'indice $key
     * @param type $key
     */
    public function removeData($key) {
        if ($this->hasData($key)) {
            unset($this->data[$key]);
        }
    }

    /**
     * Modifica il dato a l'indice $key con il dato $data
     * @param String $key
     * @param Mixed $data
     */
    public function modifyData($key, $data) {
        if ($this->hasData($key)) {
            $this->data[$key] = $data;
        }
    }

    /**
     * Restituisce tutti i dati dell'array
     * @return type
     */
    public function getAllData() {
        return $this->data;
    }


}
