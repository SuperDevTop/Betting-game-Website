$(document).ready(function(){
    setInterval('getCrash()',250);
});

function getCrash(){
    $.post("/game/rocket_crash.php",{crash:1}, function( data ) {
        $('.crashVal').html(data);
    });
}