<?php ob_start(); ?>

<h2 class="text-center">Administration</h2>
<div class="input-group my-1 justify-content-end" style="margin-bottom: 0 !important;">
    <div>
        <a href="./index.php?action=list_chambre" class="btn btn-info">CHAMBRES</a>
    </div>
</div>


<?php
if(isset($supMsg)) { echo $supMsg; }

$contenu = ob_get_clean();
require_once('./views/gabarit.php');