<?php
declare(strict_types=1);

if(isset($_POST['enviar'])){
    $data['errores'] = checkForm($_POST);
    $data['input'] = filter_var_array($_POST);
    if(count($data['errores']) === 0){
        $jsonArray = json_decode($_POST['json_notas'], true);
        $resultado=calcularNotas($jsonArray);
        $data['resultado'] = $resultado;
    }
}

 /* CheckForm */

function checkForm(array $post) : array{
    $errores = [];
    if(empty($post['json_notas'])){
        $errores['json_notas'] = 'Este campo no puede estar vacío';
    }
    else{
        $modulos = json_decode($post['json_notas'], true);
        if(json_last_error() !== JSON_ERROR_NONE){
            $errores['json_notas'] = 'El formato no es correcto';
        }
        else{
            $erroresJson = "";
            foreach($modulos as $modulo => $alumnos){
                if(empty($modulo)){
                    $erroresJson .= "El nombre no puede estar vacío<br>";
                }
                if(!is_array($alumnos)){
                    $erroresJson .= "El módulo '".htmlentities($modulo)."' no tiene un array de alumnos<br>";
                }
                else{
                    foreach($alumnos as $nombre => $nota){
                        if(empty($nombre)){
                            $erroresJson .= "El módulo '".htmlentities($modulo)."' tiene un alumno sin nombre<br>";
                        }
                        if(!is_int($nota)){
                            $erroresJson .= "El módulo '".htmlentities($modulo)."' tiene la nota '".htmlentities($modulo)."' que no es int<br>";
                        }
                        else{
                            if($nota < 0 || $nota > 10){
                                $erroresJson .= "Módulo '".htmlentities($modulo)."' alumno '".htmlentities($nombre)."' tiene una nota de ".$nota."<br>";
                            }
                        }
                    }
                }
            }
            if(!empty($erroresJson)){
                $errores['json_notas'] = $erroresJson;
            }
        }
    }
    return $errores;

}

 /* CalcularNotas */
function calcularNotas(array $materias) : array{
    $resultado = [];
    $alumnos = [];
    foreach($materias as $nombreMateria => $notas){
        $resultado[$nombreMateria] = [];
        $suspensos = 0;
        $aprobados = 0;
        $min = [
            'alumno' => '',
            'nota' => 11  ];                
        $max = [
            'alumno' => '',
            'nota' => -1 ];    

        $notaAcumulada = 0;
        $numAlumnos = 0;
        
        foreach($notas as $alumno => $nota){
            if(!isset($alumnos[$alumno])){
                $alumnos[$alumno] = [ 'aprobados' => 0, 'suspensos' => 0];
            }
            $numAlumnos++;
            $notaAcumulada += $nota;
            if($nota < 5){
                $suspensos++;
                $alumnos[$alumno]['suspensos']++;
            }
            else{
                $aprobados++;
                $alumnos[$alumno]['aprobados']++;
            }
            if($nota > $max['nota']){
                $max['alumno'] = $alumno;
                $max['nota'] = $nota;
            }
            if($nota < $min['nota']){
                $min['alumno'] = $alumno;
                $min['nota'] = $nota;
            }
        }
        if($numAlumnos > 0){
            $resultado[$nombreMateria]['max']= $max;
            $resultado[$nombreMateria]['min']= $min;
            $resultado[$nombreMateria]['media'] = $notaAcumulada / $numAlumnos;
        }
        else{
            $resultado[$nombreMateria]['media'] = 0;
        }
        $resultado[$nombreMateria]['suspensos'] = $suspensos;
        $resultado[$nombreMateria]['aprobados'] = $aprobados; 

        $resultado[$nombreMateria]['max']['alumno'] = $max['alumno'];
        $resultado[$nombreMateria]['max']['nota'] = $max['nota'];
    }
    return array ('modulos' => $resultado, 'alumnos' => $alumnos);
}
include 'views/templates/header.php';
include 'views/calcNotas.FranFernandez.view.php';
include 'views/templates/footer.php';

