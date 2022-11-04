<?php
declare(strict_types=1);

if(isset($_POST['enviar'])){
    $data['errores'] = checkForm($_POST);
    $data['input'] = filter_var_array($_POST);
    if(count($data['errores']) === 0){
        //hago la lógica
        $jsonArray = json_decode($_POST['json_notas'], true);
        //var_dump($jsonArray);die;
        $resultado = datosAsignaturas($jsonArray);
        $data['resultado'] = $resultado;
    }
}

function checkForm(array $post) : array{
    $errores = [];
    if(empty($post['json_notas'])){
        $errores['json_notas'] = 'Este campo es obligatorio';
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
                    $erroresJson .= "El nombre del módulo no puede estar vacío<br>";
                }
                if(!is_array($alumnos)){
                    $erroresJson .= "El módulo '".htmlentities($modulo)."' no tiene un array de alumnos<br>";//Equivale a filter_var($modulo, FILTER_SANITIZE_SPECIAL_CHARS);
                }
                else{
                    foreach($alumnos as $nombre => $nota){
                        if(empty($nombre)){
                            $erroresJson .= "El módulo '".htmlentities($modulo)."' tiene un alumno sin nombre<br>";//Equivale a filter_var($modulo, FILTER_SANITIZE_SPECIAL_CHARS);
                        }

                        foreach($nota as $num){
                            
                        if(!is_numeric($num)){
                            $erroresJson .= "El módulo '".$num."' tiene la nota '".$num."' que no es un decimal<br>";//Equivale a filter_var($modulo, FILTER_SANITIZE_SPECIAL_CHARS);
                        }
                        else{
                            if($num < 0 || $num > 10){
                                $erroresJson .= "Módulo '".$modulo."' alumno '".$nombre."' tiene una nota de ".$num."<br>";//Equivale a filter_var($modulo, FILTER_SANITIZE_SPECIAL_CHARS);
                            }
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

function datosAsignaturas(array $materias) : array{
    $resultado = [];
    $alumnos = [];
    foreach($materias as $nombreMateria => $notas){
        $resultado[$nombreMateria] = [];
        $suspensos = 0;
        $aprobados = 0;
        $max = [
            'alumno' => '',
            'nota' => -1.0
        ];  //-1
        $min = [
            'alumno' => '',
            'nota' => 11.0
        ];  //11


        $notaAcumulada = 0;
        $contarNotas = 0;

        //Aprobados y suspensos segun las medias de sus notas por asignatura
        $Raprobados= 0;
        $Rsuspensos= 0;

        //$RaprobadosAlumno= 0;
        //$RsuspensosAlumno= 0;

        foreach($notas as $alumno => $nota){
            if(!isset($alumnos[$alumno])){
                $alumnos[$alumno] = [ 'aprobados' => 0, 'suspensos' => 0];
            }

            $suma=0;

            foreach($nota as $num){
            $contarNotas++;
            
            $notaAcumulada += $num;

            /*
            if($num < 5){
                //$suspensos++;
                $alumnos[$alumno]['suspensos'];//Examenes Suspensos
            }
            else{
                //$aprobados++;
                $alumnos[$alumno]['aprobados'];//Examenes Aprobados
            }
            */


            if($num > $max['nota']){
                $max['alumno'] = $alumno;
                $max['nota'] = $num;
            }
            if($num < $min['nota']){
                $min['alumno'] = $alumno;
                $min['nota'] = $num;
            }

            $suma+=$num; 

            }
            $mediaModulo=$suma/count($nota);

            if($mediaModulo>=5){
                $Raprobados++;
                $alumnos[$alumno]['aprobados']++;
            }else{
                $Rsuspensos++;
                $alumnos[$alumno]['suspensos']++;
            }
            
        }
        if($contarNotas > 0){
            $resultado[$nombreMateria]['media'] = $notaAcumulada / $contarNotas;
            $resultado[$nombreMateria]['max']= $max;
            $resultado[$nombreMateria]['min']= $min;
        }
        else{
            $resultado[$nombreMateria]['media'] = 0;

        }
        //EXAMENES SUSPENSOS Y APROBADOS
        
        $resultado[$nombreMateria]['suspensos'] = $Rsuspensos;
        $resultado[$nombreMateria]['aprobados'] = $Raprobados; 

        //$resultado[$nombreMateria]['max']['alumno'] = $max['alumno'];
        //$resultado[$nombreMateria]['max']['nota'] = $max['nota'];
        
        
    }
    return array ('modulos' => $resultado, 'alumnos' => $alumnos);
}



include 'views/templates/header.php';
include 'views/calcNotas.FranFernandez.view.php';
include 'views/templates/footer.php';

