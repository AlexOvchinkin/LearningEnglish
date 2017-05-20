<?php

include_once ROOT . '/views/Header.php';

?>

<section style="transform: translateY(100px)">

    <?php
    $password = '123';
    $hash = password_hash($password, PASSWORD_DEFAULT);
    var_dump($password);
    var_dump($hash);
    var_dump(password_verify($password, $hash));
    var_dump(password_verify('123', $hash));
    var_dump(password_verify('1234', $hash));
    var_dump(password_get_info($hash));


    include_once ROOT . '/views/Footer.php';
    ?>
</section>


