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
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'Schedules', 'SCHE01')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'Schedules', 'SCHE01')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <button id="btSubmitDelete" data-route="{{route('admin.sche01.destroySelected')}}" type="button" class="btn btn-danger btnDeleteSchedules" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.sche01.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteSchedules" type="checkbox"></label>
                                            </th>
                                            <th>Imagem</th>
                                            <th>Título/Subtítulo</th>
                                            <th>Descrição</th>
                                            <th>Texto</th>
                                            <th>Info</th>
                                            <th>Dia do Evento</th>
                                            <th>Hora do Evento</th>
                                            <th>Título do botão</th>
                                            <th>Link do botão</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.sche01.sorting')}}">
                                        @foreach ($schedules as $schedule)
                                            <tr data-code="{{$schedule->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$schedule->id}}"></label>
                                                </td>
                                                <td class="align-middle avatar-group">
                                                    @if ($schedule->path_image_sub)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $schedule->path_image_sub)}})"></div>
                                                    @endif
                                                    @if ($schedule->path_image_hours)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $schedule->path_image_hours)}})"></div>
                                                    @endif
                                                    @if ($schedule->path_image)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $schedule->path_image)}})"></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{$schedule->title}} <b>/</b>{{$schedule->subtitle}}</td>
                                                <td class="align-middle">{!! substr($schedule->description, 0, 20) !!}</td>
                                                <td class="align-middle">{!! substr($schedule->text, 0, 20) !!}</td>
                                                <td class="align-middle">{!! substr($schedule->information, 0, 20) !!}</td>
                                                <td class="align-middle">{{Carbon\Carbon::parse($schedule->event_date)->format('d/m/Y')}}</td>
                                                <td class="align-middle">{{ date('H:i', strtotime($schedule->event_time)) }}</td>
                                                <td class="align-middle">{{$schedule->title_button}}</td>
                                                <td class="align-middle"><a href="{{ $schedule->link_button }}" target="_blank" class="mdi mdi-link-box-variant mdi-24px"></a></td>
                                                <td class="align-middle">
                                                    @if ($schedule->active)
                                                        <span class="badge bg-success">Ativo</span>
                                                    @else
                                                        <span class="badge bg-danger">Inativo</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.sche01.edit',['SCHE01Schedules' => $schedule->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.sche01.destroy',['SCHE01Schedules' => $schedule->id])}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
