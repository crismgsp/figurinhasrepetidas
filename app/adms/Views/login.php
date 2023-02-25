<?php


if (isset($this->data['form'])) {
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

    <div class="container-login">
        <div class="wrapper-login">

            <div class="title">
                <span>Faça seu login</span>
            </div>

            <div class="msg-alert">
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo "<span id='msg'> " . $_SESSION['msg'] . "</span>";
                        unset($_SESSION['msg']);
                    } else {
                        echo "<span id='msg'></span>";
                    }
                    ?>
                    
                </div>

            <form method="POST" action="" id="form-login" class="form-login">            

                <?php
                $nome = "";
                if (isset($valorForm['nome'])) {
                    $nome = $valorForm['nome'];
                }
                ?>
                <div class="row">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nome" id="nome" placeholder="Digite o usuário" value="<?php echo $nome; ?>" required>
                </div>

                <?php
                $senha = "";
                if (isset($valorForm['senha'])) {
                    $senha = $valorForm['senha'];
                }
                ?>
                <div class="row">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="senha" id="senha" placeholder="Digite a senha" autocomplete="on" value="<?php echo $senha; ?>" required>
                </div>

                <div class="row button">
                    <button type="submit" name="SendLogin" value="Acessar">Acessar</button>
                </div>

                

            </form>

        </div>
    </div>

</body>    