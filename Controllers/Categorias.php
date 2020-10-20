<?php

class Categorias extends Controllers
{
    public function __construct(){
        parent:: __construct();

    }
    public function categorias(){
        $data['page_id'] =2;
        $data['page_tag'] ="Categorias";
        $data['page_title'] = "Categorias de nuestros Productos";
        $data['page_name'] = "categorias";
        $this->views->getView($this,"categorias",$data);
    }
  }

?>