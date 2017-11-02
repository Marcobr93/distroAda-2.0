<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$id = $_REQUEST['delete'];

$sql = "DELETE FROM `distro` WHERE `id` = :valor LIMIT 1";

$result = $pdo->prepare($sql);

$result->execute([
    'valor' => $id
]);


header('Location: index.php');