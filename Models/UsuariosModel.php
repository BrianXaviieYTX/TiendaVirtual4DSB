<?php

class UsuariosModel extends Mysql
{
    private $intIdpersona;
    private $strNroId;
    private $strNombres;
    private $strApellidos;
    private $strTelefono;
    private $strEmail;
    private $strContrasenia;
    private $strDireccion;
    private $intTipoIdRol;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }
    public function selectUsers()
    {
        // EXTRAE ROLES
        $sql = "SELECT * FROM persona INNER JOIN rol ON idrol=fk_idrol WHERE estatus!=0;";
        $request = $this->select_all($sql);
        return $request;
    }
    public function selectUser($idpersona)
    {
        $this->intIdpersona = $idpersona;
        $sql = "SELECT p.idpersona,p.nroidentificacion,p.nombres,p.apellidos,p.telefono, 
        p.email_user,p.password,p.direccionfiscal,p.fk_idrol,p.estatus,r.idrol,r.nombrerol, 
        DATE_FORMAT(p.datecreated, '%d-%m-%Y') As fechaRegistro 
        FROM persona AS p 
        INNER JOIN rol AS r ON p.fk_idrol=r.idrol 
        WHERE p.idpersona = $this->intIdpersona";
        $request = $this->select($sql);
        return $request;
    }

    public function insertUsuario(
        string $nroId,
        string $nombres,
        string $apellidos,
        string $telefono,
        string $email,
        string $contrasenia,
        string $direccion,
        int $idTiporol,
        int $status
    ) {

        $this->strNroId = $nroId;
        $this->strNombres = $nombres;
        $this->strApellidos = $apellidos;
        $this->strTelefono = $telefono;
        $this->strEmail = $email;
        $this->strContrasenia = $contrasenia;
        $this->strDireccion = $direccion;
        $this->intTipoIdRol = $idTiporol;
        $this->intStatus = $status;

        $return = "";
        $sql = "SELECT * FROM persona WHERE email_user ='{ $this->strEmail }' OR nroidentificacion ='{ $this->strNroId }'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO persona(
                `nroidentificacion`, `nombres`, `apellidos`, `telefono`, `email_user`, `password`, `direccionfiscal`,
                `fk_idrol`, `estatus`)VALUES(?,?,?,?,?,?,?,?,?)";
            $arrData = array(
                $this->strNroId,
                $this->strNombres,
                $this->strApellidos,
                $this->strTelefono,
                $this->strEmail,
                $this->strContrasenia,
                $this->strDireccion,
                $this->intTipoIdRol,
                $this->intStatus
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
    public function updateUsuario(
        int $iduser,
        string $nroId,
        string $nombres,
        string $apellidos,
        string $telefono,
        string $email,
        string $contrasenia,
        string $direccion,
        int $idTiporol,
        int $status
    ) {
        $this->intIdpersona = $iduser;
        $this->strNroId = $nroId;
        $this->strNombres = $nombres;
        $this->strApellidos = $apellidos;
        $this->strTelefono = $telefono;
        $this->strEmail = $email;
        $this->strContrasenia = $contrasenia;
        $this->strDireccion = $direccion;
        $this->intTipoIdRol = $idTiporol;
        $this->intStatus = $status;

        $sql = "SELECT * FROM persona WHERE (email_user='{$this->strEmail}' AND idpersona != $this->intIdpersona)
                                OR (nroidentificacion = '{$this->strNroId}' AND idpersona != $this->intIdpersona)";
        $request = $this->select_all($sql);
        if (empty($request)) {
            if ($this->strContrasenia != "") {
                $sql = "UPDATE persona SET `nroidentificacion`=?, `nombres`=?, `apellidos`=?, `telefono`=?, `email_user`=?,
                `password`=?, `direccionfiscal`=?,`fk_idrol`=?, `estatus`=?
            WHERE `idpersona` = $this->intIdpersona";
                $arrData = array(
                    $this->strNroId,
                    $this->strNombres,
                    $this->strApellidos,
                    $this->strTelefono,
                    $this->strEmail,
                    $this->strContrasenia,
                    $this->strDireccion,
                    $this->intTipoIdRol,
                    $this->intStatus
                );
            } else {
                $sql = "UPDATE persona SET `nroidentificacion`=?, `nombres`=?, `apellidos`=?, `telefono`=?, `email_user`=?,
                `direccionfiscal`=?,`fk_idrol`=?, `estatus`=?
            WHERE `idpersona` = $this->intIdpersona";
                $arrData = array(
                    $this->strNroId,
                    $this->strNombres,
                    $this->strApellidos,
                    $this->strTelefono,
                    $this->strEmail,
                    $this->strDireccion,
                    $this->intTipoIdRol,
                    $this->intStatus
                );
            }
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function deleteUsuario(int $intIdpersona)
    {
        $this->intIdpersona = $intIdpersona;
        $sql = "UPDATE persona SET estatus = ? WHERE idpersona= $this->intIdpersona";
        $arrData=array(0);
        $request = $this->update($sql,$arrData);
        return $request;
    }
}
?>