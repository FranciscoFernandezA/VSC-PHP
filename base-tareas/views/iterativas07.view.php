<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Iterativas 07</h1>

</div>
<!-- Content Row -->

<div class="row">
    <?php
    if($data['finalizado']){
    ?>
    <div class="col-12">
        <div class="alert alert-success">
            ¡Has ganado!
        </div>
    </div>
    <?php
    }
    if(isset($data['bingo'])){
    ?>
    <div class="col-12">
        <div class="alert alert-info">
            <?php            
                echo implode(", ", $data['bingo']);
            ?>
        </div>
    </div>
    <?php
    }    
    ?>    
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Bingo</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <?php 
                if(isset($data['carton'])){
                ?>
                <div class="col-12">
        
                    <table class="table table-bordered">
                        <tr>
                        <?php
                        $contador = 0;
                        foreach($data['carton'] as $num){
                            if($contador % 5 == 0 && $contador != 0 ){
                                echo '</tr><tr>';
                            }
                            if(!in_array($num, $data['no_salieron'])){
                                echo "<td class=\"text-center text-success\">$num</td>";
                            }
                            else{                                
                                echo "<td class=\"text-center\">$num</td>";
                            }
                            $contador++;
                        }
                        ?>
                        </tr>
                    </table>

                </div>
                <?php 
                }
                ?>
                <!--<form action="./?sec=formulario" method="post">                   -->
                <form method="post" action="./?sec=iterativas07">
                    <!--<input type="hidden" name="sec" value="iterativas01" />-->
                    <div class="mb-3">                        
                        <input type="hidden" class="form-control" name="bingo_anterior" id="bingo_anterior" value="<?php echo isset($data['bingo']) ? base64_encode(json_encode($data['bingo'])) : ''; ?>" />
                        <input type="hidden" class="form-control" name="carton" id="carton" value="<?php echo isset($data['carton']) ? base64_encode(json_encode($data['carton'])) : ''; ?>" />
                        <p class="text-danger small"><?php echo isset($data['errores']['texto']) ? $data['errores']['texto'] : ''; ?></p>
                    </div>                    
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>
