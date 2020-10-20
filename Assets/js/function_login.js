$('.login-content [data-toggle="flip"]').click(function () {
    $('.login-box').toggleClass('flipped');
    return false;
});

document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('#formLogin')) {
        let formLogin = document.querySelector('#formLogin');
        formLogin.onsubmit = function (e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmailLogin').value;
            let strPassword = document.querySelector('#txtPassLogin').value;

            if (strEmail == "" || strPassword == "") {
                swal("Por Favor", "Escriba Su email y Contraseña", "error");
                return false;
            } else {
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/login/loginUser'
                var formData = new FormData(formLogin);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState != 4) return;
                    if (request.readyState == 200) {
                        var objData = JSON.parse(request.responseText)
                        if (objData.status) {
                            window.location = base_url + '/dashboard';
                        } else {
                            swal("Atencion.", objData.msg, "error");
                            document.querySelector('#txtPassLogin').value = "";
                        }
                    } else {
                        swal("Atencion.", "Error en el Proceso", "error");
                    }
                    return false;
                }
            }
        }
    }
}, false);