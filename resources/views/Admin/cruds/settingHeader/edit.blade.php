@extends('Admin.core.admin')
@section('content')
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('admin.header.index')}}">Configurações do Menu</a></li>
                                    <li class="breadcrumb-item active">Editar Link do Menu</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar Link do Menu</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                {!! Form::model($header, ['route' => ['admin.header.update', $header->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
                    @include('Admin.cruds.settingHeader.form')
                    {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
                    <a href="{{route('admin.header.index')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
                {!! Form::close() !!}
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesCreateEdit')
    <script>
        $(function(){
            $(window).on('load', function(){
                let module = $('input[name=module]').val(),
                    model = $('input[name=model]').val(),
                    selectDropdown = $('input[name=select_dropdown]').val()

                if($('.activeDropdown').val()==1){
                    $('.ifRelations').fadeIn('fast')
                }

                $(`.selectPage option[value="${module}|${model}"]`).attr('selected', 'selected')

                getRelationsModel(module, model, 'edit', function(){
                    var relation = null;
                    if(selectDropdown!='this'){
                        relation = selectDropdown.split(',')[0];
                    }

                    getConditionsModel(module, model, relation, 'edit', function(){
                        if($('select[name=condition]').length){
                            let condition = $('input[name=set_condition]').val()
                            $(`select[name=condition] option[value=${condition}]`).attr('selected', 'selected')
                        }
                        if(selectDropdown=='this'){
                            $('.btnViewPage .title').text($('.btnSelectPage').text())
                            $('.btnSelectPage input').prop('checked', true)
                        }else{
                            let arrRelations = selectDropdown.split(',')
                            if(selectDropdown!=''){
                                $('.ifCategory').fadeIn('fast')

                                $(`input[name=set_dropdown][value=${arrRelations[0]}]`).prop('checked', true)
                                if(arrRelations.length>1){
                                    $(`input[name=set_dropdown][value=${arrRelations[1]}]`).prop('checked', true)
                                }
                            }
                        }
                    })
                })
            })
        })
    </script>
@endsection
