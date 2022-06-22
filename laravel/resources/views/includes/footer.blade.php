<footer id="page-footer" class="bg-body-light">
    <div class="content py-0">
        <div class="row font-size-sm">
            <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-right">
                Feito com <i class="fa fa-heart text-danger"></i> de <a class="font-w600" href="#">Daniel</a>
            </div>
            <div class="col-sm-6 order-sm-1 text-center text-sm-left">
                <a class="font-w600" href="{{url('/crash_game_play')}}">Million Rocket</a> &copy; <span data-toggle="year-copy"></span>
            </div>
        </div>
    </div>
</footer>
<script>
    $.post("/transacoes/sessao.php", {email:'{{Auth::user()->email}}' }, function(){});
</script>