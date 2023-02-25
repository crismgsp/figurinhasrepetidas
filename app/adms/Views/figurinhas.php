<?php

if(isset($this->data['form'])) {
    $valorForm = $this->data['form'];
    
}

?>

<html lang="pt-br>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Figurinhas 2022</title>
        <link rel="stylesheet" href="<?php echo URLADM; ?>app/adms/assets/reset.css">
		<link rel="stylesheet" href="<?php echo URLADM; ?>app/adms/assets/estilo.css">
        
        
    </head>
    <body>    
        
    <br>
    <h1>Troca de Figurinhas em João Monlevade</h1>
    
    <br>
    
        <div class="menu">
           
            <a href="<?php echo URLADM; ?>figurinhas/index"> <button class="botao"> Cadastrar figurinha </button></a>
            <a href="<?php echo URLADM; ?>buscar/index"> <button class="botao">Pesquisar figurinha </button> </a>
            <a href="<?php echo URLADM; ?>todasfigurinhas/index"> <button class="botao">Todas figurinhas</button> </a>
            <a href="<?php echo URLADM; ?>logout/index"> <button class="botao">Logout</button> </a>

        </div>

        <br>

        
        <div class="wrapper">
            <div class="row">
                <div class="top-list">
                    <span class="tituloprojeto"> Cadastre suas figurinhas  </span>
                    
                </div>

                <div class="content-adm-alert">
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <span id="msg"></span>
                </div>

               <?php
                  $nome = $_SESSION['nome'];
               ?>

                <div class="content-adm">
                    <form method="POST" action="" id="form-add-figurinha" class="form-adm">
                                                    
                       
                        <div class="row-input">
                            <div class="col-sm-10">
                                <?php 
                                $codigo = "";
                                if(isset($valorForm['codigo'])){
                                    $codigo = $valorForm['codigo'];
                                    }
                                ?>
                                    <label class="title-input">Código: </span></label>
                                    <input type="text" name="codigo" id="codigo" class="input-adm" placeholder="Digite o código da figurinha" value="<?php echo $codigo; ?>"
                                    required>
                            </div>
                            
                        </div>    
                        <br>
                       
                        

                        <button type="submit" name="SendAddFigurinha" class="btn-success" value="Cadastrar">Cadastrar</button>
                            
                            
                    </form>

                       
                </div>
            </div>
        </div>
    </body>    