var betting_type = "normal";
var is_auto = false;
var game_thread;
var game_status = "pending";
var pending_time = 5;
var point = 1.00;
var current_time = 0;
var graph_width;
var graph_height;
var GameArea = document.getElementById("game");
var ctx = GameArea.getContext("2d");

var is_betted = false;
var is_placed = false;
var is_next_placed = false;
var bet_amount = 1.8;

var S_X;
var S_Y;

var E_X;
var E_Y;



getGameStatus();
window.addEventListener("focus", function(event) 
{ 
    getGameStatus();
}, false);


var img = new Image();
img.onload = function(){
	  
};
img.src = "front-assets/img/rocket-main-test.png"; 


// ====== Subscribe pusher



channel.bind('App\\Events\\StartCrashGame', start_game);
channel.bind('App\\Events\\CrashGamePlace', update_placed_users_list);
channel.bind('App\\Events\\EndCrashGame', end_game);

// =======================

function end_game(data)
{
	point = data.message.crash_point;
	game_status = "finish";
	$("#current_point").text(point.toFixed(2)+"X");
	showButton();
}
function update_placed_users_list(data)
{
	var play_list = data.message.place_list;
	var count = data.message.count;
	var total_amount = data.message.total_amount;

	$("#user_count").text(count);
	$("#total_amount").text("R$"+total_amount.toFixed(2));

	var append_list = "";
	play_list.forEach(function(user){
		var tr = "";
		tr += "<tr>";
		tr += "<td>" + user.full_name + "</td>";
		tr += "<td>R$ " + (user.user_bet_amount).toFixed(2) + "</td>";

		if (user.user_betting_point == 0)
			tr += "<td>" + "-" + "</td>";
		else 
			tr += "<td style='color:#82b54b;'>" + (user.user_betting_point).toFixed(2) + "</td>";

		if (user.user_earning == 0)
			tr += "<td>" + "-" + "</td>";
		else 
			tr += "<td style='color:#82b54b;'>R$" + (user.user_earning).toFixed(2) + "</td>";

		tr += "</tr>";
		append_list += tr;
	});

	$(".play_list table tbody").html(append_list);
}

