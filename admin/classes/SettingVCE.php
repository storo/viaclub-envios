<?php

class SettingsVCE {
    private $post_types_selected;
    private $post_types_html;
    private $message = array();

    function __construct(){
        $this->load();
    }

    function reload(){
        $this->load();
    }

    private function load(){
        $this->args_post_type = array(
            'public'                => true,
            'exclude_from_search'   => false,
            '_builtin'              => false
        );
        $this->post_types = get_post_types($this->args_post_type);

        $this->args_pages = array(
            'sort_order' => 'ASC',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish'
        );

        if(get_option('vce_valid_post_type') && get_option('vce_valid_post_type') != '{}'){
            $this->post_types_selected = json_decode(get_option('vce_valid_post_type'), true);
        }else{
            $this->post_types_selected = array();
        }

        $this->message['vce_mail_from'] = get_option('vce_mail_from');
        $this->message['vce_mail_bbc'] = get_option('vce_mail_bbc');
        $this->message['vce_mail_subject'] = get_option('vce_mail_subject');
        $this->message['vce_mail_text_message'] = get_option('vce_mail_text_message');
        $this->message['vce_mail_html_message'] = get_option('vce_mail_html_message');
    }

    function getMessageValues(){
        return $this->message;
    }

    function savePostType(){
        $return = false;
        if(isset($_POST['vce-post-type'])){

            $array_types = $_POST['vce-post-type'];
            $json_post_types = "";

            for($i=0; $i<count($array_types);$i++){
                $json_post_types .= '"'.$i.'":"'.$array_types[$i].'"'.(($i == count($array_types)-1)? "" :",");
            }
            $return = update_option('vce_valid_post_type', "{".$json_post_types."}");
        }
        return $return;
    }

    function saveMessage(){
        $return = array();
        if(isset($_POST['message'])){
            $messages = $_POST['message'];
            foreach($messages as $key => $value){
                $return[] = update_option($key, $value);
            }
        }
        return (in_array(false, $return))? false : true ;
    }

    function getPostTypeWithFormatHtml($element){
        foreach ( $this->post_types as $post_type ) {
            $this->post_types_html .= '<'.$element.'>';
            $this->post_types_html .= '<input type="checkbox" name="vce-post-type[]" value="'.$post_type.'" ';
            $this->post_types_html .= $this->selectedPostType($post_type).' />';
            $this->post_types_html .= $post_type.'</'.$element.'>';
        }
        return $this->post_types_html;
    }

    private function selectedPostType($type){
        return (in_array($type,$this->post_types_selected))? 'checked':'';
    }

}
