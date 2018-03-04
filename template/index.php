<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <? if (!empty($styles)) : ?>
        <? foreach ($styles as $style) : ?>
            <link rel="stylesheet" type="text/css" href="<?= $style; ?>"/>
        <? endforeach; ?>
    <? endif; ?>

    <? if (!empty($scripts)) : ?>
        <? foreach ($scripts as $script) : ?>
            <script type="text/javascript" src="<?= $script ?>"></script>
        <? endforeach; ?>
    <? endif; ?>

    <title>List of twits</title>
</head>
<body>

<?php echo $form; ?>

<div id="results"></div>

<?php echo $content; ?>

</body>
</html>