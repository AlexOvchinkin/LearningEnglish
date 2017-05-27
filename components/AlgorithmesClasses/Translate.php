<?php

class Translate extends Algorithm {

    protected function parseCheckWords($parseString) {
        $result = array();
        $arrayOfPairs = explode('-', $parseString);
        $counter = 1;

        foreach ($arrayOfPairs as $value) {
            $pair = explode('/', $value);
            $newElement = array("counter" => $counter++, "en" => $pair[0], "ru" => $pair[1]);
            $result[] = $newElement;
        }

        return $result;
    }

    public function getParams() {
        return array(
            'enWord' => $this->data['en_word'],
            'ruWord' => $this->data['ru_word'],
            'checkWords' => $this->parseCheckWords($this->data['check_words']),
            'csrfToken' => CSRF::getCSRFToken()
        );
    }

    public function getTemplate() {

    }
}

