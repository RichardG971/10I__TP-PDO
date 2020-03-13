<?php ob_start(); ?>

<div class="posCenter col-md-6">
    <div class="card">
        <h3 class="card-header text-center">Page d'authentification</h3>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="login" class="text-center w-100">LOGIN</label>
                    <input type="text" class="form-control text-center" placeholder="Entrer votre login" id="login" name="login">
                </div>
                <div class="form-group">
                    <label for="pwd" class="text-center w-100">MOT DE PASSE</label>
                    <input type="password" class="form-control text-center" placeholder="Entrer votre mot de passe" id="pwd" name="pwd">
                </div>

                <button type="submit" class="btn btn btn-primary btn-block" name="soumettre">Connexion</button>
            </form>
        </div>
    </div>
    <?= $erreur ?>
</div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');