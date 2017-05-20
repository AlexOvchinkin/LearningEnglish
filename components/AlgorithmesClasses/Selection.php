<?php

class Selection extends Algorithm {

    function getParams() {
        return array(
            'enWord' => $this->data['en_word'],
            'checkWord' => $this->parseCheckWord($this->data['en_word']),
            'pickWord' => $this->parsePickWord($this->data['en_word']),
            'csrfToken' => CSRF::getSessionToken()
        );
    }

    function getTemplate() {
        return 'Selection.tmpl';
    }

    private function parseCheckWord($word) {
        $lettersArray = str_split(strtoupper($word));
        $resultArray = array();
        $counter = 0;

        foreach ($lettersArray as $item) {
            $newElement = array('num' => $counter, 'letter' => trim($item));
            $resultArray[] = $newElement;
            $counter++;
        }

        return $resultArray;
    }

    private function parsePickWord($word) {
        $lettersArray = str_split(strtoupper(str_replace(' ', '', $word)));
        $resultArray = array();
        $length = count($lettersArray) - 1;

        for ($i = 0; $i < $length; $i++) {
            $resultArray[] = array_splice($lettersArray, rand(0, count($lettersArray) - 1), 1)[0];
        }

        $resultArray[] = $lettersArray[0];

        return $resultArray;
    }
}
























