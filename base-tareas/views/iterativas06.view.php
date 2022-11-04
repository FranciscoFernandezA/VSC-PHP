<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Iterativas 06</h1>

</div>
<!-- Content Row -->

<div class="row">
    <?php
    if(isset($data['resultado'])){
    ?>
    <div class="col-12">
        <div class="alert alert-success">
            <?php            
                echo implode(", ", $data['resultado']);
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
                <h6 class="m-0 font-weight-bold text-primary">Criba de Erastótenes</h6>                                    
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <form method="post" action="./?sec=iterativas06">
                    <!--<input type="hidden" name="sec" value="iterativas01" />-->
                    <div class="mb-3">
                        <label for="texto">Número máximo:</label>
                        <input class="form-control" type="number" name="numero" id="numero" placeholder="Inserte el número máximo" value="<?php echo isset($data['input']['numero']) ? $data['input']['numero'] : ''; ?>">
                        <p class="text-danger small"><?php echo isset($data['errores']['numero']) ? $data['errores']['numero'] : ''; ?></p>
                    </div>                    
                    <div class="mb-3">
                        <input type="submit" value="Enviar" name="enviar" class="btn btn-primary"/>
                    </div>
                </form>
            </div>
        </div>
    </div>                        
</div>
