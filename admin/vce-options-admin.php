<?php
if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}

require_once('classes/SettingVCE.php');

$setting = new SettingsVCE();
$message = $setting->getMessageValues();

?>
<div class="wrap">
    <h2></h2>
    <form method="POST" action="">
        <h3>Configuraci&oacute;n Frontend</h3>
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
        <button  id="submit" class="button button-primary">Guardar Configuraci&oacute;n </button>
    </form>
</div>
