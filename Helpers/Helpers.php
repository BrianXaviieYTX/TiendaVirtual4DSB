<?php 

function base_url()
{
    return BASE_URL;
}
function media()
{
    return BASE_URL."/Assets";
}
function headerTienda($data = ""){
    $view_headerT = "Views/Template/header_tienda.php";
    require_once ($view_headerT);
}
function footerTienda($data = ""){
    $view_footerT = "Views/Template/footer_tienda.php";
    require_once ($view_footerT);
}
function headerAdmin($data = "")
{
    $view_header = "Views/Template/header_admin.php";
    require_once ($view_header);
}
function footerAdmin($data = "")
{
    $view_footer = "Views/Template/footer_admin.php";
    require_once ($view_footer);
}

function dep($data)
{
    $format =print_r('<pre>');
    $format =print_r($data);
    $format =print_r('</pre>');
    return $format;
}

function getModal(string $nameModal, $data)
{
    $view_modal=  "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;
    
}
// Elimina exceso de espacio entre palabras
function strClean($strCadena){
$string = preg_replace(['/\s+/','/^\s|\s/'],['',''],$strCadena);
$string =trim($string); //elimina espacios en blanco al inicio y al final
$string =stripslashes($string); //elimina las \ invertidas
$string =str_ireplace("<scrip>","",$string);
$string =str_ireplace("</scrip>","",$string);
$string =str_ireplace("<scrip scr>","",$string);
$string =str_ireplace("<scrip type=>","",$string);
$string =str_ireplace("SELECT * FROM","",$string);
$string =str_ireplace("DELETE FROM","",$string);
$string =str_ireplace("INSERT INTO","",$string);
$string =str_ireplace("SELECT COUNT(*) FORM","",$string);
$string =str_ireplace("DROP TABLE","",$string);
$string =str_ireplace("OR '1'='1","",$string);
$string =str_ireplace('OR "1"="1"',"",$string);
$string =str_ireplace('OR ´1´=´1´',"",$string);
$string =str_ireplace("is NULL; --","",$string);
$string =str_ireplace("is NULL; --","",$string);
$string =str_ireplace("LIKE '","",$string);
$string =str_ireplace('LIKE "',"",$string);
$string =str_ireplace("LIKE ´","",$string);
$string =str_ireplace("OR 'a'='a","",$string);
$string =str_ireplace('OR "a"="a',"",$string);
$string =str_ireplace("OR ´a´=´a","",$string);
$string =str_ireplace("OR ´a´=´a","",$string);
$string =str_ireplace("--","",$string);
$string =str_ireplace("^","",$string);
$string =str_ireplace("[","",$string);
$string =str_ireplace("]","",$string);
$string =str_ireplace("==","",$string);
return $string;
}

// Genera contraseña de 10 digitos
function passGenerator($length= 10)
{
    $pass ="";
    $longitudPass= $length;
    $cadena="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $longitudCadena=strlen($cadena);

    for ($i=1;$i<=$longitudPass;$i++) 
    { 
    	$pos = rand(0,$longitudCadena-1);
    	$pass .= substr($cadena, $pos,1);
    }
    return $pass;
}
// Genera un Token
function token(){
    $r1 =bin2hex (random_bytes(10));
    $r2 =bin2hex (random_bytes(10));
    $r3 =bin2hex (random_bytes(10));
    $r4 =bin2hex (random_bytes(10));
    $token  = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
    return $token;
}
// Funcion para Valores Monetarios
function formatMoney($cantidad)
{
    $cantidad = number_format($cantidad,2,SPD,SPM);
    return $cantidad;
}


?>