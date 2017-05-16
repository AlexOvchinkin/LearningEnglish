<?php

abstract class Algorithm {

    protected $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public static function getAlgorithmesArray() {
        return array(
            'TranslateEnglishRussian',
            'TranslateRussianEnglish',
            'Selection'
        );
    }

    abstract function getParams();

    abstract function getTemplate();
}

