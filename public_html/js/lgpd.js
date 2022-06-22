window.addEventListener("load", function(e){
    let textDiv = '<a class="lgpdBtAceitar" href="javascript:void(0);" onClick="lgpdHidde()">Aceitar</a><p>Utilizamos cookies essenciais e tecnologias semelhantes de acordo com a nossa <a href="/privacidade" target="_blank">Política de Privacidade</a> e, ao continuar navegando, você concorda com estas condições.</p>';
    
    let textStyle = 'div#lgpd{position: fixed;box-sizing: border-box;width: calc(100vw - 40px);background-color: #eee;bottom: 0;margin: 20px;padding: 20px;font-size: 14px;text-align: justify;z-index: 100;box-shadow: 0px 1px 6px #333;border-radius: 5px;}div#lgpd p{width: calc(100% - 120px);}div#lgpd a {color: #607d8b;font-weight: bold;}div#lgpd a.lgpdBtAceitar{display: inline-block;line-height: 30px;padding: 4px 20px;margin: 10px;color: #fff;background-color: #607d8b;box-shadow: 0px 0px 6px 0px rgb(0 0 0 / 50%);border-radius: 5px;text-decoration: none;float: right;}';
    
    let lgpdStyle = document.createElement('style');
    lgpdStyle.innerHTML = textStyle;
    document.body.appendChild(lgpdStyle);
    
    let lgpdDiv = document.createElement("div");
    lgpdDiv.setAttribute('id','lgpd');
    lgpdDiv.innerHTML = textDiv;
    document.body.appendChild(lgpdDiv);
    
    lgpdVerificaSessao();
});

function lgpdHidde(){
    document.getElementById('lgpd').style.display = 'none';
    sessionStorage.setItem('lgpd',1);
}

function lgpdVerificaSessao(){
    let lgpd = sessionStorage.getItem('lgpd');
    if(lgpd != null){
        if(lgpd == 1){
            document.getElementById('lgpd').style.display = 'none';
        }
    }
}