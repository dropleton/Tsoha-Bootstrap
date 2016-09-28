<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
        $this->validators = array('validate_otsikko', 'validate_sisalto');
    }

    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();
        $validator_errors = array();
//        $this->validators = array('validate_otsikko', 'validate_sisalto');

        foreach ($this->validators as $validator) {
            // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
            $validator_errors[] = $this->{$validator}();
        }
        $errors = array_merge($errors, $validator_errors);
        return $errors;
    }

    public function validate_string_length($string, $length) {
        $errors = array();
        if ($string == '' || $string == null) {
            $errors[] = 'Ei saa olla tyhjä!';
        }
        if (strlen($string) > $length) {
            $errors[] = 'Pituus ei saa olla yli ' . $length . ' merkkiä.';
            return $errors;
        }
    }

}
