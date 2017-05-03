<!DOCTYPE html>

<html>
<head>

</head>
<body>

<ul>
    <?php foreach ($words as $item) : ?>
        <li data-id=<?php echo '"'.$item['word_id'].'"'; ?>>
            <?php echo $item['en_word']; ?> - <?php echo $item['ru_word']; ?>
        </li>
    <?php endforeach; ?>
</ul>

</body>
</html>