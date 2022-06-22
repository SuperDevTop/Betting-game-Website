    <?php
    if(isset($_GET['sair'])){
        $_SESSION['mr_cod'] = '';
        $_SESSION['mr_usuario'] = '';
        $_SESSION['mr_nome'] = '';
        session_unset();
        header("location:/");
    }
    ?>
    <header>
        <img class="logo" src="/img/ico.png" alt="logo">
        <span class="namelogo">million rocket</span>
        <?php if($mr_u != null){?>
        <?php
            $conn->consultar("SELECT * FROM usuarios WHERE email = '$mr_u'");
            $saldo = $conn->escrever();
            $saldo = $saldo['saldo'];
        ?>
        <i class="btUser fa fa-user"></i>
        <ul class="userMenu">
            <li><?php echo $_SESSION['nome'];?></li>
            <li>Conta</li>
            <li><a href="/depositar">Depositar</a></li>
            <li><a href="/saque">Sacar</a></li>
            <li><a href="/saque/historico">Histórico</a></li>
            <li><a href="?sair">Sair</a></li>
        </ul>
        <a class="btAddCash" href="/deposito">Depositar</a>
        <div class="cash">
            R$ <b class="saldo"><?php echo $saldo;?></b>
            <i class="fa fa-caret-square-o-down"></i>
            <div class="cashbox">
                <i class="fas fa-coin"></i>Saldo R$<b class="saldo"><?php echo $saldo;?></b>
                <p>Saldo Atual: R$<b class="saldo"><?php echo $saldo;?></b> BRL</p>
                <p>(R$<b class="saldo"><?php echo $saldo;?></b> + R$0 Dinheiro de Bônus)</p>
                <a href="/bonus">VER BÔNUS ATIVOS</a>
            </div>
        </div>
        <i class="btCompartilhar fa fa-share-alt"></i>
        <div class="share">
            <b>millionrocket.com/promo/<?php echo $_SESSION['mr_usuario'];?></b>
            <p>Compartilhe e ganhe R$25,00.<p>
            <i>Para ganhar seu bonûs a pessoa convidade deve concluir o cadastro e fazer um depósito</i>
        </div>
        <?php }?>
    </header>