<?php

class ListaCategorias extends Controllers
{
    public function __construct(){
        parent:: __construct();

    }
    public function listaCategorias(){
        $data['page_tag'] ="Lista Categorias";
        $data['page_title'] = " Categorias <small> Tienda Virtual</small>";
        $data['page_name'] = "categorias";
        $this->views->getView($this,"listaCategorias",$data);
    }
}
?>
