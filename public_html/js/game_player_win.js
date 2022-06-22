var myGameArea
var linhas = [];
var labelSeg = [];
var multipTxt;
var multipVal = 1;
var intervalo = 0;
var tempo = 0;
var logo;

var multStop = 1;
var multStep = 0;

var crash = 0;

var width = 530; //350
var height = 377; //249

var timerObj;
var timerVal = 6;
var timerSize = 320;

var jogadorSts = "inativo";
var jogadorVal = 0;
var jogadorRet = 0;
var jogadorSal = 500;
var jogadorSto = 0;

var casaPerda = 0;
var casaGanho = 0;
var casaSts = "ganhou";

$(document).ready(function(){
    verificaMobile();
    
    if(isMobile){
        width = 350;
        height = 249;
    }
  
    myGameArea = {
        canvas : document.getElementById("game"),
        start : function() {
            this.canvas.width = width;
            this.canvas.height = height;
            this.context = this.canvas.getContext("2d");
            document.body.insertBefore(this.canvas, document.body.childNodes[0]);
            this.frameNo = 0;
            this.interval = setInterval(updateGameArea, 25);
            },
        clear : function() {
            this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
        }
    }
    
    $.post("rocket_crash.php", function(data){
        let dt = data.split("/");
        multipVal = parseFloat(dt[0]);
        console.log("Atual: "+multipVal);
        crash = parseFloat(dt[1]);
        console.log("Crash: "+crash);
        
        if(crash == 0){
            $('.timer').css({'display':'block'});
            timerVal = 6;
            timerObj = setInterval('timer()',10);
        }else{
            timerVal = 0;
            clearInterval(timerObj);
            $('.timer').css({'display':'none'});
            $('.btComJogo').prop("disabled",true);
            startGame();
        }
    });
    
});

function jogar(){
    jogadorSts = "ativo";
    jogadorVal = $('.aposVal').val();
                 $('.aposVal').val('');
    jogadorRet = $('.aposRet').val();
                 $('.aposRet').val('');
    
    $('.btComJogo').css({'display':'none'});
    $('.btPararJogo').css({'display':'block'});
    $('.btPararJogo').val("Parar: "+jogadorVal);
    $('.btAguardeJogo').css({'display':'none'});
}

