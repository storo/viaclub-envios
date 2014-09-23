<?php

class SettingsVCE {
    private $post_types_selected;
    private $post_types_html;
    private $page;
    private $message = array();

    function __construct(){
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
        $this->pages = get_pages($this->args_pages);

        if(get_option('vce_valid_post_type') && get_option('vce_valid_post_type') != '{}'){
            $this->post_types_selected = json_decode(get_option('vce_valid_post_type'));
        }else{
            $this->post_types_selected = array();
        }

        $this->page = get_option('vce_page_form', '');

        $this->message['vce_mail_from'] = get_option('vce_mail_from');
        $this->message['vce_mail_bbc'] = get_option('vce_mail_bbc');
        $this->message['vce_mail_subject'] = get_option('vce_mail_subject');
        $this->message['vce_mail_text_message'] = get_option('vce_mail_text_message');
        $this->message['vce_mail_html_message'] = get_option('vce_mail_html_message');

    }

    function getMessageValues(){
        return $this->message;
    }

    function getPages($name = 'vce-pages', $text_blank = 'Seleccione p&aacute;gina'){
        $select = '<option value="">'.$text_blank.'</option>';
        foreach($this->pages as $page){
            if(!empty($page->post_title)){
                $select .= '<option value="'.$page->ID.'" ';
                $select .= $this->selectedPage($page->ID).'>';
                $select .= $page->post_title.'</option>';
            }
        }
        return '<select name="'.$name.'">'.$select.'</select>';
    }

    function savePage($page){
        return update_option('vce_page_form', $page);
    }

    function savePostType($array_types){
        $json_post_types = "";
        for($i=0; $i<count($array_types);$i++){
            $json_post_types .= '"'.$i.'":"'.$array_types[$i].'"'.(($i == count($array_types)-1)? "" :",");
        }
        return update_option('vce_valid_post_type', "{".$json_post_types."}");
    }

    function getPostTypeWithFormatHtml($element){
        foreach ( $this->post_types as $post_type ) {
            $this->post_types_html .= '<'.$element.'>';
            $this->post_types_html .= '<input type="checkbox" name="vce-post-type" value="'.$post_type.'" ';
            $this->post_types_html .= $this->selectedPostType($post_type).' />';
            $this->post_types_html .= $post_type.'</'.$element.'>';
        }
        return $this->post_types_html;
    }

    private function selectedPage($page){
        return ($this->page == $page)? 'selected="selected"':'';
    }

    private function selectedPostType($type){
        return (in_array($type,$this->post_types_selected))? 'checked':'';
    }



}
