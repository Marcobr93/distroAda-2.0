<?php
include_once 'config.php';
include_once 'connect_db.php';
include_once 'helpers.php';

$id = $_REQUEST['id'];
$errors = [];

if(!empty($_POST) ){
    // Recibo los datos del formulario
    $name = htmlspecialchars(trim($_POST['name']));
    $ostype = $_POST['ostype'];
    $origin =  $_POST['origin'];
    $basedon = $_POST['basedon'] ?? array();
    $architecture = $_POST['architecture'] ?? array();
    $desktop = $_POST['desktop'] ?? array();
    $category = $_POST['category'] ?? array();
    $status = $_POST['status'];
    $version = $_POST['version'];
    $web = $_POST['web'];
    $forum = $_POST['forum'];
    $doc = $_POST['doc'];
    $description = $_POST['description'];
    $error = $_POST['error'];
    $image = $_POST['image'];
    $id = $_POST['id'];
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

        $sql = "UPDATE distro SET image = :image, name = :name, ostype = :ostype, basedon = :basedon, origin = :origin, architecture = :architecture, desktop = :desktop, category = :category, status = :status, version = :version, web = :web, doc = :doc, forum = :forum, error = :error, description :description) WHERE id = :id";

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
            'description'  => $description,
            'id'           => $id
        ]);
         // dameDato($_POST);
        //  die();
        // Mando la aplicación a la página de inicio
        header('Location: index.php');
    }
}else {
    $distro = obtenerDistro($pdo, $id);
}
function obtenerDistro($pdo, $id){
    $sql = "SELECT * from distro where id = :id";
    $queryResult = $pdo->prepare($sql);
    $queryResult->execute([
        'id' => $id,
    ]);
    return $queryResult->fetch(PDO::FETCH_ASSOC);
}
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
    <h1>Update Distro</h1>
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?=$distro['id']?>">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?=$distro['name']?>">
        </div>
        <?php if( isset($errors['name']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['name']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="text" class="form-control" id="image" name="image" value="<?=$distro['image']?>">
        </div>

        <div class="form-group">
            <label for="ostype">Os Type</label>
            <select class="form-control" name="ostype" id="ostype" required value="<?=$distro['ostype']?>">
                <option value="Linux">Linux</option>
                <option value="BSD">BSD</option>
                <option value="Solaris">Solaris</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <?php if( isset($errors['ostype']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['ostype']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="basedon">Based On</label>
            <select class="form-control" name="basedon[]" id="basedon" multiple required value="<?=$distro['basedon']?>">
                <option selected value="All">All</option>
                <option value="Android">Android</option>
                <option value="Arch">Arch</option>
                <option value="CentOS">CentOS</option>
                <option value="CRUX">CRUX</option>
                <option value="Debian">Debian</option>
                <option value="Debian (Stable)">Debian (Stable)</option>
                <option value="Debian (Testing)">Debian (Testing)</option>
                <option value="Debian (Unstable)">Debian (Unstable)</option>
                <option value="Fedora">Fedora</option>
                <option value="FreeBSD">FreeBSD</option>
                <option value="Gentoo">Gentoo</option>
                <option value="Independent">Independent</option>
                <option value="KDE neon">KDE neon</option>
                <option value="KNOPPIX">KNOPPIX</option>
                <option value="LFS">LFS</option>
                <option value="Mageia">Mageia</option>
                <option value="Mandriva">Mandriva</option>
                <option value="Manjaro">Manjaro</option>
                <option value="OpenBSD">OpenBSD</option>
                <option value="openSUSE">openSUSE</option>
                <option value="PCLinuxOS">PCLinuxOS</option>
                <option value="Puppy">Puppy</option>
                <option value="Red Hat">Red Hat</option>
                <option value="rPath">rPath</option>
                <option value="sidux">sidux</option>
                <option value="Slackware">Slackware</option>
                <option value="SliTaz">SliTaz</option>
                <option value="Solaris">Solaris</option>
                <option value="Ubuntu">Ubuntu</option>
                <option value="Ubuntu (LTS)">Ubuntu (LTS)</option>
                <option value="Tiny Core">Tiny Core</option>
                <option value="Zenwalk">Zenwalk</option>
            </select>
        </div>
        <?php if( isset($errors['basedon']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['basedon']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="origin">Origin</label>
            <select class="form-control" name="origin" id="origin" required value="<?=$distro['origin']?>">
                <option selected value="All">All</option>
                <option value="Algeria">Algeria</option>
                <option value="Argentina">Argentina</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Belgium">Belgium</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                <option value="Brazil">Brazil</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Canada">Canada</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Cuba">Cuba</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="Germany">Germany</option>
                <option value="Greece">Greece</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="India">India</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Iran">Iran</option>
                <option value="Ireland">Ireland</option>
                <option value="Isle of Man">Isle of Man</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Japan">Japan</option>
                <option value="Jordan">Jordan</option>
                <option value="Latvia">Latvia</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Malta">Malta</option>
                <option value="Mexico">Mexico</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherlands">Netherlands</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Peru">Peru</option>
                <option value="Philippines">Philippines</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Réunion">Réunion</option>
                <option value="Romania">Romania</option>
                <option value="Russia">Russia</option>
                <option value="Serbia">Serbia</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="South Africa">South Africa</option>
                <option value="South Korea">South Korea</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Thailand">Thailand</option>
                <option value="Turkey">Turkey</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Emirates">United Arab Emirates</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="USA">USA</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Vietnam">Vietnam</option>
            </select>
        </div>
        <?php if( isset($errors['origin']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['origin']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="architecture">Architecture</label>
            <select class="form-control" name="architecture[]" id="architecture" multiple required value="<?=$distro['architecture']?>">
                <option selected value="All">All</option>
                <option value="acorn26">acorn26</option>
                <option value="acorn32">acorn32</option>
                <option value="alpha">alpha</option>
                <option value="amiga">amiga</option>
                <option value="arc">arc</option>
                <option value="arm">arm</option>
                <option value="armv5tel">armv5tel</option>
                <option value="arm64">arm64</option>
                <option value="armel">armel</option>
                <option value="armhf">armhf</option>
                <option value="atari">atari</option>
                <option value="cats">cats</option>
                <option value="cobalt">cobalt</option>
                <option value="dreamcast">dreamcast</option>
                <option value="emips">emips</option>
                <option value="evbarm">evbarm</option>
                <option value="evbmips">evbmips</option>
                <option value="evbppc">evbppc</option>
                <option value="evbsh3">evbsh3</option>
                <option value="ews4800mips">ews4800mips</option>
                <option value="hp300">hp300</option>
                <option value="hp700">hp700</option>
                <option value="hpcarm">hpcarm</option>
                <option value="hpcmips">hpcmips</option>
                <option value="hpcsh">hpcsh</option>
                <option value="hppa">hppa</option>
                <option value="i386">i386</option>
                <option value="i486">i486</option>
                <option value="i586">i586</option>
                <option value="i686">i686</option>
                <option value="ia64">ia64</option>
                <option value="ibmnws">ibmnws</option>
                <option value="ix86">ix86</option>
                <option value="luna68k">luna68k</option>
                <option value="m68010">m68010</option>
                <option value="m68k">m68k</option>
                <option value="mips">mips</option>
                <option value="mipsco">mipsco</option>
                <option value="mipsel">mipsel</option>
                <option value="mvme68k">mvme68k</option>
                <option value="mvmeppc">mvmeppc</option>
                <option value="news68k">news68k</option>
                <option value="newsmips">newsmips</option>
                <option value="ns32k">ns32k</option>
                <option value="ofppc">ofppc</option>
                <option value="pmax">pmax</option>
                <option value="powerpc">powerpc</option>
                <option value="ppc64">ppc64</option>
                <option value="ppc64el">ppc64el</option>
                <option value="prep">prep</option>
                <option value="ps2">ps2</option>
                <option value="ps3">ps3</option>
                <option value="s390">s390</option>
                <option value="s390x">s390x</option>
                <option value="sandpoint">sandpoint</option>
                <option value="sgimips">sgimips</option>
                <option value="sh3eb">sh3eb</option>
                <option value="sh3el">sh3el</option>
                <option value="sh5">sh5</option>
                <option value="shark">shark</option>
                <option value="sparc32">sparc32</option>
                <option value="sparc64">sparc64</option>
                <option value="sun2">sun2</option>
                <option value="sun3">sun3</option>
                <option value="vax">vax</option>
                <option value="x68k">x68k</option>
                <option value="x86_64">x86_64</option>
                <option value="xbox">xbox</option>
                <option value="zaurus">zaurus</option>
            </select>
        </div>
        <?php if( isset($errors['architecture']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['architecture']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="desktop">Desktop</label>
            <select class="form-control" name="desktop[]" id="desktop"  multiple required value="<?=$distro['desktop']?>">
                <option selected value="All">All</option>
                <option value="No desktop">No desktop</option>
                <option value="AfterStep">AfterStep</option>
                <option value="Android">Android</option>
                <option value="Awesome">Awesome</option>
                <option value="Blackbox">Blackbox</option>
                <option value="bspwm">bspwm</option>
                <option value="Budgie">Budgie</option>
                <option value="Cinnamon">Cinnamon</option>
                <option value="Consort">Consort</option>
                <option value="Deepin">Deepin</option>
                <option value="dwm">dwm</option>
                <option value="Enlightenment">Enlightenment</option>
                <option value="Equinox">Equinox</option>
                <option value="Firefox">Firefox</option>
                <option value="Fluxbox">Fluxbox</option>
                <option value="flwm">flwm</option>
                <option value="FVWM">FVWM</option>
                <option value="GNOME">GNOME</option>
                <option value="Hackedbox">Hackedbox</option>
                <option value="i3">i3</option>
                <option value="IceWM">IceWM</option>
                <option value="ion">ion</option>
                <option value="JWM">JWM</option>
                <option value="KDE">KDE</option>
                <option value="KDE Plasma">KDE Plasma</option>
                <option value="Kodi (XBMC)">Kodi (XBMC)</option>
                <option value="Lesstif">Lesstif</option>
                <option value="Lumina">Lumina</option>
                <option value="LXDE">LXDE</option>
                <option value="LXQt">LXQt</option>
                <option value="MATE">MATE</option>
                <option value="Maynard">Maynard</option>
                <option value="Metacity">Metacity</option>
                <option value="Mezzo">Mezzo</option>
                <option value="Moblin">Moblin</option>
                <option value="Openbox">Openbox</option>
                <option value="Pantheon">Pantheon</option>
                <option value="Pearl">Pearl</option>
                <option value="pekwm">pekwm</option>
                <option value="Ratpoison">Ratpoison</option>
                <option value="Razor-qt">Razor-qt</option>
                <option value="SLWM">SLWM</option>
                <option value="Sugar">Sugar</option>
                <option value="Trinity">Trinity</option>
                <option value="TWM">TWM</option>
                <option value="Unity">Unity</option>
                <option value="WebUI">WebUI</option>
                <option value="WMaker">WMaker</option>
                <option value="WMFS">WMFS</option>
                <option value="WMI">WMI</option>
                <option value="Xfce">Xfce</option>
            </select>
        </div>
        <?php if( isset($errors['desktop']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['desktop']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="category">Category</label>
            <select class="form-control" name="category[]" id="category" multiple required value="<?=$distro['category']?>">
                <option selected value="All">All</option>
                <option value="Beginners">Beginners</option>
                <option value="Clusters">Clusters</option>
                <option value="Data Rescue">Data Rescue</option>
                <option value="Desktop">Desktop</option>
                <option value="Disk Management">Disk Management</option>
                <option value="Docker">Docker</option>
                <option value="Education">Education</option>
                <option value="Firewall">Firewall</option>
                <option value="Forensics">Forensics</option>
                <option value="Free Software">Free Software</option>
                <option value="Gaming">Gaming</option>
                <option value="High Performance Computing">High Performance Computing</option>
                <option value="Live Medium">Live Medium</option>
                <option value="Multimedia">Multimedia</option>
                <option value="MythTV">MythTV</option>
                <option value="NAS">NAS</option>
                <option value="Netbooks">Netbooks</option>
                <option value="Old Computers">Old Computers</option>
                <option value="Privacy">Privacy</option>
                <option value="Raspberry Pi">Raspberry Pi</option>
                <option value="Scientific">Scientific</option>
                <option value="Server">Server</option>
                <option value="Security">Security</option>
                <option value="Source-based">Source-based</option>
                <option value="Specialist">Specialist</option>
                <option value="Telephony">Telephony</option>
                <option value="Thin Client">Thin Client</option>
            </select>
        </div>
        <?php if( isset($errors['category']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['category']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" name="status" id="status" value="<?=$distro['status']?>">
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
            <input type="text" class="form-control" id="version" name="version" value="<?=$distro['version']?>">
        </div>
        <?php if( isset($errors['version']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['version']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="web">Web</label>
            <input type="text" class="form-control" id="web" name="web" value="<?=$distro['web']?>">
        </div>
        <?php if( isset($errors['web']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['web']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="doc">Doc</label>
            <input type="text" class="form-control" id="doc" name="doc" value="<?=$distro['doc']?>">
        </div>
        <?php if( isset($errors['doc']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['doc']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="forum">Forum</label>
            <input type="text" class="form-control" id="forum" name="forum" value="<?=$distro['forum']?>">
        </div>
        <?php if( isset($errors['forum']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['forum']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="error">Error Tracker</label>
            <input type="text" class="form-control" id="error" name="error" value="<?=$distro['error']?>">
        </div>
        <?php if( isset($errors['error']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['error']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" value="<?=$distro['description']?>" rows="5"></textarea>
        </div>
        <?php if( isset($errors['description']) ): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><?=$errors['description']['required']?></strong>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <input class="btn btn-success" type="submit" value="Update">
        </div>
    </form>
</div><!-- /.container -->
</body>
</html>