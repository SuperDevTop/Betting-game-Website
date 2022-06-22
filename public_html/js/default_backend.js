$(document).ready(function(e){
    //header events
    $('span.icoMenu').on('click',function(e){
        $(this).toggleClass('oculto');
        $('nav').toggleClass('oculto');
        $('section').toggleClass('oculto');
    });
});

function editCPF(box = 1){
	if(box == 1){
		$('.editCPF').css({'display':'block'});
	}else{
		$('.editCPF').css({'display':'none'});
	}
}

function editPER(box = 1){
	if(box == 1){
		$('.editPER').css({'display':'block'});
	}else{
		$('.editPER').css({'display':'none'});
	}
}

function addBonus(box = 1){
	if(box == 1){
		$('.addBonus').css({'display':'block'});
	}else{
		$('.addBonus').css({'display':'none'});
	}
}

function verificaDeposito(c,v,u,t){
	$.post("/transacoes/deposito_status.php",{chave:c,valor:v}, function(data){
		let status = data;
		if(status == 'paid'){
			location.href = "/backend/usuarios/"+u;
		}else{
			alert("Pendente");
			$(t).html("Cancelar");
			$(t).attr("onClick","javascript:location.href='?cancelar="+c+"&id_user="+u+"';");
		}
	});
}

function excUser(i,n){
	if(confirm("Deseja excluir: "+n)){
		location.href = "/backend/usuarios/"+i+"?excuser="+i;
	}
}