function draw_pending_progress()
{
	if (current_time <= 500)
	{
		var width = (500 - current_time) / 500 * 100;
		$(".progress>div").attr("style","width:"+width+"%;");
		$(".progress span").text(((500 - current_time)/100).toFixed(2) + "s");
	}
}
function draw_graph()
{
	if (current_time > 100 * 1000) return;

	var time = current_time - 500;
	var width = GameArea.width;
	var height = GameArea.height;

	ctx.clearRect(0, 0, GameArea.width, GameArea.height);

	ctx.beginPath();

	ctx.lineWidth = 2;
	ctx.strokeStyle = "rgb(150,150,150)";
	ctx.moveTo(30, GameArea.height - 25);
	ctx.lineTo(GameArea.width - 20, GameArea.height - 25);


	var step = 3;
	var step_space = (width - 50) / step;
	var space = (width - 50) / (step * 2 * 100);
	var time_value;

	if (time > step * 200)
	{
		for (i = 0; i < step; i ++)
		{

			var current_position = 30 + i * step_space - ((time % 200) * space);

			if (current_position < 30)
			{
				current_position = width - 20 - ((time % 200) * space);
				time_value = parseInt(time / 100);
				time_value % 2 == 0 ? time_value = time_value : time_value = time_value - 1;
			}
			else
			{
				time_value = parseInt(time / 100);
				time_value % 2 == 0 ? time_value = time_value : time_value = time_value - 1;
				time_value -= (step - i) * 2;
			}

			ctx.font = "12px Arial";
			ctx.fillStyle = "rgb(150,150,150)";
			ctx.fillText(time_value + "s", current_position, GameArea.height - 10);
		}
	}
	else
	{
		for (i = 0; i <= step; i ++)
		{
			var current_position = 30 + i * step_space;
			
			ctx.font = "12px Arial";
			ctx.fillStyle = "rgb(150,150,150)";
			ctx.fillText(i * 2 + "s", current_position, GameArea.height - 10);
		}
	}

	ctx.stroke();


	ctx.beginPath();

	if (time > 600)
	{
		var end_value_y = Math.pow( 1 + 0.01 * ( (current_time - pending_time * 100) / 100), 8 );
		var start_value_y = Math.pow( 1 + 0.01 * ( (current_time - 600 - pending_time * 100) / 100), 8 );

		var first_time_y = parseInt( (current_time - pending_time * 100) / 100 );
		first_time_y % 2 == 0 ? first_time_y = first_time_y : first_time_y = first_time_y - 1;

		var first_y = Math.pow( 1 + 0.01 * (first_time_y), 8 ).toFixed(2);
		var second_y = Math.pow( 1 + 0.01 * (first_time_y-2), 8 ).toFixed(2);
		var third_y = Math.pow( 1 + 0.01 * (first_time_y-4), 8 ).toFixed(2);

		ctx.font = "12px Arial";
		ctx.fillStyle = "rgb(150,150,150)";
		ctx.fillText(first_y+"X", 10, (end_value_y - first_y) * (GameArea.height - 30) / (end_value_y - start_value_y) );

		ctx.lineWidth = 1;
		ctx.strokeStyle = "rgb(150,150,150)";
		ctx.moveTo(30, (end_value_y - first_y) * (GameArea.height - 30) / (end_value_y - start_value_y));
		ctx.lineTo(GameArea.width - 20, (end_value_y - first_y) * (GameArea.height - 30) / (end_value_y - start_value_y));


		ctx.font = "12px Arial";
		ctx.fillStyle = "rgb(150,150,150)";
		ctx.fillText(second_y+"X", 10, (end_value_y - second_y) * (GameArea.height - 30) / (end_value_y - start_value_y) );

		ctx.lineWidth = 1;
		ctx.strokeStyle = "rgb(150,150,150)";
		ctx.moveTo(30, (end_value_y - second_y) * (GameArea.height - 30) / (end_value_y - start_value_y));
		ctx.lineTo(GameArea.width - 20, (end_value_y - second_y) * (GameArea.height - 30) / (end_value_y - start_value_y));

		ctx.font = "12px Arial";
		ctx.fillStyle = "rgb(150,150,150)";
		ctx.fillText(third_y+"X", 10, (end_value_y - third_y) * (GameArea.height - 30) / (end_value_y - start_value_y) );

		ctx.lineWidth = 1;
		ctx.strokeStyle = "rgb(150,150,150)";
		ctx.moveTo(30, (end_value_y - third_y) * (GameArea.height - 30) / (end_value_y - start_value_y));
		ctx.lineTo(GameArea.width - 20, (end_value_y - third_y) * (GameArea.height - 30) / (end_value_y - start_value_y));
	}
	else
	{
		ctx.font = "12px Arial";
		ctx.fillStyle = "rgb(150,150,150)";
		ctx.fillText(1.17+"X", 10, GameArea.height / 3 * 2 );

		ctx.lineWidth = 1;
		ctx.strokeStyle = "rgb(150,150,150)";
		ctx.moveTo(30, GameArea.height / 3 * 2);
		ctx.lineTo(GameArea.width - 20, GameArea.height / 3 * 2);


		ctx.font = "12px Arial";
		ctx.fillStyle = "rgb(150,150,150)";
		ctx.fillText(1.36+"X", 10, GameArea.height / 3 * 1 );

		ctx.lineWidth = 1;
		ctx.strokeStyle = "rgb(150,150,150)";
		ctx.moveTo(30, GameArea.height / 3 * 1);
		ctx.lineTo(GameArea.width - 20, GameArea.height / 3 * 1);
	}

	ctx.stroke();


    if (time > 600)
	{
		ctx.beginPath();
		ctx.lineWidth = 5;
		ctx.strokeStyle = "#ffb119";
		ctx.moveTo(S_X, S_Y);
		ctx.lineTo(E_X, E_Y);
		ctx.stroke();

		ctx.beginPath();
		ctx.drawImage(img, E_X - 50, E_Y - 50, 100, 100);         
		ctx.stroke();
	}
	else
	{
		ctx.beginPath();
		ctx.lineWidth = 5;
		ctx.strokeStyle = "#ffb119";
		ctx.moveTo(S_X, S_Y);
		ctx.lineTo((E_X - S_X)/600*(time%600) + S_X, S_Y - (S_Y - E_Y)/600*(time%600));
		ctx.stroke();

		ctx.beginPath();
		ctx.drawImage(img, (E_X - S_X)/600*(time%600) + S_X - 50, S_Y - (S_Y - E_Y)/600*(time%600) - 50, 100, 100);       
		ctx.stroke();
	}
}


