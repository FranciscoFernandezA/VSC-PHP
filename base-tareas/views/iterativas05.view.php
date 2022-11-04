<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Iterativas 05</h1>

</div>
<!-- Content Row -->

<div class="row">
    <?php
    if(isset($data['resultado'])){
    ?>
    <div class="col-12">
        <div class="alert alert-success">
            <?php            
            $primera = true;
            foreach($data['resultado'] as $palabra => $num){
                if($primera){
                    echo "$palabra: $num";
                }
                else{
                    echo ", $palabra: $num";
                }
                $primera = false;
            }
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
                <h6 class="m-0 font-weight-bold text-primary">Contador palabras</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <form method="post" action="./?sec=iterativas05">
                    <!--<input type="hidden" name="sec" value="iterativas01" />-->
                    <div class="mb-3">
                        <label for="texto">Contador de palabras:</label>
                        <textarea class="form-control" name="texto" id="texto" rows="10" placeholder="Inserte el texto a analizar"><?php echo isset($data['input']['texto']) ? $data['input']['texto'] : ''; ?></textarea>                        
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
