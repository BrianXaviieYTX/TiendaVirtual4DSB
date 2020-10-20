window.addEventListener('load', function () {
    fntRolesUser();
    // fntViewUser();
    // fntEditUser();
    // fntDelUsuario();
}, false);

// LISTA SELECT ROLES
function fntRolesUser() {
    var ajaxUrl = base_url + '/roles/getSelectRoles';
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET", ajaxUrl, true);
    request.send();

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#listRolUser').innerHTML = request.responseText;
            document.querySelector('#listRolUser').value = 1;
            $('#listRolUser').selectpicker('render');
        }
    }
}

var tableUser;
document.addEventListener('DOMContentLoaded', function () {
    tableUser = $('#tableUser').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/usuarios/getUsers",
            "dataSrc": ""
        },
        "columns": [{
                "data": "idpersona"
            },
            {
                "data": "nombres"
            },
            {
                "data": "apellidos"
            },
            {
                "data": "email_user"
            },
            {
                "data": "nombrerol"
            },
            {
                "data": "estatus"
            },
            {
                "data": "optiones"
            }
        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "asc"]
        ]
    });
    // NUEVO ROL
    var formUser = document.querySelector("#formUser");
    formUser.onsubmit = function (e) {
        e.preventDefault();

        var intIdUser = document.querySelector('#idUser').value;
        var strNroIdentificacion = document.querySelector('#txtNroId').value;
        var strNombres = document.querySelector('#txtNombre').value;
        var strApellidos = document.querySelector('#txtApellido').value;
        var strNroTelefono = document.querySelector('#txtNroTelefono').value;
        var strEmail = document.querySelector('#txtEmail').value;
        var strContrasenia = document.querySelector('#txtContrasenia').value;
        var strDireccion = document.querySelector('#txtDireccion').value;
        var intRoles = document.querySelector('#listRolUser').value;

        if (strNroIdentificacion == "" || strNombres == "" || strApellidos == "" || strNroTelefono == "" ||
            strEmail == "" || strDireccion == "" || intRoles == "") {
            swal("Atencion", "Todos los Campos son Obligatorios", "error");
            return false;
        }
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/usuarios/setUser';
        var formData = new FormData(formUser);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormUser').modal("hide");
                    formUser.reset();
                    swal("Usuarios", objData.msg, "success");
                    tableUser.api().ajax.reload();
                }
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
});

$('#tableUser').DataTable();



function fntViewUser(idpersona) {
    var idpersona = idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/usuarios/getUser/' + idpersona;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                var estadoUsuario = objData.data.estatus == 1 ?
                    '<span class="badge badge-success">Activo</span>' :
                    '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector('#celIdentificacion').innerHTML = objData.data.nroidentificacion;
                document.querySelector('#celNombre').innerHTML = objData.data.nombres;
                document.querySelector('#celApellido').innerHTML = objData.data.apellidos;
                document.querySelector('#celTelefono').innerHTML = objData.data.telefono;
                document.querySelector('#celEmail').innerHTML = objData.data.email_user;
                document.querySelector('#celDireccion').innerHTML = objData.data.direccionfiscal;
                document.querySelector('#celRol').innerHTML = objData.data.nombrerol;
                document.querySelector('#celStatus').innerHTML = estadoUsuario;
                document.querySelector('#celFecha').innerHTML = objData.data.fechaRegistro;
                $('#modalViewUser').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}


function fntEditUser(idpersona) {
    document.querySelector('#titleModalUser').innerHTML = "Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionFormUser').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Actualizar";

    var idpersona = idpersona;
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    var ajaxUrl = base_url + '/usuarios/getUser/' + idpersona;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
                document.querySelector('#idUser').value = objData.data.idpersona;
                document.querySelector('#txtNroId').value = objData.data.nroidentificacion;
                document.querySelector('#txtNombre').value = objData.data.nombres;
                document.querySelector('#txtApellido').value = objData.data.apellidos;
                document.querySelector('#txtNroTelefono').value = objData.data.telefono;
                document.querySelector('#txtEmail').value = objData.data.email_user;
                document.querySelector('#txtDireccion').value = objData.data.direccionfiscal;
                document.querySelector('#txtContrasenia').value = objData.data.password;
                document.querySelector('#listRolUser').value = objData.data.idrol;
                $('#listRolUser').selectpicker('render');
                if (objData.data.estatus == 1) {
                    document.querySelector('#listStatusUser').value = 1;
                } else {
                    document.querySelector('#listStatusUser').value = 2;
                }
                $('#listStatusUser').selectpicker('render');
            }
        }
        $('#modalFormUser').modal('show');

    }
}


function fntDelUsuario(idpersona) {
    var idPersona = idpersona;
    swal({
        title: "Eliminar Usuario",
        text: "¿Realmente quieres eliminar este Usaurio?",
        icon: "warning",
        // buttons: true,
        buttons: {
            cancel: {
                text: "No, cancelar!",
                value: false,
                visible: true,
                className: "",
                closeModal: true,
            },
            confirm: {
                text: "Si, eliminar!",
                value: true,
                visible: true,
                className: "",
                closeModal: false
            }
        }
    }).then((
        function (isConfirm) {
            if (isConfirm) {

                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/usuarios/delUsuario/';
                var strData = "idPersona=" + idPersona;
                request.open("POST", ajaxUrl, true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function () {
                    if (request.readyState = 4 && request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            swal("Eliminar!", objData.msg, {
                                icon: "success",
                            });
                            tableUser.api().ajax.reload(function () {
                                fntRolesUser();
                            });
                        } else {
                            swal("Atencion!", objData.msg, {
                                icon: "error"
                            });
                        }
                    }
                }
            }
        }), )
}

function openModal() {
    document.querySelector('#idUser').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionFormUser').classList.replace("btn-info", "btn-primary");
    document.querySelector('#titleModalUser').innerHTML = "Nuevo Usuario";
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#formUser').reset();
    $('#modalFormUser').modal('show');

}