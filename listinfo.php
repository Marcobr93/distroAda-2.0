<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$id = $_POST['list'];

$queryResult = $pdo->prepare("SELECT * from distro where id = :id");

$queryResult->execute([
    'id' => $id,
]);

$row = $queryResult->fetch(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DistroADA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Distro ADA</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Inicio</a></li>
                <li><a href="add.php">Añadir Distro</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<div class="container">
    <h1>Informacion de la distribucion</h1>

    <ul>
        <li><h3>Image: <?=$row['image']; ?></h3></li>
        <li><h3>Name: <?=$row['name']; ?></h3></li>
        <li><h3>Os type: <?=$row['ostype']; ?></h3></li>
        <li><h3>Based on: <?=$row['basedon']; ?></h3></li>
        <li><h3>Origin: <?=$row['origin']; ?></h3></li>
        <li><h3>Architecture: <?=$row['architecture']; ?></h3></li>
        <li><h3>Desktop: <?=$row['desktop']; ?></h3></li>
        <li><h3>Category: <?=$row['category']; ?></h3></li>
        <li><h3>Status: <?=$row['status']; ?></h3></li>
        <li><h3>Version: <?=$row['version']; ?></h3></li>
        <li><h3>Web: <?=$row['web']; ?></h3></li>
        <li><h3>Doc: <?=$row['doc']; ?></h3></li>
        <li><h3>Forum: <?=$row['forum']; ?></h3></li>
        <li><h3>Error tracker: <?=$row['error']; ?></h3></li>
        <li><h3>Description: <?=$row['description']; ?></h3></li>
    </ul>
</div>
</body>
</html>
