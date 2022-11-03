<div id="containerPortfolios">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                </div>
                <h4 class="page-title">Portifólios</h4>
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
                            <button id="btSubmitDelete" data-route="{{route('admin.serv01.portfolio.destroySelected')}}" type="button" class="btn btn-danger btDeletePortfolios" style="display: none;">Deletar selecionados</button>
                        </div>
                        <div class="col-6">
                            <a href="javascript:void(0)" data-bs-target="#modal-portfolio-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                            <button class="btn btn-warning float-end me-2" type="button" data-bs-toggle="collapse" data-bs-target="#portfolioSection" aria-expanded="false" aria-controls="collapseExample">
                                Informações da Seção
                            </button>
                        </div>
                        <div class="col-12 mt-3">
                            @if ($portfolioSection)
                                {!! Form::model($portfolioSection, ['route' => ['admin.serv01.portfolio.section.update', $portfolioSection->id], 'class'=>'parsley-validate', 'files' => true]) !!}
                                @method('PUT')
                            @else
                                {!! Form::model(null, ['route' => 'admin.serv01.portfolio.section.store', 'class'=>'parsley-validate', 'files' => true]) !!}
                            @endif
                                <input type="hidden" name="service_id" value="{{$service->id}}">
                                <div class="collapse bg-light p-3 mb-3" id="portfolioSection">
                                    <div class="row">
                                        <h3 class="mb-3">Informações da Seção</h3>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-2">
                                                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                                                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required' => true]) !!}
                                            </div>
                                            <div class="mb-2">
                                                {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                                                {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                                            </div>
                                            <div class="mb-3 form-check me-3">
                                                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeSectionPortfolio']) !!}
                                                {!! Form::label('activeSectionPortfolio', 'Ativar exibição?', ['class'=>'form-check-label']) !!}
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="mb-3">
                                                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                                                {!! Form::textarea('description', null, [
                                                    'class'=>'form-control',
                                                    'id'=>'description',
                                                    'data-parsley-trigger'=>'keyup',
                                                    'data-parsley-minlength'=>'20',
                                                    'data-parsley-maxlength'=>'500',
                                                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                                                    'data-parsley-validation-threshold'=>'10',
                                                ]) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
                                        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit']) !!}
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div> <!-- end col-->
                    </div>
                    <table class="table table-bordered table-sortable">
                        <thead class="table-light">
                            <tr>
                                <th width="50px"></th>
                                <th width="30px" class="bs-checkbox">
                                    <label><input name="btnSelectAll" value="btDeletePortfolios" type="checkbox"></label>
                                </th>
                                <th></th>
                                <th>Título</th>
                                <th>Descrição</th>
                                <th width="100px">Status</th>
                                <th width="90px">Ações</th>
                            </tr>
                        </thead>

                        <tbody data-route="{{route('admin.serv01.portfolio.sorting')}}">
                            @foreach ($portfolios as $portfolio)
                                <tr data-code="{{$portfolio->id}}">
                                    <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                    <td class="bs-checkbox align-middle">
                                        <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$portfolio->id}}"></label>
                                    </td>
                                    <td class="align-middle avatar-group">
                                        @if ($portfolio->path_image)
                                            <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$portfolio->path_image)}})"></div>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{$portfolio->title}}</td>
                                    <td class="align-middle">{{substr($portfolio->description,0,100)}}</td>
                                    <td class="align-middle">
                                        @if ($portfolio->active)
                                            <span class="badge bg-success">Ativo</span>
                                        @else
                                            <span class="badge bg-danger">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="row">
                                            <div class="col-4">
                                                <a href="javascript:void(0)" data-bs-target="#modal-portfolio-update-{{$portfolio->id}}" data-bs-toggle="modal" class="btn-icon mdi mdi-square-edit-outline"></a>
                                            </div>
                                            <form action="{{route('admin.serv01.portfolio.destroy',['SERV01ServicesPortfolio' => $portfolio->id])}}" class="col-4" method="POST">
                                                @method('DELETE') @csrf
                                                <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                            </form>
                                            {{-- BEGIN MODAL PORTFOLIO UPDATE --}}
                                            <div id="modal-portfolio-update-{{$portfolio->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog" style="max-width: 1100px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header p-3 pt-2 pb-2">
                                                            <h4 class="page-title">Cadastrar Portifólio</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body p-3 pt-0 pb-3">
                                                            @include('Admin.cruds.Services.SERV01.Portfolios.form',[
                                                                'service' => $service,
                                                                'portfolio' => $portfolio
                                                            ])
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- END MODAL PORTFOLIO UPDATE --}}
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
</div>

{{-- BEGIN MODAL ADVANTAGE CREATE --}}
<div id="modal-portfolio-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Portifólio</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Services.SERV01.Portfolios.form',[
                    'service' => $service,
                    'portfolio' => null
                ])
            </div>
        </div>
    </div>
</div>
{{-- END MODAL ADVANTAGE CREATE --}}
