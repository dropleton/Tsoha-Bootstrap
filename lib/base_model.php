<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        $errors = array();
        foreach ($this->validators as $validator) {
//            $errors[] = $this->{$validator}();
            $errors = array_merge($errors, $this->{$validator}());
        }

        return $errors;
    }

    public function validate_string_length($string, $length, $validoitava) {
        $errors = array();
        if ($string == '' || $string == null) {
            $errors[] = $validoitava . 'ei saa olla tyhjä!';
        }
        if (strlen($string) > $length) {
            $errors[] = 'Kentän ' . $validoitava . 'pituus ei saa olla yli ' . $length . ' merkkiä.';
        }
        return $errors;
    }

}
