<?php

class Installer {
    private $db;
    function __construct(){
        global $wpdb;
        $this->db = $wpdb;
    }

    function install(){

        $this->createDB();
        $this->createOptions();
    }

    function uninstall(){
        $this->deleteDB();
        $this->deleteOptions();
    }

    private function createOptions(){
        update_option('vce_valid_post_type', '{}');
        update_option('vce_mail_from', 'contacto@viaclub.cl');
        update_option('vce_mail_bbc', '');
        update_option('vce_mail_subject', '');
        update_option('vce_mail_text_message','');
        update_option('vce_mail_html_message', '');
    }

    private function deleteOptions(){
        delete_option('vce_valid_post_type');
        delete_option('vce_mail_from');
        delete_option('vce_mail_bbc');
        delete_option('vce_mail_subject');
        delete_option('vce_mail_text_message');
        delete_option('vce_mail_html_message');
    }

    private function createDB(){
        return $this->db->query("CREATE TABLE IF NOT EXISTS vce_events (
                                 ID INT NOT NULL AUTO_INCREMENT,
                                 send_date DATETIME NULL,
                                 client_id INT NULL,
                                 user_name VARCHAR(255) NULL,
                                 user_email VARCHAR(255) NULL,
                                 recipient_name VARCHAR(255) NULL,
                                 recipient_email VARCHAR(255) NULL,
                                 message TEXT NULL,
                                 post_id INT NULL,
                                 PRIMARY KEY (ID))");
    }

    private function deleteDB(){
        return $this->db->query("DROP TABLE IF EXISTS vce_events");
    }
}