function parar(){
    jogadorSts = "aguardando";
    casaSts = "perdeu";
    
    jogadorSal += jogadorVal*multipVal;
    
    casaPerda += (jogadorVal*multipVal) - jogadorVal;
    
    $('.aviso').html(multipVal.toFixed(2)+"X <span>WIN "+(jogadorVal*multipVal).toFixed(2)+"</span>");
    $('.aviso').removeClass('crashed');
    $('.aviso').addClass('winner');
    $('.aviso').css({'display':'block'});
    
    $('.btComJogo').css({'display':'none'});
    $('.btPararJogo').css({'display':'none'});
    $('.btAguardeJogo').css({'display':'block'});
    
     $.post("rocket_player_win.php", function(data){
         $("b.saldo").html(data);
     }
}

function timer(){
    timerVal-= 0.01;
    timerSize-=0.6;
    $('.timer b').html(timerVal.toFixed(2)+"s");
    $('.timer b').css({'width':timerSize+'px'});
    
    $('.btComJogo').prop("disabled",false);
    
    if(timerVal<=0){
        timerVal = 0;
        clearInterval(timerObj);
        $('.timer').css({'display':'none'});
        $('.btComJogo').prop("disabled",true);
        
        $.post("rocket_crash.php", function(data){
            let dt = data.split("/");
            multipVal = parseFloat(dt[0]);
            console.log("Atual: "+multipVal);
            crash = parseFloat(dt[1]);
            console.log("Crash: "+crash);
            
            startGame();
        });
    }
}

function startGame() {
    logo = new component(80, 80, "red", -80, (height-40), 'logo');
    multipTxt = new component("30px", "Consolas", "black", (width/2.3), (height/2), "text");
    
    labelSeg.push(new component("16px", "Consolas", "black", 50, (height-12), "text"));
    labelSeg[labelSeg.length-1].text = "0s";
    labelSeg.push(new component("16px", "Consolas", "black", (width/2.5), (height-12), "text"));
    labelSeg[labelSeg.length-1].text = "2s";
    labelSeg.push(new component("16px", "Consolas", "black", (width/1.5), (height-12), "text"));
    labelSeg[labelSeg.length-1].text = "4s";
    
    myGameArea.start();
}

function component(width, height, color, x, y, type) {
    this.type = type;
    this.score = 0;
    this.width = width;
    this.height = height;
    this.speedX = 0;
    this.speedY = 0;    
    this.x = x;
    this.y = y;
    this.gravity = 0;
    this.gravitySpeed = 0;
    
    this.update = function() {
        let ctx = myGameArea.context;
        if(this.type == "text"){
            ctx.font = this.width + " " + this.height;
            ctx.fillStyle = color;
            ctx.fillText(this.text, this.x, this.y);
        }else if(this.type == "logo"){
            let img = document.getElementById("logo");
            ctx.drawImage(img, this.x, this.y, this.width, this.height);
            
        }else{
            ctx.fillStyle = color;
            ctx.fillRect(this.x, this.y, this.width, this.height);
        }
    }
    
    this.newPos = function() {
        this.gravitySpeed += this.gravity;
        this.x += this.speedX;
        this.y += this.speedY + this.gravitySpeed;
        this.hitBottom();
    }
}

function updateGameArea() {
    if(timerVal == 0){
        myGameArea.clear();
        myGameArea.frameNo += 1;

        intervalo += 100;
        tempo = intervalo/1000;

        if (myGameArea.frameNo == 1 || everyinterval(100)) {
            linhas.push(new component(width, 1, "#333333", 0, 0));
        }
        if (myGameArea.frameNo == 1 || everyinterval(100)) {
            if(multStop <= multStep){
                //if(tempo >= 5){
                    labelSeg.push(new component("16px", "Consolas", "black", width, (height-12), "text"));
                    labelSeg[labelSeg.length-1].text = tempo+"s";

                    multStep = 0; 
                //}
            }
            multStep++;
        }

        let speed = 0.25;
        for (let i = 0; i < labelSeg.length; i += 1) {
            if(tempo > 5){
                labelSeg[i].x += -speed;
                speed += 0.25
            }
            labelSeg[i].update();
        }
        for (let i = 0; i < linhas.length; i += 1) {
            linhas[i].y += 1;
            linhas[i].update();
        }

        if(logo.x < myGameArea.canvas.width-(logo.width)){
          logo.x += 5;
        }
        if(logo.y > 0){
          logo.y -= 3.2;
        }
        logo.update();
        
        if(multipVal <= 2){
            multipVal += 0.003125
        }else if(multipVal <= 4){
            multipVal += 0.005;
        }else if(multipVal <= 6){
            multipVal += 0.010;
        }else if(multipVal <= 50){
            multipVal += 0.020;
        }else{
            multipVal += 0.050
        }
        multipTxt.text = multipVal.toFixed(2)+"X";
        multipTxt.update();
        
        $('.btPararJogo').val("Parar: "+(jogadorVal*multipVal).toFixed(2));

        if(multipVal > crash){
            clearInterval(myGameArea.interval);
            //-------------------------------------
            if(jogadorSts == "ativo"){
                jogadorSal -= jogadorVal;
                
                casaGanho += jogadorVal;
                casaSts = "ganhou";
                
                $('.aviso').html(multipVal.toFixed(2)+"X <span>CRASHED</span>");
                $('.aviso').addClass('crashed');
                $('.aviso').removeClass('winner');
                $('.aviso').css({'display':'block'});
            }else if(jogadorSts == "inativo"){
                $('.btComJogo').css({'display':'block'});
                $('.btPararJogo').css({'display':'none'});
                $('.btAguardeJogo').css({'display':'none'});
            }
            //-------------------------------------
            $('.jogosAnteriores ul li').first().remove();
            if(casaSts == "perdeu"){
                $('.jogosAnteriores ul').append('<li style="margin: 0 0 0 3px;background-color: #8bc34a;">'+multipVal.toFixed(2)+'x</li>');
            }else{
                $('.jogosAnteriores ul').append('<li style="margin: 0 0 0 3px;">'+multipVal.toFixed(2)+'x</li>');
            }
            //-------------------------------------
            setTimeout(function(){
                clearGame();
            },3000);
            
        }
    }
}

function clearGame(){
    jogadorSts = 'inativo';
    jogadorVal = 0;
    jogadorRet = 0;

    multipVal = 0;
    timerVal = 6;
    timerSize = 320;

    linhas = [];
    labelSeg = [];
    multipVal = 1;
    intervalo = 0;
    tempo = 0;

    casaSts = 'ganhou';

    logo.width = -80;
    logo.height = -40;

    timerObj = setInterval('timer()',10);
    $('.aviso').css({'display':'none'});
    $('.timer').css({'display':'block'});

    $('.btComJogo').css({'display':'block'});
    $('.btPararJogo').css({'display':'none'});
    $('.btAguardeJogo').css({'display':'none'});

    console.log("Casa Ganho:"+casaGanho+" | Casa Perda:"+casaPerda);
    console.log("Casa Ganho %:"+(casaGanho/(casaGanho+casaPerda))*100);
}

function everyinterval(n) {
    if ((myGameArea.frameNo / n) % 1 == 0) {return true;}
    return false;
}