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
                                    <li class="breadcrumb-item active">{{$configModelsMain->Blogs->BLOG01->config->titlePanel}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{$configModelsMain->Blogs->BLOG01->config->titlePanel}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-1">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-light dropdown-toggle py-0 px-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-filter-variant font-28 text-primary"></i>
                                            </button>
                                            <div class="dropdown-menu p-3 bg-light">
                                                {!! Form::model(null, ['route' => 'admin.blog01.index.filter', 'class'=>'parsley-validate', 'method'=>'POST', 'style' => 'width:300px']) !!}
                                                    <div class="mb-3">
                                                        {!! Form::label('category_id', 'Categoria', ['class'=>'form-label']) !!}
                                                        {!! Form::select('category_id', $categories, null, [
                                                            'class'=>'form-select',
                                                            'id'=>'category_id',
                                                            'placeholder' => '--'
                                                        ]) !!}
                                                    </div>
                                                    <div class="mb-3">
                                                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                                                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                                                    </div>
                                                    <div class="row align-items-center mb-3">
                                                        {!! Form::label(null, 'Publicação', ['class'=>'form-label col-12']) !!}
                                                        <div class="col-12 col-sm-5">
                                                            {!! Form::text('date_start', null, [
                                                                'class'=>'form-control',
                                                                'data-provide'=>'datepicker',
                                                                'data-date-autoclose'=>'true',
                                                                'data-date-format'=>'dd/mm/yyyy',
                                                                'data-date-language'=>'pt-BR',
                                                            ])!!}
                                                        </div>
                                                        <div class="col-12 col-sm-2 text-center">{!! Form::label(null, 'até', ['class'=>'form-label mb-0']) !!}</div>
                                                        <div class="col-12 col-sm-5">
                                                            {!! Form::text('date_end', null, [
                                                                'class'=>'form-control',
                                                                'data-provide'=>'datepicker',
                                                                'data-date-autoclose'=>'true',
                                                                'data-date-format'=>'dd/mm/yyyy',
                                                                'data-date-language'=>'pt-BR',
                                                            ])!!}
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        {!! Form::label('active', 'Status', ['class'=>'form-label']) !!}
                                                        {!! Form::select('active', [1 => 'Ativo', 0 => 'inativo'], null, [
                                                            'class'=>'form-select',
                                                            'id'=>'active',
                                                            'placeholder' => '--'
                                                        ]) !!}
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12 col-sm-6">
                                                            <div class="form-check">
                                                                {!! Form::checkbox('featured_home', '1', null, ['class'=>'form-check-input', 'id'=>'featured_home']) !!}
                                                                {!! Form::label('featured_home', 'Destaque Home', ['class'=>'form-check-label']) !!}
                                                            </div>
                                                            <div class="form-check">
                                                                {!! Form::checkbox('featured_page', '1', null, ['class'=>'form-check-input', 'id'=>'featured_page']) !!}
                                                                {!! Form::label('featured_page', 'Destaque Página', ['class'=>'form-check-label']) !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {!! Form::button('Buscar', ['class'=>'btn btn-primary waves-effect waves-light width-lg', 'type' => 'submit']) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <button id="btSubmitDelete" data-route="{{route('admin.blog01.destroySelected')}}" type="button" class="btn btn-danger btnDeleteBlog" style="display: none;">Deletar selecionados</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{route('admin.blog01.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteBlog" type="checkbox"></label>
                                            </th>
                                            <th width="80px"></th>
                                            <th>Categoria</th>
                                            <th>Título</th>
                                            <th>Publicação</th>
                                            <th width="100px">Status</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.blog01.sorting')}}">
                                        @foreach ($blogs as $blog)
                                            <tr data-code="{{$blog->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$blog->id}}"></label>
                                                </td>
                                                <td class="align-middle avatar-group">
                                                    @if ($blog->path_image)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$blog->path_image)}})"></div>
                                                    @endif
                                                    @if ($blog->path_image_thumbnail)
                                                        <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$blog->path_image_thumbnail)}})"></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle"><b>{{$blog->category->title}}</b></td>
                                                <td class="align-middle">{{$blog->title}}</td>
                                                <td class="align-middle">{{Carbon\Carbon::parse($blog->publishing)->formatLocalized('%d de %B de %Y')}}</td>
                                                <td class="align-middle">
                                                    <div class="d-flex">
                                                        @if ($blog->active)
                                                            <span class="badge bg-success me-2">Ativo</span>
                                                        @else
                                                            <span class="badge bg-danger me-2">Inativo</span>
                                                        @endif
                                                        @if ($blog->featured_home)
                                                            <span class="badge bg-primary text-white me-2">Destaque Home</span>
                                                        @endif
                                                        @if ($blog->featured_page)
                                                            <span class="badge bg-info text-white me-2">Destaque Página</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="{{route('admin.blog01.edit',['BLOG01Blogs' => $blog->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('admin.blog01.destroy',['BLOG01Blogs' => $blog->id])}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- PAGINATION --}}
                                <div class="mt-3 float-end">
                                    {{$blogs->links()}}
                                </div>
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
