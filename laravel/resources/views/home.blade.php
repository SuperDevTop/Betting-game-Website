@extends('layouts.app')

@section('content')
<div class="container">
    <div class="gameScreen">
        <div class="timer"><b>6s</b></div>
        <div class="btJogoNormal">Normal</div>
        <div class="btJogoAuto">Auto</div>
        <form class="aposta">
            <input type="number" step="0.01" min="1" max="100" placeholder="Quantia" pattern="[0-9]+" class="aposVal" onClick="this.value = ''" required>
            <input type="button" value="2x" class="btMini" id="btDobrar">
            <input type="button" value="1/2" class="btMini" id="btMetade">
            <input type="number" step="0.01" min="1.5" placeholder="Auto Retirar" pattern="[0-9]+" class="aposRet" onClick="this.value = ''">
            <input type="button" value="Começar o Jogo" onClick="jogar();" class="btComJogo">
            <input type="button" value="Parar" onClick="parar();" class="btPararJogo">
            <input type="button" value="Aguarde..." class="btAguardeJogo">
        </form>
        <div class="avisoWin"><b>1X</b><span>Winner</span></div>
        <div class="avisoCrash"><b>1.10X</b><span>CRASHED</span></div>
        <canvas id="game"></canvas>
        <div class="jogosAnteriores">
            <ul>
                
            </ul>
        </div>
        <div class="playersOn">
            <ul>
                <li>
                    <span>Jogador</span>
                    <span>Valor</span>
                    <span>Multiplicador</span>
                    <span>Lucro</span>
                </li>
                <li>
                    <span>Jogador</span>
                    <span>Valor</span>
                    <span>Multiplicador</span>
                    <span>Lucro</span>
                </li>
                <li>
                    <span>Jogador</span>
                    <span>Valor</span>
                    <span>Multiplicador</span>
                    <span>Lucro</span>
                </li>
                <li>
                    <span>Jogador</span>
                    <span>Valor</span>
                    <span>Multiplicador</span>
                    <span>Lucro</span>
                </li>
                <li>
                    <span>Jogador</span>
                    <span>Valor</span>
                    <span>Multiplicador</span>
                    <span>Lucro</span>
                </li>
                <li>
                    <span>Jogador</span>
                    <span>Valor</span>
                    <span>Multiplicador</span>
                    <span>Lucro</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
