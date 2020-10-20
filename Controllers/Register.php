<?php

class Register extends Controllers
{
    public function __construct(){
        parent:: __construct();

    }
    public function register(){
        $data['page_tag'] ="Crear Cuenta";
        $data['page_title'] = " Registro <small> Tienda Virtual</small>";
        $data['page_name'] = "Crear Cuenta";
        $this->views->getView($this,"register",$data);
    }
}
?>
