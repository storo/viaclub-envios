<?php
if (!isset($_POST['download'])) {
?>
    <div class="wrap">
        <div id="icon-users" class="icon32"><br/></div>
        <h2>Exportar Env&iacute;os</h2>

        <form method="post" id="export-filters">
            <div style="background:#ECECEC;border:1px solid #CCC;padding:0 10px;margin-top:5px;border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;">
                <p>La exportaci&oacute;n de Env&iacute;os se realiza en formato Excel (xls).</p>
            </div>
            <p class="submit">
                <?php wp_nonce_field('ie-export'); ?>
                <input type="hidden" name="download" value="true" />
                <button  id="submit" class="button button-primary">Descargar el archivo de exportaci&oacute;n </button>
            </p>
        </form>
    </div>
<?php
}
elseif (check_admin_referer('ie-export')) {
    require_once('classes/ExportXLS.php');
    $xls = new ExportXLS();
    $xls->export();
}
?>