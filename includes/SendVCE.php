<?php

class SendVCE {

    function __construct(){
        global $wpdb;
        $this->db = $wpdb;
        // salvar envio
        // crear correo
        // enviar correo
    }

    function save($post, $uname, $uemail, $rname, $remail, $message, $client){
        $now = new DateTime(); //string value use: %s
        $datesent = $now->format('Y-m-d H:i:s');
        $insert = $this->db->insert("vce_events", array(
            "send_date" => $datesent,
            "client_id" => $client,
            "user_name" => $uname,
            "user_email" => $uemail,
            "recipient_name" => $rname,
            "recipient_email" => $remail,
            "message" => $message,
            "post_id" => $post
        ));
        $this->db->insert_id;


        return ($insert == false)? false : true;
    }

    private function createPDF(){

    }

    private function sendEmail(){

        $attachments = array(WP_CONTENT_DIR . '/uploads/file_to_attach.zip');
        $headers = 'From: My Name <myname@mydomain.com>' . "\r\n";
        wp_mail('test@test.com', 'subject', 'message', $headers, $attachments);
        return true;
    }
}
