<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" href="../src/css/block-header.css?<?php echo time(); ?>">

    <?php if (isset($vocabularyPage)) : ?>
        <link rel="stylesheet" href="../src/css/vocabulary.css?<?php echo time(); ?>">
    <?php endif; ?>

    <?php if (isset($trainingPage)) : ?>
        <link rel="stylesheet" href="../src/css/block-train.css?<?php echo time(); ?>">
    <?php endif; ?>

    <?php if (isset($otherPage)) : ?>
        <link rel="stylesheet" href="../src/css/other-page.css?<?php echo time(); ?>">
    <?php endif; ?>

    <?php if (isset($trainingData)) : ?>
        <link rel="stylesheet" href="../src/css/<?php echo $trainingData['template'].'.css?'.time(); ?>">
    <?php endif; ?>
</head>
<body>
<header class="block-header">
    <div class="block-header__left-part">
        <a class="block-header__logo-link" href="/">
            <img class="block-header__logo-picture" src="../src/image/rocket.png">
        </a>
        <a class="block-header__logo-text-link" href="/">Rocket ENGLISH</a>
        <a class="block-header__link  block-header__link-lessons" href="#">
            УРОКИ
        </a>
        <a class="block-header__link  block-header__link-dict" href="/vocabulary">
            СЛОВАРЬ
        </a>
    </div>
    <a class="block-header__link  block-header__right-part" href="#">
        ВОЙТИ
    </a>
</header>


