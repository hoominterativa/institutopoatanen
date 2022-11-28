
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-1">
                            {!! Form::label('title_page', 'Título da página', ['class'=>'form-label mb-0']) !!}
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Título que será exibido nos links de compliances do site"></i>
                        </div>
                        {!! Form::text('title_page', null, ['class'=>'form-control', 'id'=>'title_page', 'required'=>'required']) !!}
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="d-flex align-items-center h-100 pt-4">
                        <div class="mb-3 form-check me-3">
                            {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                            {!! Form::label('active', 'Ativar exibição da página', ['class'=>'form-check-label']) !!}
                        </div>
                        <div class="mb-3 form-check me-3">
                            {!! Form::checkbox('show_footer', '1', null, ['class'=>'form-check-input', 'id'=>'show_footer']) !!}
                            {!! Form::label('show_footer', 'Ativar exibição no Rodapé do site', ['class'=>'form-check-label']) !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="d-flex align-items-center mb-3">
                <h4>Banner da página</h4>
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Banner principal da página, é exibido no início da mesma."></i>
            </div>
            <div class="mb-3">
                {!! Form::label('title_banner', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title_banner', null, ['class'=>'form-control', 'id'=>'title_banner']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('file', 'Imagem', ['class'=>'form-label']) !!}
                <small class="ms-2">Dimensão proporcional mínima 1500x400px</small>
                {!! Form::file('path_image_banner', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'200',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($compliance)?($compliance->path_image_banner<>''?url('storage/'.$compliance->path_image_banner):''):'',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="d-flex align-items-center mb-3">
                <h4>Infomações da seção</h4>
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Título, Subtítulo e ícone que aparece abaixo do banner."></i>
            </div>
            <div class="row">
                <div class="mb-3 col-lg-6">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="mb-3 col-lg-6">
                    {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensão proporcional mínima 400x400px</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_icon', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-min-width'=>'300',
                            'data-min-height'=>'300',
                            'data-box-height'=>'200',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($compliance)?($compliance->path_image_icon<>''?url('storage/'.$compliance->path_image_icon):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="complete-editor__content mb-3">
                {!! Form::label('text', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control complete-editor',
                    'id'=>'text',
                ]) !!}
            </div>
        </div>
    </div>
</div>
{{-- end row --}}
