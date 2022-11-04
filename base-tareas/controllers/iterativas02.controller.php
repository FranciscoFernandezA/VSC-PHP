<?php
declare(strict_types=1);
$data = array();

if(isset($_POST['enviar'])){
    $data['errores'] = checkForm($_POST);
    $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($data['errores'])){

        $array = explode(",", $_POST['datos']);
        
        $data['resultado'] = ordenarArray($array);
    }    
}

function ordenarArray(array $numeros) : array{
    for($i = 0; $i < (count($numeros) - 1); $i++){
        for($j = $i + 1; $j < count($numeros); $j++){
            if($numeros[$i] > $numeros[$j]){
                $aux = $numeros[$i];
                $numeros[$i] = $numeros[$j];
                $numeros[$j] = $aux;
            }
        }
    }
    return $numeros;
}

function checkForm(array $input) : array{
    $errores = [];
    if(empty($input['datos'])){
        $errores['datos'] = "Este campo es obligatorio";
    }
    else{
        $numeros = explode(",", $input['datos']);
        $numerosErroneos = [];
        foreach($numeros as $num){
            if(!is_numeric($num)){
                $numerosErroneos[] = $num;
            }
        }
        if(count($numerosErroneos) > 0){
            $errores['datos'] = "Los siguientes valores no son válidos: " . implode(",", filter_var_array($numerosErroneos, FILTER_SANITIZE_SPECIAL_CHARS));           
        }
    }
    return $errores;
}

include 'views/templates/header.php';
include 'views/iterativas02.view.php';
include 'views/templates/footer.php';