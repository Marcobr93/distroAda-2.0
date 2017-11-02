<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';
include_once 'arrays.php';

$errors = array();
$errorP = false;

$name = "";
$ostype = "";
$origin =  "";
$basedon = [];
$architecture = [];
$desktop = [];
$category = [];
$status = "";
$version = "";
$web = "";
$forum = "";
$doc = "";
$description = "";
$error = "";
$image = "";

if(!empty($_POST) ){

    // Recibo los datos del formulario
    $name = htmlspecialchars(trim($_POST['name']));
    $ostype =  htmlspecialchars(trim($_POST['ostype']));
    $origin =   htmlspecialchars(trim($_POST['origin']));
    $basedon = $_POST['basedon'] ?? array();
    $architecture = $_POST['architecture'] ?? array();
    $desktop = $_POST['desktop'] ?? array();
    $category = $_POST['category'] ?? array();
    $status = htmlspecialchars(trim( $_POST['status']));
    $version =  htmlspecialchars(trim($_POST['version']));
    $web =  htmlspecialchars(trim($_POST['web']));
    $forum =  htmlspecialchars(trim($_POST['forum']));
    $doc =  htmlspecialchars(trim($_POST['doc']));
    $description =  htmlspecialchars(trim($_POST['description']));
    $error =  htmlspecialchars(trim($_POST['error']));
    $image =  htmlspecialchars(trim($_POST['image']));


    // Evaluar campos requeridos
    if ($name === ""){
        $errors['name']['required'] = "El campo nombre es requerido";
    }

    if ($ostype === ""){
        $errors['ostype']['required'] = "El campo ostype es requerido";
    }

    if (!isset($_POST['basedon'])){
        $errors['basedon']['required'] = "El campo basedon es requerido";
    }

    if (!isset($_POST['origin'])){
        $errors['origin']['required'] = "El campo origin es requerido";
    }

    if (!isset($_POST['architecture'])){
        $errors['architecture']['required'] = "El campo architecture es requerido";
    }

    if (!isset($_POST['desktop'])){
        $errors['desktop']['required'] = "El campo descktop es requerido";
    }

    if ($category == ""){
        $errors['category']['required'] = "El campo category es requerido";
    }

    if ($status === ""){
        $errors['status']['required'] = "El campo status es requerido";
    }

    if ($version === ""){
        $errors['version']['required'] = "El campo version es requerido";
    }

    if ($web === ""){
        $errors['web']['required'] = "El campo web es requerido";
    }

    if ($doc === ""){
        $errors['doc']['required'] = "El campo doc es requerido";
    }

    if ($forum === ""){
        $errors['forum']['required'] = "El campo forum es requerido";
    }

    if ($error === ""){
        $errors['error']['required'] = "El campo error es requerido";
    }

    if ($description === ""){
        $errors['description']['required'] = "El campo description es requerido";
    }

        if ( empty($errors) ) {
            $basedon = convierteCadena($basedon);
            $architecture = convierteCadena($architecture);
            $desktop = convierteCadena($desktop);
            $category = convierteCadena($category);


            $sql = "INSERT INTO distro (image, name, ostype, basedon, origin, architecture, desktop, category, status, version, web, doc, forum, error, description, create_at) VALUES (:image, :name, :ostype, :basedon, :origin, :architecture, :desktop, :category, :status, :version, :web, :doc, :forum, :error, :description, NOW())";
            $result = $pdo->prepare($sql);
            $result->execute([
                'image'        => $image,
                'name'         => $name,
                'ostype'       => $ostype,
                'basedon'      => $basedon,
                'origin'       => $origin,
                'architecture' => $architecture,
                'desktop'      => $desktop,
                'category'     => $category,
                'status'       => $status,
                'version'      => $version,
                'web'          => $web,
                'doc'          => $doc,
                'forum'        => $forum,
                'error'        => $error,
                'description'  => $description
            ]);

            // Mando la aplicación a la página de inicio
            header('Location: index.php');
        }else{
        $errorP = true;
        }
}

$errorP = !empty($errors)?true:false;


