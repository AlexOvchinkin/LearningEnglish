<?php
    $otherPage = true;
    include_once ROOT . '/views/Header.php';
?>

<section class="not-found">
    <h2 class="not-found__header"><?php echo $header; ?></h2>
    <p class="not-found__text"><?php echo $text; ?></p>
    <a class="not-found__link" href="/">Вы можете перейти на главную страницу</a>
</section>

<?php include_once ROOT . '/views/Footer.php'; ?>

