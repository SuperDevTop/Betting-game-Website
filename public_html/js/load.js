if(sessionStorage.getItem('cookies') == null){
    if(confirm("Aceita Cookies?")){
        sessionStorage.setItem('cookies','aceito');
        importar();
    }else{
        sessionStorage.setItem('cookies','naoaceito');
        console.log("NÃO ACEITO");
    }
}else{
    if(sessionStorage.getItem('cookies') == 'aceito'){
        importar();
    }else{
        console.log("NÃO ACEITO");
    }
}

function importar(){
    document.querySelector('head').insertAdjacentHTML('beforeend','<!-- Font Awesome -->');
    document.querySelector('head').insertAdjacentHTML('beforeend','<script src="https://kit.fontawesome.com/2e5f444afc.js" crossorigin="anonymous"></script>');
    document.querySelector('head').insertAdjacentHTML('beforeend','<!-- Default JS -->');
    document.querySelector('head').insertAdjacentHTML('beforeend','<script src="js/default.js?v=1.1"></script>');
}