<?php
class ExportXLS {
    private $output;
    private $fileName;
    private $db;
    private $file;
    function __construct(){
        global $wpdb;
        $this->output = "";
        $this->file = "envios";
        $this->fileName = $this->file."_".$this->now();
        $this->db = $wpdb;
        add_action('export_vce', array( $this, 'export' ) );
    }

    private function setTableHeaders(){
        $this->output .= "id,fecha de Envío,Cliente,Nombre Usuario,Email Usuario,Nombre Destinatario,Email Destinatario,Programa\n";
    }

    private function setTableBody(){
        $values = $this->db->get_results("SELECT e.ID,
                                                  e.send_date,
                                                  u.display_name AS client,
                                                  e.user_name AS user_name,
                                                  e.user_email AS user_email,
                                                  e.recipient_name AS recipient_name,
                                                  e.recipient_email AS recipient_email,
                                                  p.post_title AS program
                                           FROM vce_events AS e
                                           LEFT JOIN wp_posts AS p ON e.post_id = p.ID
                                           LEFT JOIN wp_users AS u ON e.client_id = u.ID", ARRAY_N);
        foreach($values as $value){
            for($i = 0; $i< count($value); $i++){
                if(i==count($value)-1){
                    $this->output .= $value[$i]."";
                }else{
                    $this->output .= $value[$i].",";
                }
            }
            $this->output .= "\n";
        }
    }

    private function now(){
        return date("Y-m-d_H-i",time());
    }

    function export(){
        header("Content-type: application/vnd.ms-excel; charset=UTF-8");
        header("Content-disposition: csv" . date("Y-m-d") . ".csv");
        header("Content-disposition: attachment;filename=".$this->fileName.".csv");
        $this->setTableHeaders();
        $this->setTableBody();
        ob_clean();
        print utf8_decode($this->output);
        exit();
    }
}