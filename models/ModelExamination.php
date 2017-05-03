<?php

class ModelExamination {

    private $user_id;

    public function __construct($user_id) {
        $this->user_id = $user_id;
    }

    public function getWordsList() {
        if (!empty($this->user_id)) {
            return DB::getAllWords($this->user_id);
        }

        return array();
    }
}