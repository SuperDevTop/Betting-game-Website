@extends('admin.layout.default')
@section('css')
<style type="text/css">
    .m-b-0{
        margin-bottom: 0px;
    }
</style>
@endsection

@section('content')


<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">comissões</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Gerenciar comissões</li>
                    <li class="breadcrumb-item active" aria-current="page">comissões</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->
<div class="content">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">configuração de comissão</h3>
        </div>
        <form method="post" action="{{url('admin/SetCommission')}}">
            @csrf
        <div class="block-content">
            <h4 class="m-b-0">porcentagem de divisão com admin</h4>
            <p>este valor será aplicado quando o usuário ganhar dinheiro ao ganhar as apostas.</p>
            <div class="row">
                <div class="col-md-6">
                    <label for="example-text-input">usuário</label>
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" value="{{100 - $d_c}}" id="division_percentage_user" name="division_percentage_user">
                        <div class="input-group-append">
                            <span class="input-group-text input-group-text-alt">
                                %
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input">administrador(tu)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" step="0.1" value="{{$d_c}}" id="division_percentage_admin" name="division_percentage_admin">
                        <div class="input-group-append">
                            <span class="input-group-text input-group-text-alt">
                                %
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <h4 class="m-b-0">porcentagem de afiliados com anunciantes</h4>
            <p>este valor será aplicado quando o usuário ganhar dinheiro ao ganhar as apostas.</p>
            <div class="row">
                <div class="col-md-6">
                    <label for="example-text-input">usuário</label>
                    <div class="input-group">
                        <input type="number" class="form-control" value="{{100 - $a_c}}" id="affiliate_percentage_user" name="affiliate_percentage_user">
                        <div class="input-group-append">
                            <span class="input-group-text input-group-text-alt">
                                %
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="example-text-input">administrador(tu)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" value="{{$a_c}}" id="affiliate_percentage_admin" name="affiliate_percentage_admin">
                        <div class="input-group-append">
                            <span class="input-group-text input-group-text-alt">
                                %
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding: 40px 0px 20px 0px; text-align: right;">
                <button type="submit" class="btn btn-primary">Save</button>
            </div> 
        </div>
        </form>
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript">

    $("input[type=number]").change(function(){
        if ($(this).val() > 100) $(this).val(100);
        if ($(this).val() < 0) $(this).val(0);
    });
    $("#affiliate_percentage_user").change(function(){
        var val = $(this).val();
        $("#affiliate_percentage_admin").val( (100 - val).toFixed(2) );
    });
    $("#affiliate_percentage_admin").change(function(){
        var val = $(this).val();
        $("#affiliate_percentage_user").val( (100 - val).toFixed(2) );
    });

    $("#division_percentage_user").change(function(){
        var val = $(this).val();
        $("#division_percentage_admin").val( (100 - val).toFixed(2) );
    });
    $("#division_percentage_admin").change(function(){
        var val = $(this).val();
        $("#division_percentage_user").val( (100 - val).toFixed(2) );
    });
</script>
@endsection
