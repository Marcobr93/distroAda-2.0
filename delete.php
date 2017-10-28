<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$id = $_POST['delete'];

print_r($id);

$sql = "DELETE FROM `distro` WHERE `id` = :valor LIMIT 1";

print_r($sql);

$result = $pdo->prepare($sql);

$result->execute([
    'valor' => $id
]);


header('Location: index.php');