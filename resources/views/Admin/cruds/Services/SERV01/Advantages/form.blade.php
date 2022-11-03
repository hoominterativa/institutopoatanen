@if (isset($advantage))
    {!! Form::model($advantage, ['route' => ['admin.serv01.advantage.update', $advantage->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.serv01.advantage.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
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
                    'rows'=>13,
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'100',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'activeAdvantage']) !!}
                {!! Form::label('activeAdvantage', 'Ativar Exibição', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="mb-3">
                {!! Form::label('path_image_icon', 'Ícone', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_icon', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'150',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($advantage)?$advantage->path_image_icon<>''?url('storage/'.$advantage->path_image_icon):'':'',
                ]) !!}
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('path_image', 'Imagem Box', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'4/4',
                            'data-height'=>'150',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($advantage)?$advantage->path_image<>''?url('storage/'.$advantage->path_image):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        <div class="col-12">
            <div class="normal-editor__content mb-3">
                {!! Form::label('text', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'text',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
