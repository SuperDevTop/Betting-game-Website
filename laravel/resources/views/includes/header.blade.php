<!-- Header Content -->
<div class="content-header">
    <!-- Left Section -->
    <div>
        <!-- Toggle Sidebar -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout()-->
        <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_toggle">
            <i class="fa fa-fw fa-bars"></i>
        </button>
        <!-- END Toggle Sidebar -->
    </div>
    <!-- END Left Section -->

    <!-- Right Section -->
    <div>
        <!-- User Dropdown -->
        <button style="background: #343a40;
    border: 1px solid #666;" class="btn btn-danger" id="balance" balance="{{Auth::user()->balance}}">R$ {{Auth::user()->balance}}</button>&nbsp;
        <a class="btn btn-danger" href="{{url('../transacoes/deposito')}}">Depositar</a>&nbsp;
        <div class="dropdown d-inline-block">
            <button type="button" class="btn btn-primary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-color:#999999; border-width: 2px;">
                <i class="fa fa-fw fa-user d-sm-none"></i>
                <span class="d-none d-sm-inline-block">&nbsp;{{Auth::user()->full_name}}&nbsp;</span>
                <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                <div class="bg-primary-darker rounded-top font-w600 text-white text-center p-3">
                    Contexto
                </div>
                <div class="p-2">
                    <a class="dropdown-item" href="{{url('profile')}}">
                        <i class="far fa-fw fa-user mr-1"></i> Perfil
                    </a>
                    <a class="dropdown-item" href="/transacoes/deposito">
                        <i class="far fa-fw fa-plus-square mr-1"></i> Depósito
                    </a>
                    <!--a class="dropdown-item" href="{{url('withdraw')}}"-->
                    <a class="dropdown-item" href="/transacoes/saque">
                        <i class="far fa-fw fa-minus-square mr-1"></i> Retirar
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:void(0);" onClick="javascript:document.getElementById('lBoxVideo').style.display='block';">
                        <i class="far fa-fw fa-play-circle mr-1"></i> Como Jogar
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{url('logout')}}">
                        <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END Right Section -->
</div>

<div id="lBoxVideo" style="display:none;position: fixed;width: 100vw;height: 100vh; top:0; left:0; z-index: 5000;background-color: rgba(0,0,0,0.9);">
    <a href="javascript:void(0);" onClick="javascript:document.getElementById('lBoxVideo').style.display='none';document.getElementById('videoPlayer').pause()" style="position: absolute;right: 20px;top: 20px;background-color: #000;color: #fff;padding: 2px 5px;border-radius: 3px;">Fechar</a>
    <video id="videoPlayer" controls="" style="background: #ccc;position: absolute;width: 310px;height: 552px;margin: -276px 0 0 -155px;top: 50%;left: 50%;"> 
        <source src="/img/comojogar.mp4" type="video/mp4">
    </video>
</div>