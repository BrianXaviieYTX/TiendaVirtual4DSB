<?php

class Cart extends Controllers
{
    public function __construct(){
        parent:: __construct();

    }
    public function cart(){
        $data['page_tag'] ="Carrito";
        $data['page_title'] = "Carrito de productos";
        $data['page_name'] = "carrito";
        $this->views->getView($this,"cart",$data);
    }
  }

?>