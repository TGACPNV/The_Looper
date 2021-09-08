<?php
require "View\Components\Header.php";
require "View\Components\Footer.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/View/Style/CSS/Global_style.css">
</head>
<body>
<!-- HEADER -->
<?= $header; ?>
<!-- /HEADER -->

<!-- Page Content -->
<div class="contentArea">
    <?= $contenu; ?>
</div>
<!-- /.container -->
<!-- FOOTER -->
<?= $footer; ?>
<!-- /FOOTER -->

</body>
</html>