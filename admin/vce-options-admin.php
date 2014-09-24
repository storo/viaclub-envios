<?php
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

require_once('classes/SettingVCE.php');

$setting = new SettingsVCE();
$show_message = array();
if(isset($_POST['save-config'])){

    $show_message[] = $setting->savePage();
    $show_message[] = $setting->savePostType();
    $show_message[] = $setting->saveMessage();
    $setting->reload();
}
$message = $setting->getMessageValues();

?>
<div class="wrap">
    <?php
        if(in_array(false, $show_message)){
    ?>
    <div id="message" class="updated"><p>Configuraci&oacute;n <strong>correctamente salvada</strong>.</p></div>
    <?php
        }
    ?>
    <form method="POST" action="">
        <h3>Configuraci&oacute;n Frontend</h3>
        <p>Es necesario seleccionar un <strong>page</strong> donde se debe agregar el formulario:</p>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="num_elements">P&aacute;gina Formulario de Env&iacute;o: </label>
                </th>
                <td>
                    <?php echo $setting->getPages(); ?>
                </td>
            </tr>
        </table>
        <h3>Post types</h3>
        <p>Seleccionar <strong>Post types</strong> que est&eacute;n habilitados para el Env&iacute;o.</p>
        <ul>
            <?php echo $setting->getPostTypeWithFormatHtml('li');?>
        </ul>
        <h3>Configuraci&oacute;n Email</h3>
        <p>Formato para el env&iacute;o de correo</p>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    <label for="num_elements">FROM (email):  </label>
                </th>
                <td>
                   <input type="text" value="<?php echo $message['vce_mail_from'];?>" name="message[vce_mail_from]" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="num_elements">BCC (emails):  </label>
                </th>
                <td>
                    <input type="text" value="<?php echo $message['vce_mail_bbc'];?>" name="message[vce_mail_bbc]" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="num_elements">Asunto Mensaje:  </label>
                </th>
                <td>
                    <input type="text" value="<?php echo $message['vce_mail_subject'];?>" name="message[vce_mail_subject]" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="num_elements">Texto Mensaje: </label>
                </th>
                <td>
                    <textarea style="height:160px; width: 400px;" name="message[vce_mail_text_message]"><?php echo $message['vce_mail_text_message'];?></textarea>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label for="num_elements">HTML Mensaje: </label>
                </th>
                <td>
                    <textarea style="height:160px; width: 400px;" name="message[vce_mail_html_message]"><?php echo $message['vce_mail_html_message'];?></textarea>
                </td>
            </tr>
        </table>
        <input type="hidden" name="save-config" value="true" />
        <button  id="submit" class="button button-primary">Guardar Configuraci&oacute;n </button>
    </form>
</div>
