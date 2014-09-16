<?php

require_once('classes/ListTableVCE.php');

$listTable = new ListTableVCE();
$listTable->prepare_items();

?>

<div class="wrap">
    <div id="icon-users" class="icon32"><br/></div>
    <h2>Lista de Env&iacute;os</h2>
    <form id="movies-filter" method="get">
        <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />
        <?php $listTable->display() ?>
    </form>

</div>
