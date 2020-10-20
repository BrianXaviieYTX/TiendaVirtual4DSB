<?php

class ListaProductos extends Controllers
{
    public function __construct(){
        parent:: __construct();

    }
    public function listaProductos(){
        $data['page_tag'] ="Lista Productos";
        $data['page_title'] = " Productos <small> Tienda Virtual</small>";
        $data['page_name'] = "productos";
        $this->views->getView($this,"listaProductos",$data);
    }
}
?>
