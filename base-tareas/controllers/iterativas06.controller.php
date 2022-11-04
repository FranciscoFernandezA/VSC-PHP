<?php
declare(strict_types=1);

$data = array();
$data['input'] = filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);
$data['errores'] = checkForm($_POST);
if(count($data['errores']) === 0){
    $data['resultado'] = cribaErastotenes((int) $_POST['numero']);
}

function cribaErastotenes(int $num) : array{
    $primos = array_fill(2, $num-1, true);
    for($i = 2; $i**2 < $num; $i++){
        if(isset($primos[$i])){
            for($j = $i; $i * $j <= $num; $j++){
                unset($primos[$i*$j]);
            }
        }
    }
    return array_keys($primos);
}

function checkForm(array $post) : array{
    $errores = [];
    if(empty($post['numero'])){
        $errores['numero'] = 'Este campo es obligatorio';
    }
    elseif(!filter_var($post['numero'], FILTER_VALIDATE_INT)){
        $errores['numero'] = 'Debe insertar un número entero';
    }
    elseif($post['numero'] < 2){
        $errores['numero'] = 'El número debe ser mayor o igual a 2';
    }
    return $errores;
}

include 'views/templates/header.php';
include 'views/iterativas06.view.php';
include 'views/templates/footer.php';