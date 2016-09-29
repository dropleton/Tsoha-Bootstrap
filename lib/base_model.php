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
        //Väliaikainen tapa saada $this->validators arrayksi
        $this->validators = array('validate_otsikko', 'validate_sisalto');
    }

    public function errors() {
        $errors = array();
//        $this->validators = array_merge($this->validators, $errors);
        foreach ($this->validators as $validator) {
            $errors[] = $this->{$validator}();
        }
        $errors = array_merge($errors);
        return $errors;
    }

    public function validate_string_length($string, $length) {
        $errors = array();
        if ($string == '' || $string == null) {
            $errors[] = 'Ei saa olla tyhjä!';
        }
        if (strlen($string) > $length) {
            $errors[] = 'Pituus ei saa olla yli ' . $length . ' merkkiä.';
        }
        return $errors;
    }

}
