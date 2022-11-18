<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('category_id', 'Categoria', ['class'=>'form-label']) !!}
                {!! Form::select('category_id', $categories, null, [
                    'required'=>'required',
                    'class'=>'form-select',
                    'id'=>'category_id',
                    'placeholder' => '--'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Data de Publicação', ['class'=>'form-label']) !!}
                {!! Form::text('publishing', null, [
                        'class'=>'form-control',
                        'required'=>'required',
                        'data-provide'=>'datepicker',
                        'data-date-autoclose'=>'true',
                        'data-date-format'=>'dd/mm/yyyy',
                        'data-date-language'=>'pt-BR',
                    ])!!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Breve Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'description',
                    'required'=>'required',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'400',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                    {!! Form::label('active', 'Ativar Exibição', ['class'=>'form-check-label']) !!}
                </div>
                <div class="form-check me-3">
                    {!! Form::checkbox('featured_home', '1', null, ['class'=>'form-check-input', 'id'=>'featured_home']) !!}
                    {!! Form::label('featured_home', 'Destacar na Home', ['class'=>'form-check-label']) !!}
                </div>
                <div class="form-check me-3">
                    {!! Form::checkbox('featured_page', '1', null, ['class'=>'form-check-input', 'id'=>'featured_page']) !!}
                    {!! Form::label('featured_page', 'Destacar na Página', ['class'=>'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_thumbnail', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'1/1',
                            'data-height'=>'225',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($blog)?$blog->path_image_thumbnail<>''?url('storage/'.$blog->path_image_thumbnail):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                {!! Form::label('file', 'Imagem Interna', ['class'=>'form-label']) !!}
                {!! Form::file('path_image', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'225',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($blog)?$blog->path_image<>''?url('storage/'.$blog->path_image):'':'',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="complete-editor__content mb-3">
            {!! Form::label('complete-editor', 'Texto Artigo', ['class'=>'form-label']) !!}
            {!! Form::textarea('text', null, [
                'class'=>'form-control complete-editor',
                'id'=>'complete-editor',
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
