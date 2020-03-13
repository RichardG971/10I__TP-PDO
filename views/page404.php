<?php ob_start(); ?>

<div class="posCenter col-md-6">
    <div class="card">
        <h3 class="card-header text-center">Page 404</h3>
        <div class="card-body text-center" style="font-size: 1.5rem;">
            <div class="form-group">
                <?= $msgerreur ?>
            </div>

            <div>
                <a href="./index.php" class="btn btn-info" style="font-size: 1.5rem;">Retour à la page d'accueil</a>
            </div>
        </div>
    </div>
</div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');