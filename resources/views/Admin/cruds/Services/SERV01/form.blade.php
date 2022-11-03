<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="mb-3">
                        {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="mb-3">
                        {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                    </div>
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Breve Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'rows'=>5,
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'70',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('featured', '1', null, ['class'=>'form-check-input', 'id'=>'featured']) !!}
                    {!! Form::label('featured', 'Destacar na home', ['class'=>'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                    {!! Form::label('active', 'Ativar exibição', ['class'=>'form-check-label']) !!}
                </div>
            </div>

            <div class="mb-3">
                {!! Form::label('file', 'Ícone', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_icon', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'150',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($service)?$service->path_image_icon<>''?url('storage/'.$service->path_image_icon):'':'',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Box', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'4/4',
                            'data-height'=>'205',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($service)?$service->path_image<>''?url('storage/'.$service->path_image):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                {!! Form::label('file', 'Imagem banner', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_banner', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'205',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($service)?$service->path_image_banner<>''?url('storage/'.$service->path_image_banner):'':'',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
    <div class="col-12">
        <div class="normal-editor__content mb-3">
            {!! Form::label('text', 'Texto', ['class'=>'form-label']) !!}
            {!! Form::textarea('text', null, [
                'class'=>'form-control normal-editor',
                'data-height'=>500,
                'id'=>'text',
            ]) !!}
        </div>
    </div>
</div>
{{-- end row --}}

{{-- Essa estrutura pode ser usada junto ao label do input para aparecer o ícone de duvida do lado do mesmo. pode usar a estutura abaixo substituindo o "Form::label" --}}
{{-- <div class="d-flex align-items-center mb-1">
    {!! Form::label('validationCustom01', 'First name', ['class'=>'form-label']) !!}
    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-original-title="Coloque a mensagem desejado aqui"></i>
</div> --}}