function start_game(data){

	setPastVariables(data.message.lastgames);
	$(".play_list table tbody").html("");
	$("#user_count").text(0);
	$("#total_amount").text("R$0");

	clearInterval(game_thread);

	current_time = 0;
	game_status = "pending";
	$(".end").hide();
	$(".progress").show();
	$(".win").hide();

	is_placed = false;
	is_betted = false;

	var total_auto = $("#total_auto").val();

	if (is_auto && total_auto != 0){
		is_next_placed = true;
		$("#total_auto").val(total_auto - 1);
	} 
	else{
		is_auto = false;
	}

    if (is_next_placed)	place_game();	
    else showButton();

	game_thread = setInterval(game_thread_fuc, 10);
}

function place_game()
{
	$.ajax({
        url:"/stage/place_crash_game",
        type:'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {amount:bet_amount},
        success:function(req) {
            var data = JSON.parse(req);
            if (data.message == "already placed"){
            	is_placed = true;
            	is_next_placed = false;
            	showButton();
            	$("#balance").text("R$ "+data.balance);

            	Dashmix.helpers('notify', {type: 'warning', icon: 'fa fa-exclamation mr-1', message: 'Você já fez uma aposta em outro dispositivo!'});
            }
            else if (data.message == "no enough money")
            {
            	Dashmix.helpers('notify', {type: 'warning', icon: 'fa fa-exclamation mr-1', message: 'Você não tem dinheiro suficiente em seu saldo. por favor, cobrar dinheiro.'});
            }
            else
            {
            	is_placed = true;
            	is_next_placed = false;
            	showButton();
            	$("#balance").text("R$ "+data.balance);
            }
        },
        error: function(ts) {
            console.log(ts);
        }
	});
}

function game_thread_fuc() {

	current_time ++;

	if (current_time == pending_time * 100){
	 	game_status = "playing";

	 	$(".progress").hide();
		$(".playing").show();

		showButton();
	}
	

	if (game_status == "pending")
	{
		draw_pending_progress();
	}

	if (game_status == "playing")
	{

		var current_point = Math.pow( 1 + 0.01 * ( (current_time - pending_time * 100) / 100), 8 ).toFixed(2);

		if (current_point > 500) game_status = "finish";

		draw_graph();
		
		
		if (current_point >= $("#betting_point").val() && !is_betted && is_auto)
		{
			is_betted = true;
			bet();
		}

		$("#current_point").text(current_point+"X");
		$("#get").text("PARAR AGORA - " + (current_point * bet_amount).toFixed(2));
	}

	if (game_status == "finish")
	{	
		draw_graph();
		clearInterval(game_thread);
		$("#crash_point").text(point.toFixed(2));
		$(".progress").hide();
		$(".playing").hide();
		$(".end").show();
	}
}


function getGameStatus() {
	$.ajax({
            url:"/stage/get_crash_game_status",
            type:'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {},
            success:function(req) {
                var data = JSON.parse(req);

                setPastVariables(data.lastgames);

                if (data.status != "nothing")
                {
	                clearInterval(game_thread);
	                $(".progress").hide();
					$(".playing").hide();
					$(".end").hide();

					current_time = data.time * 100;
					game_status = data.status;
					showButton();

					if (game_status == "pending") $(".progress").show();
					if (game_status == "playing") $(".playing").show();
					if (game_status == "finish") $(".end").show();
					
					if (game_status != "finish"){
						game_thread = setInterval(game_thread_fuc, 10);
					}
				}

            },
            error: function(ts) {
                console.log(ts);
            }
    });
}

new ResizeSensor($('.game-graph'), function(){ 
	var element = document.querySelector('.game-graph');
    graph_width = element.offsetWidth;
    graph_height = graph_width*2/3;
    document.getElementById("game-graph").style.height = graph_height+"px";

	GameArea.width = graph_width;
	GameArea.height = graph_height;

	S_X = 40 - GameArea.height * 3 / 2 + GameArea.width;
	S_Y = GameArea.height - 25;

	E_X = GameArea.width - 32;
	E_Y = 23;
});

