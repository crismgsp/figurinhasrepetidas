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
        
    <div class="titulo">
        <br>
    <h1>Troca de Figurinhas em João Monlevade</h1>
    </div> 
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

    <div id="todas">  
        <h2>Todas figurinhas cadastradas:</h2>
    
       
        <br>

    
        <?php
        $figurinhas = $this->data['figurinhas']['figurinhas'];
        //var_dump($figurinhas);
        ?>

                
                                                    
        <?php foreach($figurinhas as $figurinha)
            { ?>
                                                        
                <p value="<?php echo $figurinha['id']; ?>"><?php echo  $figurinha['codigo'] . " " . "-". " " .  $figurinha['nome']?>
                <button> <?php echo "<a class='ref' href=' " . URLADM . "deletefigurinha/index/{$figurinha['id']}'>Apagar</a>"; ?></button> </p>
                 <br>
                

            <?php
            } ?>
                                                    
    </div>                                              
            