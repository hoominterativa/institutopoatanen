@if (isset($portfolio))
    {!! Form::model($portfolio, ['route' => ['admin.serv01.portfolio.update', $portfolio->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.serv01.portfolio.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    <input type="hidden" name="service_id" value="{{$service->id}}">
@endif
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Beve Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'rows'=>5,
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'100',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activePortfolio']) !!}
                {!! Form::label('activePortfolio', 'Ativar Exibição', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Box', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image->width, // px
                            'data-min-height'=>$cropSetting->path_image->height, // px
                            'data-box-height'=>'250', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($portfolio)?($portfolio->path_image<>''?url('storage/'.$portfolio->path_image):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}

{!! Form::model(null, ['route' => ['admin.serv01.portfolio.gallery.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    @if (isset($portfolio))
        <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}">
        <div class="mb-3">
            {!! Form::label('title', 'Galleria de Imagens', ['class'=>'form-label']) !!}
            <div class="uploadMultipleImage">
                <label for="path_image" class="content-message">
                    {!! Form::file('path_image[]', [ 'id' => 'path_image', 'multiple' => 'multiple', 'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp', 'class' => 'inputGetImage']) !!}
                    <i class="mdi mdi-cloud-upload-outline mdi-36px"></i>
                    <h4 class="title">Solte as imagens aqui ou clique para fazer upload.</h4>
                    <span class="text-muted font-13">Carregar imagens com no máximo <strong>2mb</strong></span>
                </label>
                <div id="containerMultipleImages" class="mt-3"></div>
            </div>
        </div>
    @endif
{!! Form::close() !!}
@if (isset($portfolio))
    <div class="row mb-3">
        <div class="col-6">
            <button id="btSubmitDelete" data-route="{{route('admin.serv01.portfolio.gallery.destroySelected')}}" type="button" class="btn btn-danger btDeletePortfolioGallery" style="display: none;">Deletar selecionados</button>
        </div>
    </div>
    <table class="table table-bordered table-sortable">
        <thead class="table-light">
            <tr>
                <th width="50px"></th>
                <th width="30px" class="bs-checkbox">
                    <label><input name="btnSelectAll" value="btDeletePortfolioGallery" type="checkbox"></label>
                </th>
                <th></th>
                <th width="90px">Ações</th>
            </tr>
        </thead>

        <tbody data-route="{{route('admin.serv01.portfolio.gallery.sorting')}}">
            @foreach ($portfolio->gallery as $gallery)
                <tr data-code="{{$gallery->id}}">
                    <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                    <td class="bs-checkbox align-middle">
                        <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$gallery->id}}"></label>
                    </td>
                    <td class="align-middle avatar-group">
                        @if ($portfolio->path_image)
                            <a href="{{asset('storage/'.$gallery->path_image)}}" data-fancybox="galleryPortfolio-{{$portfolio->id}}">
                                <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$gallery->path_image)}})"></div>
                            </a>
                        @endif
                    </td>
                    <td class="align-middle">
                        <div class="row">
                            <form action="{{route('admin.serv01.portfolio.gallery.destroy',['SERV01ServicesPortfolioGallery' => $gallery->id])}}" class="col-4" method="POST">
                                @method('DELETE') @csrf
                                <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