function setPastVariables(past_games)
{
	var appendStr = "<div class='blur'></div>";
    past_games.forEach(function(game_obj){
    	if (game_obj.crash_point > 2)
    		appendStr += "<span class='good_game'>"+game_obj.crash_point.toFixed(2)+"</span>";
    	else appendStr += "<span>"+game_obj.crash_point.toFixed(2)+"</span>";
    });

    $(".point-history").html(appendStr);
}

function showButton()
{
	$("#button button").hide();
	if (betting_type == "normal")
	{
		if (game_status == "pending")
		{
			if (is_placed)
			{
				$("#button_status").text("Você fez uma aposta.");
				$("#button_status").show();	
			} 
			else
			{
				$("#place_bet").show();
			}
		}
		else if (game_status == "playing")
		{
			if (is_placed)
			{
				if (is_betted)
				{
					is_next_round();
				}
				else
				{
					$("#get").show();
				}
			}
			else
			{
				is_next_round();
			}
		}
		else if (game_status == "finish")
		{
			is_next_round();
		}
	}
	else
	{
		if (is_auto)
		{
			$("#stop_auto_betting").show();
		}
		else
		{
			if (game_status == "pending")
			{
				$("#start_auto_betting").text("Start auto betting from this round");
			}
			else
			{
				$("#start_auto_betting").text("Start auto betting from next round");
			}
			$("#start_auto_betting").show();
		}
	}
}

function is_next_round()
{
	if (!is_next_placed)
		$("#place_bet_next_round").show();
	else
	{ 
		$("#button_status").text("Você fez uma aposta na próxima rodada.");
		$("#button_status").show();
	}
}

$("#place_bet_next_round").click(function(){
	var quantity = $("#quantity").val();
	if (quantity < 1.8)
		Dashmix.helpers('notify', {type: 'info', icon: 'fa fa-info-circle mr-1', message: 'A quantidade mínima é de R$ 1,8'});
	else {
		bet_amount = quantity;
		is_next_placed = true;
		showButton();
	}
});

$("#place_bet").click(function(){
	var quantity = $("#quantity").val();
	if (quantity < 1.8)
		Dashmix.helpers('notify', {type: 'info', icon: 'fa fa-info-circle mr-1', message: 'A quantidade mínima é de R$ 1,8'});
	else {
		bet_amount = quantity;
		place_game();
	}
	
});

$("#get").click(function(){
	if (game_status == "playing")
		bet();
});

function bet()
{
	var current_point = Math.pow( 1 + 0.01 * ( (current_time - pending_time * 100) / 100), 8 ).toFixed(2);

	$.ajax({
        url:"/stage/bet_crash_game",
        type:'post',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {betting_point:current_point},
        success:function(req) {
            var data = JSON.parse(req);

            if (data.message == "already betted")
            	Dashmix.helpers('notify', {type: 'warning', icon: 'fa fa-exclamation mr-1', message: 'Você já fez uma aposta em outro dispositivo!'});

            else{
            	$(".win").show();
            	$("#earning").text("R$ " + data.earning);
			}

            $("#balance").text("R$ "+data.balance.toFixed(2));

            is_betted = true;

            showButton();
        },
        error: function(ts) {
            console.log(ts);
        }
	});
}



$(".betting_type button").click(function(){
 	$(".betting_type button").removeClass("active");
 	$(this).addClass("active");
 	betting_type = $(this).attr("id");

 	if (betting_type == "normal")
 	{
 		$(".total_auto").hide();
 	}
 	else {
 		$(".total_auto").show();
 	}
 	showButton();
});


$("#start_auto_betting").click(function(){

	if ($("#quantity").val() < 1.8)
	{
		Dashmix.helpers('notify', {type: 'info', icon: 'fa fa-info-circle mr-1', message: 'A quantidade mínima é de R$ 1,8'});
		return;
	}

	if ($("#total_auto").val() > 0)
	{
		is_auto = true;
		bet_amount = $("#quantity").val();
		if (game_status == "pending")
		{
			var total_auto = $("#total_auto").val();

			if (is_auto && total_auto != 0){
				place_game();
				$("#total_auto").val(total_auto - 1);
			} 
			else{
				is_auto = false;
			}
		}
		showButton();
	}
	else
	{
		Dashmix.helpers('notify', {type: 'info', icon: 'fa fa-info-circle mr-1', message: 'Por favor, insira a contagem de apostas automáticas.'});
	}
});

$("#stop_auto_betting").click(function(){
	is_auto = false;
	showButton();
});