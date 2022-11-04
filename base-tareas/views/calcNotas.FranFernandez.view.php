<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Calculo Notas</h1>

</div>

<div class="row">
    <?php
    if(isset($data['resultado'])){
    ?>
        <div class="col-12 col-lg-12">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Resultados por módulo</h6>                                    
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <table class="table table-striped" >
                        <thead>
                            <tr>
                                <th>Módulo</th>
                                <th>Media</th>
                                <th>Aprobados</th>
                                <th>Suspensos</th>
                                <th>Máximo</th>
                                <th>Mínimo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($data['resultado']['modulos'] as $nombreModulo => $datosModulo){
                            ?>
                            <tr>
                                <td><?php echo ucfirst($nombreModulo); ?></td>
                                <td><?php echo number_format($datosModulo['media'], 2, ',', '.'); ?></td>
                                <td><?php echo $datosModulo['aprobados']; ?></td>
                                <td><?php echo $datosModulo['suspensos']; ?></td>
                                <td><?php echo $datosModulo['max']['alumno'].': '.$datosModulo['max']['nota']; ?></td>
                                <td><?php echo $datosModulo['min']['alumno'].': '.$datosModulo['min']['nota']; ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
    if(isset($data['resultado'])){
    ?>
    <!--Para parte 2 -->
     <!--Aprueban todo -->
    <div class="col-lg-6 col-12">
        <div class="alert alert-success">
            <ol>
                Aprueban todo:
            <?php 
            foreach($resultado['alumnos'] as $nombre => $datos){
                if($datos['suspensos'] == 0){
                    echo "<li>$nombre</li>";
                }
            }
            ?>
            </ol>
        </div>
    </div>
     <!--Suspenden 1-->
    <div class="col-lg-6 col-12">
        <div class="alert alert-primary ">
            <ol>
                Suspenden una:
            <?php 
            foreach($resultado['alumnos'] as $nombre => $datos){
                if($datos['suspensos'] == 1){
                    echo "<li>$nombre</li>";
                }
            }
            ?>
            </ol>
        </div>
    </div>
         <!--Suspenden 1 o mas-->
    <div class="col-lg-6 col-12">
        <div class="alert alert-warning ">
            <ol>
                Suspenden una o más:
            <?php 
            foreach($resultado['alumnos'] as $nombre => $datos){
                if($datos['suspensos'] >= 1){
                    echo "<li>$nombre</li>";
                }
            }
            ?>
            </ol>
        </div>
    </div>
     <!--Repiten-->
    <div class="col-lg-6 col-12">
        <div class="alert alert-danger">
            <ol>
                Repiten curso:
            <?php 
            foreach($resultado['alumnos'] as $nombre => $datos){
                if($datos['suspensos'] > 1){
                    echo "<li>$nombre</li>";
                }
            }
            ?>
            </ol>
        </div>
    </div>
    <?php
    }
    ?>
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Array de notas</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <form method="post" action="./?sec=calcNotas.FranFernandez">
                    <!--<input type="hidden" name="sec" value="iterativas01" />-->
                    <div class="mb-3">
                        <label for="texto">Json Notas:</label>
                        <textarea class="form-control" id="json_notas" name="json_notas" rows="10"><?php echo isset($data['input']['json_notas']) ? $data['input']['json_notas'] : '';?></textarea>
                        <p class="text-danger small"><?php echo isset($data['errores']['json_notas']) ? $data['errores']['json_notas'] : ''; ?></p>
                    </div>                    
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>
