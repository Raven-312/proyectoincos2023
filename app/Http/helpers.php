<?php
function formatoEstado($estado){
    $res = "Activo";
    if($estado == 0){
        $res = "Deshabilitado";
    }
    return $res;
}
function formatoMovimiento($estado){
    $res = "Entrada de efectivo";
    if($estado == 1){
        $res = "Salida de efectivo";
    }
    return $res;
}
function formatoFechaHoraVista($fecha){
    $dia=substr($fecha,8,2);
    $mes=substr($fecha,5,2);
    switch($mes){
        case '01':
            $mes = 'Ene';
            break;
        case '02':
            $mes = 'Feb';
            break;
        case '03':
            $mes = 'Mar';
            break;
        case '04':
            $mes = 'Abr';
            break;
        case '05':
            $mes = 'May';
            break;
        case '06':
            $mes = 'Jun';
            break;
        case '07':
            $mes = 'Jul';
            break;
        case '08':
            $mes = 'Ago';
            break;
        case '09':
            $mes = 'Sep';
            break;
        case '10':
            $mes = 'Oct';
            break;
        case '11':
            $mes = 'Nov';
            break;
        case '12':
            $mes = 'Dic';
            break;
        default:
            $mes = '---';
    }
    $anio=substr($fecha,0,4);
    $hora=substr($fecha,11,5);
    $fechaForm=$dia."/".$mes."/".$anio." ".$hora;
    return $fechaForm;
}
function formatoFechaBD($fecha){
    $dia=substr($fecha,0,2);
    $mes=substr($fecha,3,2);
    $anio=substr($fecha,6,4);
    $fechaForm=$anio."-".$mes."-".$dia;
    return $fechaForm;
}

function verificarEstado($valor){
    //si es 1 entonces es verdad
    $res = true;
    if($valor == 0){
        $res = false;
    }
    return $res;
}

function formatoTransaccion($valor){
    $res = "Efectivo";
    if($valor == 1){
        $res = "Transacción";
    }
    return $res;
}

function encriptarID($valor){
    $clave  = 'Vamos donde las cariñosas pra disfrutar la vida';
    $method = 'aes-256-cbc';
    $iv = base64_decode("C9fBxl1EWtYTL1TM8jfstw==");
    return openssl_encrypt ($valor, $method, $clave, false, $iv);
}

function desencriptarID($valor){
    $clave  = 'Vamos donde las cariñosas pra disfrutar la vida';
    $method = 'aes-256-cbc';
    $iv = base64_decode("C9fBxl1EWtYTL1TM8jfstw==");
    return openssl_decrypt($valor, $method, $clave, false, $iv);
}
//attribute = nombre del campo - y el mensaje
function translatePassErrors($attribute,$message){
    $res = $message;
    switch($message){
        case "The ".$attribute." must contain at least one uppercase and one lowercase letter.":
            $res = "La contraseña debe tener al menos una Mayúscula o Minúscula";
            break;
        case "The ".$attribute." must contain at least one letter.":
            $res = "La contraseña debe tener al menos una letra";
            break;
        case "The ".$attribute." must contain at least one symbol.":
            $res = "La contraseña debe tener al menos un símbolo";
            break;
        case "The ".$attribute." must contain at least one number.":
            $res = "La contraseña debe tener al menos un número";
            break;
        default:
    }
    return $res;
}