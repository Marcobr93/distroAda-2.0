<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$queryResult = $pdo->query("SELECT image, id, name, ostype from distro");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Distro ADA</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/app.css">

    <!-- Bootstrap core CSS -->

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css
            </button>
            <a class="navbar-brand" href="#">Distro ADA</a>
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

    <h1>Most Popular Distros</h1>
   <table class="table table-stripped">
       <thead>
       <tr>
           <th>Image</th>
           <th>Name</th>
           <th>Os Type</th>
           <th>Information</th>
           <th>Update</th>
           <th>Delete</th>
       </tr>
       </thead>
       <tbody>
       <?php while ($row = $queryResult->fetch(PDO::FETCH_ASSOC)): ?>
           <tr>
               <td><img src="<?=$row['image']?>" alt="Logo de <?=$row['name']?>"></td>
               <td><?= $row['name']; ?></td>
               <td><?= $row['ostype']; ?></td>
               <td>
                   <form action="listinfo.php" method="post">
                       <input type="hidden" name="list" value="<?=$row['id']; ?>">
                       <button type="submit"><span class="glyphicon glyphicon-info-sign info"></span></button>
                   </form>
               </td>
               <td><a href="update.php?id=<?=$row['id']?>" class="glyphicon glyphicon-edit editar"></a></td>
               <td>
                   <form action="delete.php" method="post">
                       <input type="hidden" name="delete" value="<?=$row['id']; ?>">
                       <button type="submit"><span class="glyphicon glyphicon-trash borrar"></span></button>
                   </form>
               </td>
           </tr>
       <?php endwhile; ?>
       </tbody>
   </table>

</div><!-- /.container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

</body>
</html>
