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

            <div class="content-adm-alert">
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <span id="msg"></span>
                </div>

            <div class="top-list">
            <form method="POST" action="">
                <?php
                    $search_name = "";
                    if(isset($valorForm['search_name'])){
                        $search_name = $valorForm['search_name'];
                    } ?>
                <div class="row-input-search">
                    <div class="column">
                        <label class="title-input-search">Nome: </label>
                        <input type="text" name="search_name" id="search_name" class="input-search"
                            placeholder="Pesquisar figurinhas pelo nome do usuario" value="<?php echo $search_name; ?>">
                    </div>
                    <br>
                    <?php
                    $search_figurinha = "";
                    if(isset($valorForm['search_figurinha'])){
                        $search_figurinha = $valorForm['search_figurinha'];
                    } ?>
                    

                    <div class="column">
                        <label class="title-input-search">Figurinha: </label> <br>
                        <input type="text" name="search_figurinha" id="search_figurinha" class="input-search"
                            placeholder="Pesquisar pelo código da figurinha" value="<?php echo $search_figurinha; ?>">
                    </div>
                    <br>

                    <div class="column margin-top-search">
                        <button type="submit" name="SendSearchUser" class="btn-info" value="Pesquisar">Pesquisar</button>
                    </div>
                </div>
            </form>
        </div>  
        
        <div>
        <?php 
            $figurinhas =  $this->data;
            

        ?>

        </div>

        <div id="todas">  
            <?php 
            if(!empty($figurinhas)){
                foreach($figurinhas as $figurinha)
                { ?>
                                                            
                    <p value="<?php echo $figurinha['id']; ?>"><?php echo  $figurinha['codigo'] . " " . "-". " " .  $figurinha['nome']?>
                    <button> <?php echo "<a class='ref' href=' " . URLADM . "deletefigurinha/index/{$figurinha['id']}'>Apagar</a>"; ?></button> </p>
                    <br>
                    

                <?php
                } ?>
                <?php
            } ?>
        </div>


    </body>    