<?php
declare(strict_types=1);

define('MIN', 1);
define('MAX', 10);
define('NUM_MAX_BOLAS', ((MAX - MIN) + 1 ));

define('TAM_CARTON', 3);

$data['resultado'] = [];

//$test = json_decode("HOLA");var_dump($test);echo json_last_error() === JSON_ERROR_NONE ? 'sin errores' : 'con errores'; die;
//var_dump($_POST);
if(isset($_POST['enviar'])){
    
    if(isset($_POST['bingo_anterior']) && !empty($_POST['bingo_anterior'])){
        $error = false;
        $bingo = json_decode(base64_decode($_POST['bingo_anterior']), true);
        if(json_last_error() !== JSON_ERROR_NONE){
            $error = true;
        }
        $carton = json_decode(base64_decode($_POST['carton']), true);
        if(json_last_error() !== JSON_ERROR_NONE){
            $error = true;
        }
        if($error){
            $bingo = [];
            $carton = generarCarton();
        }        
    }  
    else{
        $bingo = [];
        $carton = generarCarton();
    }
    $noSalieronCarton = array_diff($carton, $bingo);
    $finalizado = count($noSalieronCarton) === 0;
    if(!$finalizado){
        $bingo[] = sacarNumero($bingo);
    }
    $noSalieronCarton = array_diff($carton, $bingo);
    $finalizado = count($noSalieronCarton) === 0;
    
    $data['finalizado'] = $finalizado;
    $data['no_salieron'] = $noSalieronCarton;
    $data['bingo'] = $bingo;
    $data['carton'] = $carton;
}
else{
    $data['finalizado'] = false;
}


function generarCarton() : array{
    $carton = [];
    for($i = 0; $i < TAM_CARTON; $i++){
        $carton[] = sacarNumero($carton);
    }
    sort($carton);
    return $carton;
}

function sacarNumero(array $yaSalieron) : int{
    do{
        $num = rand(MIN, MAX);
        
    }while(array_search($num, $yaSalieron) !== false);
    return $num;
}

include 'views/templates/header.php';
include 'views/iterativas07.view.php';
include 'views/templates/footer.php';

