<?php

class Login extends Controllers
{
    public function __construct()
    {
        session_start();
        parent::__construct();
    }
    public function login()
    {
        $data['page_tag'] = "Iniciar Sesion";
        $data['page_title'] = " Login <small> Tienda Virtual</small>";
        $data['page_name'] = "Iniciar Sesion";
        $data['page_function_js'] = "function_login.js";
        $this->views->getView($this, "login", $data);
    }

    public function loginUser()
    {
        // dep($_POST);
        if ($_POST) {
            if (empty($_POST['txtEmailLogin']) || empty($_POST['txtPassLogin'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $strUsuario =   strtolower(strClean($_POST['txtEmailLogin']));
                $strPassword =   hash("SHA256", $_POST['txtPassLogin']);
                $requestUser =   $this->model->loginUser($strUsuario, $strPassword);

                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'El Usuario o La contraseña son Incorrectos');
                } else {
                    $arrData = $requestUser;
                    if ($arrData['estatus']==1) {
                        $_SESSION['idUser'] = $arrData['idpersona'];
                        $_SESSION['login'] = true;
                        $arrResponse = array('status'=> true, 'msg'=> 'ok');
                    } else {
                        $arrResponse = array('status'=> false, 'msg'=> 'Usuario Inactivo.');
                    }
                    
                }
                // dep($requestUser);
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
