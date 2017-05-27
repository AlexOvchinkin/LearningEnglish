<!DOCTYPE html>

<html>
<head>
    <link rel="stylesheet" href="../src/css/block-header.css?<?php echo time(); ?>">

    <?php if (isset($trainingData)) : ?>
        <link rel="stylesheet" href="../src/css/<?php echo $trainingData['template'] . '.css?' . time(); ?>">
    <?php endif; ?>

    <?php if (isset($page)) : ?>

        <?php if ($page == PAGE_VOCABULARY) : ?>
            <link rel="stylesheet" href="../src/css/vocabulary.css?<?php echo time(); ?>">
        <?php endif; ?>

        <?php if ($page == PAGE_TRAINING) : ?>
            <link rel="stylesheet" href="../src/css/block-train.css?<?php echo time(); ?>">
        <?php endif; ?>

        <?php if ($page == PAGE_OTHER) : ?>
            <link rel="stylesheet" href="../src/css/other-page.css?<?php echo time(); ?>">
        <?php endif; ?>

        <?php if ($page == PAGE_REGISTRATION) : ?>
            <link rel="stylesheet" href="../src/css/registration.css?<?php echo time(); ?>">
        <?php endif; ?>

        <?php if ($page == PAGE_AUTHORISATION) : ?>
            <link rel="stylesheet" href="../src/css/authorisation.css?<?php echo time(); ?>">
        <?php endif; ?>

    <?php endif; ?>

</head>
<body>
<header class="block-header">
    <div class="block-header__left-part">
        <a class="block-header__logo-link" href="/">
            <img class="block-header__logo-picture" src="../src/image/rocket.png">
        </a>
        <a class="block-header__logo-text-link" href="/">Rocket ENGLISH</a>

        <?php if (isset($page)) : ?>
            <?php if ($page != PAGE_REGISTRATION && $page != PAGE_AUTHORISATION) : ?>
                <a class="block-header__link  block-header__link-lessons" href="#">
                    УРОКИ
                </a>
                <a class="block-header__link  block-header__link-dict" href="/vocabulary">
                    СЛОВАРЬ
                </a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="block-header__right-part">
        <?php if (User::isAuthorized()) : ?>
            <a class="block-header__link" href="#">
                <?php if (isset($_SESSION['user-name'])) {
                    echo $_SESSION['user-name'];
                } ?>
            </a>
        <?php else : ?>
            <a class="block-header__link" href="#">
                ВХОД
            </a>
            <a class="block-header__link" href="/registration">
                РЕГИСТРАЦИЯ
            </a>
        <?php endif; ?>
    </div>
</header>


