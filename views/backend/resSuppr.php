<?php ob_start(); ?>

<h2 class="text-center">Administration</h2>

<?php if($_SESSION['role'] === 1 || (isset($resSuppr) && $resSuppr)) { ?>
<div class="posCenter"><h2 class="text-center">Suppression réussie</h2>

<?php } else { ?>

<div class="posCenter">
    <h3 class="text-center bg-warning rounded px-3">
        Vous êtes autoriser à supprimer les réservations dont les clients ont fini leur séjour.
        <br>Pour plus d'options, contacter un administrateur.
    <h3>
    <h2 class="text-center">Echec de la suppression...</h2>

    <?php } ?>

    <div class="text-right w-100">
        <a href="./index.php?action=admin" class="btn btn-info col-sm-3 my-1">RETOUR</a>
    </div>
</div>

<?php
$contenu = ob_get_clean();
require_once('./views/gabarit.php');