<?php
declare(strict_types=1);

$data = array();

if(isset($_POST['enviar'])){
    $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $data['errores'] = checkForm($_POST);
    if(count($data['errores']) == 0){
        $data['resultado'] = procesarTexto($_POST['texto']);
    }
}

function procesarTexto(string $txt) : array{
    $resultado = [];
    $txtLimpio = preg_replace("/[^a-zA-Z]/", '', $txt);
    for($i = 0; $i < strlen($txtLimpio); $i++){
        $caracter = $txtLimpio[$i];
        if(!isset($resultado[$caracter])){
            $resultado[$caracter] = 1;
        }
        else{
            $resultado[$caracter]++;
        }
    }
    //Tenemos un array con clave letras y valor número de veces que aparece dicha letra
    arsort($resultado);
    return $resultado;
}

function checkForm(array $datos) : array{
    $errores = [];
    if(empty($datos['texto'])){
        $errores['texto'] = 'Este campo es obligatorio';
    }
    return $errores;
}

include 'views/templates/header.php';
include 'views/iterativas04.view.php';
include 'views/templates/footer.php';