?>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Starter Template for Bootstrap</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
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
            <a class="navbar-brand" href="#">DistroADA</a>
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
    <h1>Add New Distro</h1>
    <form action="add.php" method="post">
        <div class="form-group<?php echo (isset($errors['name']['required'])?"has-error":""); ?>">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Distro Name" value="<?=$errorP?$name:""?>">
        </div>
        <?php if( isset($errors['name']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['name']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="text" class="form-control" id="image" name="image" placeholder="Distro Image URL" value="<?=$errorP?$image:""?>">
        </div>

        <div class="form-group<?php echo (isset($errors['ostype']['required'])?"has-error":""); ?>">
            <label for="ostype">Os Type</label>
            <?=generarSelect($ostypeList, $ostype ?? "", "ostype", false)?>
        </div>
<?php if( isset($errors['ostype']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['ostype']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group<?php echo (isset($errors['basedon']['required'])?"has-error":""); ?>">
            <label for="basedon">Based On</label>
            <?=generarSelect($basedOnList, $basedon ?? "", "basedon", true);?>
        </div>
<?php if( isset($errors['basedon']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['basedon']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group<?php echo (isset($errors['origin']['required'])?"has-error":""); ?>">
            <label for="origin">Origin</label>
            <?=generarSelect($countries, $origin ?? "", "origin", false)?>
        </div>
<?php if( isset($errors['origin']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['origin']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group<?php echo (isset($errors['architecture']['required'])?"has-error":""); ?>">
            <label for="architecture">Architecture</label>
            <?=generarSelect($architectureList, $architecture ?? "", "architecture", true)?>
        </div>
<?php if( isset($errors['architecture']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['architecture']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group<?php echo (isset($errors['desktop']['required'])?"has-error":""); ?>">
            <label for="desktop">Desktop</label>
            <?=generarSelect($desktops, $desktop ?? "", "desktop", true)?>
        </div>
<?php if( isset($errors['desktop']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['desktop']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group<?php echo (isset($errors['category']['required'])?"has-error":""); ?>">
            <label for="category">Category</label>
            <?=generarSelect($categories, $category ?? "", "category", true)?>
        </div>
<?php if( isset($errors['category']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['category']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group<?php echo (isset($errors['status']['required'])?"has-error":""); ?>">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status">
                <option>Active</option>
                <option>Dormant</option>
                <option>Discontinued</option>
            </select>
        </div>
<?php if( isset($errors['status']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['status']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group">
            <label for="version">Version</label>
            <input type="text" class="form-control" id="version" name="version" placeholder="Distro Version" value="<?=$errorP?$version:""?>">
        </div>
<?php if( isset($errors['version']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['version']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group<?php echo (isset($errors['web']['required'])?"has-error":""); ?>">
            <label for="web">Web</label>
            <input type="text" class="form-control" id="web" name="web" placeholder="Distro Official Web" value="<?=$errorP?$web:""?>">
        </div>
<?php if( isset($errors['web']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['web']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group">
            <label for="doc">Doc</label>
            <input type="text" class="form-control" id="doc" name="doc" placeholder="Official Doc Website" value="<?=$errorP?$doc:""?>">
        </div>
<?php if( isset($errors['doc']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['doc']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group">
            <label for="forum">Forums</label>
            <input type="text" class="form-control" id="forum" name="forum" placeholder="Distro Official Forum Website" value="<?=$errorP?$forum:""?>">
        </div>
<?php if( isset($errors['forum']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['forum']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group">
            <label for="error">Error Tracker</label>
            <input type="text" class="form-control" id="error" name="error" placeholder="Distro Official Error Tracker Website" value="<?=$errorP?$error:""?>">
        </div>
<?php if( isset($errors['error']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['error']['required']?></strong>
    </div>
<?php endif; ?>
        <div class="form-group<?php echo (isset($errors['description']['required'])?"has-error":""); ?>">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="5" value="<?=$errorP?$description:""?>"></textarea>
        </div>
<?php if( isset($errors['description']) ): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <strong><?=$errors['description']['required']?></strong>
    </div>
<?php endif; ?>
    <div class="form-group">
         <input class="btn btn-success" type="submit" value="Add">
    </div>
    </form>
</div><!-- /.container -->
</body>
</html>