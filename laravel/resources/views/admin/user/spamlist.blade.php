@extends('admin.layout.default')
@section('css')
<link rel="stylesheet" href="{{asset('admin-assets/theme/js/plugins/datatables/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('admin-assets/theme/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css')}}">
<style type="text/css">
    .row>div{
        padding-bottom: 5px;
    }
</style>
@endsection

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">spam usuários</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Gerenciar usuários</li>
                    <li class="breadcrumb-item active" aria-current="page">spam usuários Lista</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->
<div class="content">
    <!-- Full Table -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default">
            <h3 class="block-title">spam Usuários</h3>
            <div class="block-options">
                
            </div>
        </div>
        <div class="block-content">
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" id="user-table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">ID</th>
                            <th style="width: 20%;">Nome completo</th>
                            <th style="width: 20%;">E-mail</th>
                            <th style="width: 15%;">Foto</th>
                            <th style="width: 15%;">Saldo</th>
                            <th class="text-center" style="width: 100px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($users as $user) {
                        ?>
                        <tr data-id="{{$user->id}}" status="{{$user->status}}">
                            <td>
                                {{$user->id}}
                            </td>
                            <td>
                                {{$user->full_name}}
                            </td>
                            <td>
                                {{$user->email}}
                            </td>
                            <td>
                                @if ($user->profile_pic == "")
                                <i class="si si-user fa-2x"></i>
                                @endif
                            </td>
                            <td>R$ {{$user->balance}}</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <!-- <a class="btn btn-sm btn-primary" data-toggle="tooltip" title="Edit" href="#">
                                        <i class="fa fa-pencil-alt"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-primary remove" data-toggle="modal" data-target="#modal-block-normal" title="Delete">
                                        <i class="fa fa-times"></i>
                                    </button> -->
                                    <a type="button" class="btn btn-danger" href="{{url('admin/ActiveUser/'.$user->id)}}">
                                        desbloquear
                                    </a>
                                    <a class="btn btn-primary" href="{{url('admin/UserCrashGames/'.$user->id)}}">
                                        <i class="si si-game-controller"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
@endsection

@section('js')

<script src="{{asset('admin-assets/theme/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin-assets/theme/js/plugins/datatables/buttons/buttons.colVis.min.js')}}"></script>

<script type="text/javascript">
    $("#user-table").dataTable({
                        language: {
                            searchPlaceholder: "procurar...",
                            info: "Exibindo _START_ a _END_ de _TOTAL_ registros",
                            paginate: {
                              previous: "anterior",
                              next: "next"
                            }
                        },
                        pageLength: 20,
                        lengthMenu: [
                            [5, 10, 20, 50, 100],
                            [5, 10, 20, 50, 100]
                        ],
                        autoWidth: !1,
                        buttons: [{
                            extend: "copy",
                            className: "btn btn-sm btn-primary"
                        }, {
                            extend: "csv",
                            className: "btn btn-sm btn-primary"
                        }, {
                            extend: "print",
                            className: "btn btn-sm btn-primary"
                        }],
                        dom: "<'row'<'col-sm-12'<'text-center bg-body-light py-2 mb-2'B>>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
                    });
</script>
@endsection
