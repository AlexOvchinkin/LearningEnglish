<?php
    $vocabularyPage = true;
    include_once ROOT . '/views/Header.php';
?>

<main>
    <div class="vocabulary">
        <div class="vocabulary__panel">
            <div class="vocabulary__train-btn" id="train-btn">ТРЕНИРОВКА</div>
        </div>
        <ul class="vocabulary__list">

            <?php foreach ($words as $item) : ?>
                <li class="vocabulary__item" data-name="word-card">
                    <div class="vocabulary__text">
                        <p class="vocabulary__en-word">
                            <?php echo $item['en_word']; ?>
                        </p>
                        <p class="vocabulary__ru-word">
                            <?php echo $item['ru_word']; ?>
                        </p>
                    </div>
                    <div class="vocabulary__sound  vocabulary__img"></div>
                    <img class="vocabulary__trash  vocabulary__img" src="../src/image/trash.png">
                </li>
            <?php endforeach; ?>

        </ul>
    </div>
</main>

<script src="../src/js/Vocabulary.js?<?php echo time(); ?>"></script>
<?php include_once ROOT . '/views/Footer.php'; ?>
