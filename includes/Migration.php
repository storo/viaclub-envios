<?php

class Migration {

    function __construct(){
        global $wpdb;
        $this->db = $wpdb;
    }

    function create(){
        return $this->db->query("CREATE TABLE IF NOT EXISTS vce_events (
                                 ID INT NOT NULL,
                                 send_date DATETIME NULL,
                                 client_id INT NULL,
                                 user_name VARCHAR(255) NULL,
                                 user_email VARCHAR(255) NULL,
                                 recipient_name VARCHAR(255) NULL,
                                 recipient_email VARCHAR(255) NULL,
                                 post_id INT NULL,
                                 PRIMARY KEY (ID))");
    }

    function delete(){
        return $this->db->query("DROP TABLE IF EXISTS vce_events");
    }
}
