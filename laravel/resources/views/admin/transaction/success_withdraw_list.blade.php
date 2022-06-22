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
            <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Retirada paga</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Lista de saques pagos</li>
                    <li class="breadcrumb-item active" aria-current="page">Lista de retirada</li>
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
            <h3 class="block-title">lista de retirar</h3>
            <div class="block-options">
                <span></span>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons" id="user-table">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Encontro</th> <!--  -->
                            <th style="width: 8%;">ID</th> <!--  -->
                            <th style="width: 10%;">Nome</th> <!--  -->
                            <th style="width: 10%;">CPF</th> <!--  -->
                            <th style="width: 10%;">Banco</th> <!--  -->
                            <th style="width: 10%;">Agência</th> <!--  -->
                            <th style="width: 10%;">tipo de conta</th> <!--  -->
                            <th style="width: 10%;">Conta</th> <!--  -->
                            <th style="width: 9%;">Requeridos</th> <!--  -->
                            <th style="width: 7%;">Comissão</th> <!--  -->
                            <th style="width: 9%;">Paga</th> <!--  -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($withdraws as $withdraw) {
                        ?>
                        <tr data-id="{{$withdraw->id}}" status="{{$withdraw->status}}">
                            <td>{{date("Y-m-d", strtotime($withdraw->created_at) - 3600 * 3)}}</td>
                            <td>
                                {{$withdraw->id}} 
                            </td>
                            <td>
                                {{$withdraw->full_name}} 
                            </td>
                            <td>
                                {{$withdraw->cpf}} 
                            </td>
                            <td>
                                {{$withdraw->bank}} 
                            </td>
                            <td>
                                {{$withdraw->agency}} 
                            </td>
                            <td>
                                @if ($withdraw->account_type == "checking_account")
                                    Conta Corrente
                                @else 
                                    Conta Poupança
                                @endif 
                            </td>
                            <td>
                                {{$withdraw->account}} 
                            </td>
                            <td>
                                R$ {{$withdraw->requested_amount}}
                            </td>
                            <td>
                                R$ {{$withdraw->requested_amount - $withdraw->paid_amount}}
                            </td>
                            <td>
                                R$ {{$withdraw->paid_amount}}
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
                        order:['0',"desc"],
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
