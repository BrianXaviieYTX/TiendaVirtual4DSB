<?php

class Shop_Single extends Controllers
{
    public function __construct(){
        parent:: __construct();

    }
    public function shop_single(){
        $data['page_tag'] ="Shop_Single";
        $data['page_title'] = "Shop";
        $data['page_name'] = "shop_single";
        $this->views->getView($this,"shop_single",$data);
    }
  }

?>