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
        $sent = false;
        if($insert != false){
            $pdf = $this->createPDF($post, $client);
            $from = $uname." <$uemail>";
            $to = $rname." <$remail>";

            $sent = $this->sendEmail($from, $to, "", $message, $pdf);
        }
        return $sent;
    }
    private function checkDir(){
        if(!is_dir(WP_CONTENT_DIR.'/envios')){
            return mkdir(WP_CONTENT_DIR.'/envios', 0777);
        }else{
            return true;
        }
    }

    private function createDir($path){
        if(is_dir($path)){
            return true;
        }else{
            return mkdir($path, 0777, true);
        }
    }

    private function createPDF($post, $client){
        $pdf = "";
        if($this->checkDir()){
            if($this->createDir(WP_CONTENT_DIR."/envios/$post/$client")){
                $e = get_post_custom($post);
                if (array_key_exists('wpcf-ficha-pdf', $e)){
                    $pdf = $this->urlToPathPDF($e['wpcf-ficha-pdf'][0]);
                }
            }
        }
        return $pdf;
    }

    private function urlToPathPDF($url){
        $url_parts = explode("wp-content/", $url);
        return WP_CONTENT_DIR.'/'.$url_parts[1];
    }

    private function sendEmail($from, $to, $subject, $message, $attachment){
        $attachments = array($attachment);
        $headers = 'From: '.$from."\r\n";
        return wp_mail($to, $subject, $message, $headers, $attachments);
    }
}
