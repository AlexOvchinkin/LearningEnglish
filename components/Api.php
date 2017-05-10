<?php

class Api {

    public function onWrongEnRuAnswer() {
        if (Safety::checkToken()) {
            echo 'DONE';
        } else {
            echo "ERROR - not equal (" . $_SESSION['CSRF-Token'] . " - " . $_COOKIE['CSRF-Token'];
        }
    }
}

