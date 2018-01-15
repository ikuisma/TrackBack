<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
        // Käydään assosiaatiolistan avaimet läpi
        foreach($attributes as $attribute => $value){
            // Jos avaimen niminen attribuutti on olemassa...
            if(property_exists($this, $attribute)){
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors(){
        return $this->validateErrors($this->validators);
    }

    public function validateErrors($validators) {
        $errors = array();
        foreach($validators as $validator){
            $errors = array_merge($errors, $this->{$validator}());
        }
        return $errors;
    }


    public static function succeedsLength($string, $minLength) {
        return (strlen($string) < $minLength);
    }

    public static function exceedsLength($string, $maxLength) {
        return (strlen($string) > $maxLength);
    }

    public static function emptyString($string){
        return strlen($string) == 0;
    }

  }
