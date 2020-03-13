<?php ob_start(); ?>

<div class="posCenter col-md-6">
    <div class="card">
        <h3 class="card-header text-center">Ajouter un utilisateur</h3>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label for="role" class="text-center w-100">ROLE</label>
                    <select class="form-control" id="role" name="role">
                        <option value="<?= $role[1]->getRole() ?>" hidden><?= $role[1]->statut ?></option>

                        <?php foreach($role as $row) { ?>
                        <option value="<?= $row->getRole() ?>"><?= $row->statut ?></option>
                        <?php } ?>
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="login" class="text-center w-100">LOGIN</label>
                    <input type="text" class="form-control text-center" placeholder="Entrer votre login" id="login" name="login" value="<?= $login ?>" pattern="[A-Za-z][A-Za-z0-9]{3,9}" title="4 à 10 caractères de 'a' à 'Z' commençant par une lettre, chiffres ensuite si vous le souhaiter" required>
                </div>
                <div class="form-group">
                    <label for="pwd" class="text-center w-100">MOT DE PASSE</label>
                    <input type="password" class="form-control text-center" placeholder="Entrer votre mot de passe" id="pwd" name="pwd" required>
                </div>
                <div class="form-group">
                    <label for="pwd2" class="text-center w-100">CONFIRMER LE MOT DE PASSE</label>
                    <input type="password" class="form-control text-center" placeholder="Entrer votre mot de passe" id="pwd2" name="pwd2" >
                </div>

                <button type="submit" class="btn btn btn-primary btn-block" name="ajouter">Ajouter</button>
            </form>
        </div>
    </div>
    <?php if(isset($reponse)) { echo $reponse; } ?>
</div>

<?php

$contenu = ob_get_clean();
require_once('./views/gabarit.php');