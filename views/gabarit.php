<!DOCTYPE html>
<html lang="fr">
<head>
    <title>PDO_TP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href='./assets/css/PDO_TP--styles.css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body class="container">
    <header>
        <nav id="navHead" class="navbar navbar-expand-sm bg-primary navbar-dark fixed-top mb-5 justify-content-between">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="./index.php">ACCUEIL</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <!-- Dropdown -->

                <?php if(isset($_SESSION['login'])) { ?>
                
                <li class="nav-item active dropdown ml-auto ">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown"><?= $_SESSION['login'] ?><span id="role" class="d-none"><?= $_SESSION['role'] ?></span></a>
                    <div class="dropdown-menu dropdown-menu-right">

                        <?php if($_SESSION['role'] === 1) { ?>
                        <a class="dropdown-item" href="./index.php?action=add_user">Ajouter un utilisateur</a>
                        <?php } ?>
                        
                        <a class="dropdown-item" href="./index.php?action=admin">Gestion des réservations</a>
                        <a class="dropdown-item" href="./index.php?action=list_chambre">Gestion des chambres</a>
                        <a class="dropdown-item" href="./index.php?action=logout">Déconnexion</a>
                    </div>
                </li>

                <?php } ?>
                
            </ul>
        </nav>
    </header>
    
    <main>
    
    <?php if(isset($contenu)) { echo $contenu; } else { echo 'Erreur de l\'ajout du contenu'; } ?>

    </main>
    
    <footer>
        <nav id="navFoot" class="navbar-expand-sm bg-primary navbar-dark text-white fixed-bottom">
            <div class="row align-items-center">

                <div class="offset-1 col-4">
                    <h3>Liens utiles</h3>
                    <p class="col"><a class="text-white" href="./index.php">ACCUEIL</a> </p>
                    <p class="col">Lien 2</p>
                    <p class="col">Mentions légales</p>
                </div>

                <div class="col-5">
                    <form action="">
                        <input type="text" name="newsletters" id="" placeholder="Incrivez vous aux newsletters">
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
                
                <div class="col-2">
                    <div>copyright &copy; 2020</div>
                </div>
            </div>
        </nav>
    </footer>

    <script src="./assets/js/PDO_TP--script.js"></script>
</body>
</html>