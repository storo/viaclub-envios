<?php

class FormVCE {
    private $inputUserName;
    private $inputUserEmail;
    private $inputReceiveName;
    private $inputReceiveEmail;
    private $inputMessage;
    private $inputPost;
    private $button;
    private $form;
    private $post;

    function __construct($post){
        $this->post = $post;
        $this->inputUserName = '<input type="text" id="vce-name-user-'.$post.'" value="" />';
        $this->inputUserEmail = '<input type="text" id="vce-email-user-'.$post.'" value="" />';
        $this->inputReceiveName = '<input type="text" id="vce-name-destinatario-'.$post.'" value="" />';
        $this->inputReceiveEmail = '<input type="text" id="vce-email-destinatario-'.$post.'" value="" />';
        $this->inputMessage = '<textarea id="vce-msg-'.$post.'"></textarea>';
        $this->inputPost = '<input type="hidden" id="vce-postid-'.$post.'" value="'. $post .'" />';
        $this->button = '<button id="vce-send-button-'.$post.'">Env&iacute;ar</button>';

        $this->form = '<form id="vce-send-form-'.$post.'">';
        $this->form .= '<div id="vce-notify-'.$post.'"></div>';
        $this->form .= '<label>Nombre usuario</label> '.$this->inputUserName;
        $this->form .= '<label>Email usuario</label> '.$this->inputUserEmail;
        $this->form .= '<label>Nombre destinarario</label> '.$this->inputReceiveName;
        $this->form .= '<label>Email destinarario</label> '.$this->inputReceiveEmail;
        $this->form .= '<label>Mensaje</label> '.$this->inputMessage;
        $this->form .= $this->inputPost;
        $this->form .= $this->button;
        $this->form .= '</form>';

        add_action('wp_footer', array($this, 'vce_javascript'));
    }

    function get(){
        return $this->form;
    }

    function vce_javascript() { ?>
        <script type="text/javascript" >
            jQuery(document).ready(function($) {
                var userName<?php echo '_'.$this->post ?> = $('#vce-name-user<?php echo '-'.$this->post ?>');
                var userEmail<?php echo '_'.$this->post ?> = $('#vce-email-user<?php echo '-'.$this->post ?>');
                var receiveName<?php echo '_'.$this->post ?> = $('#vce-name-destinatario<?php echo '-'.$this->post ?>');
                var receiveEmail<?php echo '_'.$this->post ?> = $('#vce-email-destinatario<?php echo '-'.$this->post ?>');
                var message<?php echo '_'.$this->post ?> = $('#vce-msg<?php echo '-'.$this->post ?>');
                var postID<?php echo '_'.$this->post ?> = $('#vce-postid<?php echo '-'.$this->post ?>');
                var ErrorMsg = "";
                $('#vce-send-button<?php echo '-'.$this->post ?>').click(function(){
                    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                    if(formValidate()){
                        var data = {
                            'action': 'vce_send',
                            'post_id': postID<?php echo '_'.$this->post ?>.val(),
                            'user_name': userName<?php echo '_'.$this->post ?>.val(),
                            'user_email': userEmail<?php echo '_'.$this->post ?>.val(),
                            'receive_name': receiveName<?php echo '_'.$this->post ?>.val(),
                            'receive_email': receiveEmail<?php echo '_'.$this->post ?>.val(),
                            'message': message<?php echo '_'.$this->post ?>.val()
                        };

                        $.post(ajaxurl, data, function(response) {
                            if(response == true){
                                $('#vce-notify<?php echo '-'.$this->post ?>').append('<p class="success">El mensaje ha sido enviado correctamente</p>');
                                cleanForm();
                            }else{
                                $('#vce-notify<?php echo '-'.$this->post ?>').append('<p class="error">No ha sido posible enviar el mensaje.</p>');
                            }
                        });
                    }else{
                        $('#vce-notify<?php echo '-'.$this->post ?>').append('<ul class="error">'+ErrorMsg+'<ul>');
                    }
                    return false;
                });

                function formValidate(){
                    cleanError();
                    if(userName<?php echo '_'.$this->post ?>.val().length == 0){
                        ErrorMsg += "<li>Nombre Usuario Requerido</li>";
                        userName<?php echo '_'.$this->post ?>.addClass("error");
                    }
                    if(userEmail<?php echo '_'.$this->post ?>.val().length == 0 || !IsEmail(userEmail<?php echo '_'.$this->post ?>.val())){
                        ErrorMsg += "<li>Email Usuario Requerido</li>";
                        userEmail<?php echo '_'.$this->post ?>.addClass("error");
                    }
                    if(receiveName<?php echo '_'.$this->post ?>.val().length == 0){
                        ErrorMsg += "<li>Nombre Destinatario Requerido</li>";
                        receiveName<?php echo '_'.$this->post ?>.addClass("error");
                    }
                    if(receiveEmail<?php echo '_'.$this->post ?>.val().length == 0 || !IsEmail(receiveEmail<?php echo '_'.$this->post ?>.val())){
                        ErrorMsg += "<li>Email Destinatario Requerido</li>";
                        receiveEmail<?php echo '_'.$this->post ?>.addClass("error");
                    }
                    if(message<?php echo '_'.$this->post ?>.val().length == 0){
                        ErrorMsg += "<li>Mensaje Requerido</li>";
                        message<?php echo '_'.$this->post ?>.addClass("error");
                    }

                    if(ErrorMsg.length == 0){
                        return true;
                    }else{
                        return false;
                    }
                }

                function cleanForm(){
                    userName<?php echo '_'.$this->post ?>.val('');
                    userEmail<?php echo '_'.$this->post ?>.val('');
                    receiveName<?php echo '_'.$this->post ?>.val('');
                    receiveEmail<?php echo '_'.$this->post ?>.val('');
                    message<?php echo '_'.$this->post ?>.val('');
                }

                function cleanError(){
                    ErrorMsg = "";
                    $("input.error").removeClass("error");
                    $("textarea.error").removeClass("error");
                    $('#vce-notify<?php echo '-'.$this->post ?>').html('');
                }

                function IsEmail(email) {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if(!regex.test(email)) {
                        return false;
                    }else{
                        return true;
                    }
                }
            });
        </script>
    <?php
    }
}
