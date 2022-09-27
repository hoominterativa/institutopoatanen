<div class="row col-12">
    <div class="col-12 col-lg-6" id="tooltip-container">
        <div class="card card-body">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                {!! Form::url('link', null, ['class'=>'form-control', 'parsley-type'=>'url']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('heard', 'Tipo', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="O tipo 'lightbox' só aceitará links de vídeo (Youtube, Vimeo), caso contrário apresentará erro."></i>
                </div>
                {!! Form::select('target_link', ['_self' => 'Abrir na mesma aba', '_blank' => 'Abrir em outra aba', '_lightbox' => 'Abrir um Lighbox'], isset($content)?$content->target_link:'_lightbox', [
                    'class'=>'form-select', 'id'=>'heard']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'3/2',
                            'data-height'=>'200',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($content)?$content->path_image<>''?url('storage/'.$content->path_image):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
</div>
{{-- end row --}}
