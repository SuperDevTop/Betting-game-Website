<?php
function autoload($class){
	$raiz = $_SERVER['DOCUMENT_ROOT'];
	include_once $raiz."/stage/class/".$class.".class.php";
}

spl_autoload_register("autoload");

$conn = new Conexao();
?>



<?php $__env->startSection('css'); ?>

<style type="text/css">

    .list_card{
        padding: 30px 20px 20px 20px;
        background-color: rgb(30,30,30);
        margin-top: 20px;
        border-radius: 5px;
    }

    .list_card h3{
        color: white;
    }

    .list_card table th{

        background-color: rgb(40,40,40);

        font-size: 15px;

        color: white;

    }

    .list_card table td{

        color: white;

        font-size: 14px;

    }

    .list_card a{

        color: #3c90df;

    }

    .list_card a:hover{

        color: white !important;

    }



    .inform_card{

        padding: 30px 20px 20px 20px;

        background-color: rgb(30,30,30);

        margin-top: 20px;

        border-radius: 5px;

    }

    .inform_card h3{

        color: white;

        margin-bottom: 5px;

    }

</style>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<div class="container">

    <div class="inform_card">

        <h3>

            <i class="fa fa-bell" style="color:#ffb119;"></i>
            
            <?php
            $cod = Auth::user()->id;
            $perRef = Auth::user()->referral_rate;
            $perRef = $perRef/100;
            
            echo $cod;
            ?>

            Sua taxa de referência é atualmente <span style="color:#82b54b;"><?php echo e(Auth::user()->referral_rate); ?>%</span>
        </h3>
        <h3 style="text-align: right; font-size: 1rem;">
            Período:
            <form>
            <input type="date" name="inicio" onChange="dataMin(this.value)" style="text-align: center; border: 0; border-radius: 5px; padding: 3px;">
			<input type="time" name="iniciohora" value="12:00" style="text-align: center; border: 0; border-radius: 5px; padding: 3px;">
			 | 
            <input type="date" name="fim" id="dtMax" style="text-align: center; border: 0; border-radius: 5px; padding: 3px;">
            <input type="time" name="fimhora" value="12:00" style="text-align: center; border: 0; border-radius: 5px; padding: 3px;">
			<input type="submit" value="Filtrar" style="color: #fff; background-image: linear-gradient(0deg,#283D71,#466DA5); border-radius: 5px; padding: 4px 12px; border: 0;">
            </form>
            <script>
                function dataMin(dt){
                    document.getElementById("dtMax").setAttribute("min", dt);
                }
            </script>
        </h3>
    </div>
    
    <?php
    #-> Total depósitos
    $sql = "SELECT SUM(transactions.amount) as total FROM transactions INNER JOIN users ON transactions.to = users.id WHERE transactions.type='deposit' AND transactions.status = 'complete' AND users.affiliate_id = $cod ORDER BY transactions.id DESC";
    $conn->consultar($sql);
    $dados = $conn->escrever();
    $totaldeposito = $dados['total'];
    $totaldeposito = $totaldeposito*$perRef;
    
    #-> Total Saques
    $sql = "SELECT SUM(amount) as total FROM referral_withdraws WHERE referral_withdraws.status != 'Canceled' AND id_affiliate = $cod";
    $conn->consultar($sql);
    $dados = $conn->escrever();
    $totalsaque = $dados['total'];
    
    #-> Total final
    $totalfinal = $totaldeposito - $totalsaque;
    ?>
    
    <div class="inform_card">
        <h3>
            <i class="fa fa-monney" style="color:#ffb119;"></i>
            Seu saldo para saque é de: R$ <?php echo number_format($totalfinal,2,',','.')?>
        </h3>
        <p style="text-align: right;">Ganhos: R$<?php echo number_format($totaldeposito,2,',','.')?> | Saques: R$ <?php echo number_format($totalsaque,2,',','.')?></p>
        <a href="/transacoes/saque/afiliado" style="float:right; color: #fff; background-image: linear-gradient(0deg,#283D71,#466DA5); border-radius: 5px; padding: 4px 12px; border: 0; margin-top:-24px;">Solicitar Saque</a>
    </div>
    
    <div class="inform_card">
        <h3>
            <i class="fa fa-monney" style="color:#ffb119;"></i>
            Saques efetuados
        </h3>
        <table class="table table-vcenter">
            <thead>
                <tr>
                    <th style="width: 150px;">Data Saque</th> <!-- Data -->
                    <th style="width: 200px">Valor</th> <!-- Valor -->
                    <th style="width: 150px">Status</th> <!-- Valor -->
                </tr>
            </thead>
            <tbody>

                <?php
                $sql = "SELECT * FROM referral_withdraws WHERE id_affiliate = $cod ORDER BY id DESC";
                $conn->consultar($sql);
                while($dados = $conn->escrever()){
                ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i', strtotime($dados['date']));?></td>
                    <td>R$ <?php echo number_format($dados['amount'],2,',','.')?></td>
                    <td><?php echo $dados['status'];?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

    <div class="list_card" style="overflow: auto;">
        <?php
        $sql = "SELECT * FROM users WHERE users.affiliate_id = $cod ";
        if(isset($_GET['inicio'])){
            if($_GET['inicio'] != ''){
                $dtIni = $_GET['inicio'];
                $dtFim = $_GET['fim'];
				$hIni = $_GET['iniciohora'];
                $hFim = $_GET['fimhora'];
				
                $sql = "SELECT * FROM users WHERE users.affiliate_id = $cod AND updated_at >= '$dtIni' AND updated_at <= '$dtFim 23:59:59'";
                $sql = "SELECT * FROM transactions INNER JOIN users ON transactions.to = users.id WHERE transactions.type='deposit' AND transactions.status = 'complete' AND users.affiliate_id = $cod AND transactions.updated_at >= '$dtIni $hIni' AND transactions.updated_at <= '$dtFim $hFim' ORDER BY transactions.id DESC";
            }
        }
        $conn->consultar($sql);
        $cadastros = $conn->nResultados();

        $sql = "SELECT * FROM transactions INNER JOIN users ON transactions.to = users.id WHERE transactions.type='deposit' AND transactions.status = 'complete' AND users.affiliate_id = $cod ORDER BY transactions.id DESC";
        if(isset($_GET['inicio'])){
            if($_GET['inicio'] != ''){
                $dtIni = $_GET['inicio'];
                $dtFim = $_GET['fim'];
                $sql = "SELECT * FROM transactions INNER JOIN users ON transactions.to = users.id WHERE transactions.type='deposit' AND transactions.status = 'complete' AND users.affiliate_id = $cod AND transactions.updated_at >= '$dtIni' AND transactions.updated_at <= '$dtFim 23:59:59' ORDER BY transactions.id DESC";
            }
        }
        $conn->consultar($sql);
        $dados = $conn->escrever();
        $cadastroscomdeposito = $conn->nResultados();
        ?>

        <h3 class="bold">
            Total de Cadastrados
            <span style="float:right;"><?php echo $cadastros;?></span>
        </h3>
        <h3 class="bold">
            Cadastrados com depósito
            <span style="float:right;"><?php echo $cadastroscomdeposito;?></span>
        </h3>

        <table class="table table-vcenter">

          <thead>

                <tr>

                    <th style="width: 15%;">Data Depósito</th> <!-- Data -->

                    <th style="width: 35%;">Nome</th> <!-- Nome -->

                    <th style="width: 35%;">Email</th> <!-- Email -->

                    <th style="width: 20%;">Ganho</th> <!-- Earning -->

                </tr>

          </thead>

            <tbody>

                <?php
                $sql = "SELECT * FROM transactions INNER JOIN users ON transactions.to = users.id WHERE transactions.type='deposit' AND transactions.status = 'complete' AND users.affiliate_id = $cod ORDER BY transactions.id DESC";
                
                if(isset($_GET['inicio'])){
                    if($_GET['inicio'] != ''){
                        $dtIni = $_GET['inicio'];
                        $dtFim = $_GET['fim'];
                        $sql = "SELECT * FROM transactions INNER JOIN users ON transactions.to = users.id WHERE transactions.type='deposit' AND transactions.status = 'complete' AND users.affiliate_id = $cod AND transactions.updated_at >= '$dtIni' AND transactions.updated_at <= '$dtFim' ORDER BY transactions.id DESC";
                    }
                    
                }
                
                $conn->consultar($sql);

                while($dados = $conn->escrever()){
                ?>
                <tr>
                    <td><?php echo date('d/m/Y H:i', strtotime($dados['created_at']));?></td>
                    <td><?php echo $dados['full_name']?></td>
                    <td><?php echo $dados['email']?></td>
                    <td>R$ <?php echo number_format($dados['amount']*$perRef,2,',','.')?></td>
                </tr>
                <?php }?>
            </tbody>

        </table>

    </div>

</div>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('js'); ?>

<script type="text/javascript">



</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>