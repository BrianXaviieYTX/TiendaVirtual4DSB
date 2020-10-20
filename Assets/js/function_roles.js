var tableRoles;
document.addEventListener('DOMContentLoaded', function () {
    tableRoles = $('#tableRoles').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/roles/getRoles",
            "dataSrc": ""
        },
        "columns": [
            {"data": "idrol"},
            {"data": "nombrerol"},
            {"data": "descripcion"},
            {"data": "status"},
            {"data": "options"}
        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [
            [0, "asc"]
        ]
    });
    // NUEVO ROL
    var formRol = document.querySelector("#formRol");
    formRol.onsubmit = function (e) {
        e.preventDefault();

        var intIdrol = document.querySelector('#idRol').value;
        var strNombre = document.querySelector('#txtNombre').value;
        var strDescripcion = document.querySelector('#txtDescripcion').value;
        var intStatus = document.querySelector('#listStatus').value;
        if (strNombre == "" || strDescripcion == "" || intStatus == "") {
            swal("Atencion", "Todos los Campos son Obligatorios", "error");
            return false;
        }
        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        var ajaxUrl = base_url + '/roles/setRol';
        var formData = new FormData(formRol);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                var objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormRol').modal("hide");
                    formRol.reset();
                    swal("Roles de usuario", objData.msg, "success");
                    tableRoles.api().ajax.reload(function () {
                        fntEditRol();
                        fntDelRol();
                    });
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
            // console.log(request);
        }
    }
});

$('#tableRoles').DataTable();

function openModal() {
    document.querySelector('#idRol').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#formRol').reset();
    $('#modalFormRol').modal('show');

}
window.addEventListener('load', function () {
    fntEditRol();
    fntDelRol();
}, false);

function fntEditRol() {
    var btnEditRol = document.querySelectorAll(".btnEditRol");
    btnEditRol.forEach(function (btnEditRol) {
        btnEditRol.addEventListener('click', function () {
            document.querySelector('#titleModal').innerHTML = "Actualizar Rol";
            document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
            document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
            document.querySelector('#btnText').innerHTML = "Actualizar";

            var idrol = this.getAttribute("rl");
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/roles/getRol/' + idrol;
            request.open("GET", ajaxUrl, true);
            request.send();
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    // console.log(request.responseText);
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        document.querySelector('#idRol').value = objData.data.idrol;
                        document.querySelector('#txtNombre').value = objData.data.nombrerol;
                        document.querySelector('#txtDescripcion').value = objData.data.descripcion;
                        if (objData.data.status == 1) {
                            var optionSelect = '<option value="1" selected class="notBlock">Activo</option>'
                        } else {
                            var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>'
                        }
                        var htmlSelect = `${optionSelect}
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                        `;
                        document.querySelector('#listStatus').innerHTML = htmlSelect;
                        $('#modalFormRol').modal('show');
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            }
        })
    })
}

function fntDelRol() {
    var btnDelRol = document.querySelectorAll(".btnDelRol");
    btnDelRol.forEach(function (btnDelRol) {
        btnDelRol.addEventListener('click', function () {
            var idrol = this.getAttribute("rl");

            swal({
                title: "Eliminar rol",
                text: "¿Realmente quiere eliminar el rol?",
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
                        var ajaxUrl = base_url + '/Roles/delRol/';
                        var strData = "idrol=" + idrol;
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
                                    tableRoles.api().ajax.reload(function () {
                                        fntEditRol();
                                        fntDelRol();
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
        })
    })
}