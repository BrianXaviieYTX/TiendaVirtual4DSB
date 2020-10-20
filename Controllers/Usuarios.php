<?php

class Usuarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }
    public function usuarios()
    {
        $data['page_tag'] = "Usuarios";
        $data['page_title'] = " Usuario <small> Tienda Virtual</small>";
        $data['page_name'] = "usuarios";
        $this->views->getView($this, "usuarios", $data);
    }

    public function getUsers()
    {
        $arrData = $this->model->selectUsers();
        for ($i = 0; $i < count($arrData); $i++) {

            switch ($arrData[$i]['nombrerol']) {
                case 'Administador':
                    $arrData[$i]['nombrerol'] = '<span class="badge badge-pill badge-primary">Administrador</span>';
                    break;

                case 'Inspector':
                    $arrData[$i]['nombrerol'] = '<span class="badge badge-pill badge-primary">Inspector</span>';
                    break;

                case 'Bodega':
                    $arrData[$i]['nombrerol'] = '<span class="badge badge-pill badge-secondary">Bodega</span>';
                    break;

                case 'Ventas':
                    $arrData[$i]['nombrerol'] = '<span class="badge badge-pill badge-secondary">Ventas</span>';
                    break;
                default:
                    break;
            }

            if ($arrData[$i]['estatus'] == 1) {
                $arrData[$i]['estatus'] = '<span class="badge badge-success">Activo</span>';
            } else {
                $arrData[$i]['estatus'] = '<span class="badge badge-danger">Inactivo</span>';
            }

            $arrData[$i]['optiones'] =
                '<div class="text-center">
            <button class="btn btn-info btn-sm btnViewUser" onClick="fntViewUser(' . $arrData[$i]['idpersona'] . ')" title="Ver_Datos"><i class="far fa-eye" aria-hidden="true"></i></button>
            <button class="btn btn-primary btn-sm btnEditUser" onClick="fntEditUser(' . $arrData[$i]['idpersona'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>
            <button class="btn btn-danger btn-sm btnDelUser" onClick="fntDelUsuario(' . $arrData[$i]['idpersona'] . ')" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
            </div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function getUser($idpersona)
    {
        $intIdpersona = intval($idpersona);
        if ($intIdpersona > 0) {
            $arrData = $this->model->selectUser($intIdpersona);
            // dep($arrData);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no Encontrados');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setUser()
    {
        if ($_POST) {
            // dep($_POST);
            // die();
            if (
                empty($_POST['txtNroId']) ||
                empty($_POST['txtNombre']) ||
                empty($_POST['txtApellido']) ||
                empty($_POST['txtNroTelefono']) ||
                empty($_POST['txtEmail']) ||
                empty($_POST['txtDireccion']) ||
                empty($_POST['listRolUser']) ||
                empty($_POST['listStatusUser'])

            ) {
                $arrResponse = array("status" => false, "msg" => 'Datos Incorrectos.');
            } else {

                $intIdUser = intval($_POST['idUser']);
                $strNroId = strClean($_POST['txtNroId']);
                $strNombres = ucwords(strClean($_POST['txtNombre']));
                $strApellidos = ucwords(strClean($_POST['txtApellido']));
                $strTelefono = strClean($_POST['txtNroTelefono']);
                $strEmail = strtolower(strClean($_POST['txtEmail']));
                $strDireccion = ucwords(strClean($_POST['txtDireccion']));
                $intTipoIdRol = intval($_POST['listRolUser']);
                $intStatus = intval($_POST['listStatusUser']);

                if ($intIdUser == 0) {
                    $option = 1;
                    $strContrasenia = empty($_POST['txtContrasenia']) ? hash("SHA256", passGenerator())
                        : hash("SHA256", $_POST['txtContrasenia']);
                    $request_user = $this->model->insertUsuario(
                        $strNroId,
                        $strNombres,
                        $strApellidos,
                        $strTelefono,
                        $strEmail,
                        $strContrasenia,
                        $strDireccion,
                        $intTipoIdRol,
                        $intStatus
                    );
                } else {
                    $option = 2;
                    $strContrasenia = empty($_POST['txtContrasenia']) ? "" : hash("SHA256", $_POST['txtContrasenia']);
                    $request_user = $this->model->updateUsuario(
                        $intIdUser,
                        $strNroId,
                        $strNombres,
                        $strApellidos,
                        $strTelefono,
                        $strEmail,
                        $strContrasenia,
                        $strDireccion,
                        $intTipoIdRol,
                        $intStatus
                    );
                }
                if ($request_user > 0) {
                    if ($option == 1 ) {
                        $arrResponse = array("status" => true, "msg" => 'Datos Guardados Correctamente.');
                    } else {
                        $arrResponse = array("status" => true, "msg" => 'Datos Actualizados Correctamente.');
                    }

                } else if ($request_user == 'exist') {
                    $arrResponse = array("status" => false, "msg" => '!Atencion¡ el E-mail o la identificacion ya existe, Ingreseotro.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los Datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delUsuario(){
        if ($_POST) {
            $intIdpersona = intval($_POST['idPersona']);
            $requestDelete = $this->model->deleteUsuario($intIdpersona);
            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Usuario');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Usuario');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
