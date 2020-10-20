<?php

class Companias extends Controllers
{
    public function __construct(){
        parent:: __construct();

    }
    public function companias(){
        $data['page_tag'] ="Lista Companias";
        $data['page_title'] = " Companias <small> Tienda Virtual</small>";
        $data['page_name'] = "companias";
        $this->views->getView($this,"companias",$data);
    }
}
?>
