<?php
declare(strict_types=1);

$data = array();

if(isset($_POST['enviar'])){
    $data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    $data['error'] = checkForm($_POST);
    if(count($data['error']) === 0){
        $data['resultado'] = ordenar(stringToMatriz($_POST['datos']));
        $data['longitud'] = strlen($data['resultado'][count($data['resultado']) - 1][count($data['resultado'][0]) - 1]);
    }
}

function ordenar(array $matriz) : array{
    $aplanado = [];
    foreach($matriz as $subarray){
        $aplanado = array_merge($aplanado, $subarray);
    }
    $numColumnas = count($matriz[0]);
    $ordenado = ordenarArrayPlano($aplanado);
    $resultado = [];
    $contador = 0;
    foreach($ordenado as $num){
        if($contador % $numColumnas == 0){
            if(isset($subordenado)){
                $resultado[] = $subordenado;
            }
            $subordenado = [];
        }
        $subordenado[] = $num;
        $contador++;
    }
    $resultado[] = $subordenado;
    return $resultado;
}

function stringToMatriz(string $text) : array{
    $matriz = explode("|", $text);
    for($i = 0; $i < count($matriz); $i++){
        $aux = $matriz[$i];
        $matriz[$i] = explode(",", $aux);
    }
    return $matriz;
}

function ordenarArrayPlano(array $numeros) : array{
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

function checkForm(array $data) : array{
    $errores = [];
    if(empty($data['datos'])){
        $errores['datos'] = 'Este campo es obligatorio';        
    }
    else{
        $matriz = stringToMatriz($data['datos']);
        //Aquí ya tenemos la matriz
        //Comprobamos tamaños subarrays
        //var_dump($matriz);
        $numColumnas = count($matriz[0]);
        for($i = 1; $i < count($matriz); $i++ ){
            $aux = $matriz[$i];
            if($numColumnas !== count($aux)){
                $errores['datos'] = 'Todas las filas deben tener el mismo número de elementos.';
                return $errores;
            }
        }
        //Comprobamos que todas las posiciones estén formadas por números
        $numErroneos = [];
        foreach($matriz as $fila){
            foreach($fila as $num){
                if(!is_numeric($num)){
                    $numErroneos[] = filter_var($num, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        if(count($numErroneos) > 0){
            $errores['datos'] = 'Los siguientes valores no son válidos: '. implode(", ", $numErroneos);
        }
    }
    return $errores;
}

include 'views/templates/header.php';
include 'views/iterativas03.view.php';
include 'views/templates/footer.php';