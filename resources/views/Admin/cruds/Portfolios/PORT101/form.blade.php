<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle', 'Subtítulo', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle', null, ['class' => 'form-control', 'id' => 'subtitle']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class' => 'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class' => 'form-control',
                    'id' => 'description',
                    'data-parsley-trigger' => 'keyup',
                    'data-parsley-minlength' => '20',
                    'data-parsley-maxlength' => '300',
                    'data-parsley-minlength-message' => 'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold' => '10',
                ]) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar Portfólio', ['class' => 'form-check-label']) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                {!! Form::label('featured', 'Destacar Portfólio', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>

    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    <div class="d-flex align-items-center mb-1">
                        <div class="d-flex">
                            {!! Form::label('inputImage', 'Imagem Miniatura', ['class' => 'form-label mb-0']) !!}
                            <i class="text-danger">*</i>
                        </div>
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibida na listagem dos protifólios nos boxs."></i>
                    </div>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_box', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_box->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_box->width, // px
                            'data-min-height' => $cropSetting->path_image_box->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'required' => isset($portfolio) ? false : true,
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($portfolio)
                                ? ($portfolio->path_image_box != ''
                                    ? url('storage/' . $portfolio->path_image_box)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('inputImage', 'Imagem Desktop', ['class' => 'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibida no lightbox do protifólio como background desktop."></i>
                    </div>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_desktop', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_desktop->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_desktop->width, // px
                            'data-min-height' => $cropSetting->path_image_desktop->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($portfolio)
                                ? ($portfolio->path_image_desktop != ''
                                    ? url('storage/' . $portfolio->path_image_desktop)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div>
                <div class="container-image-crop">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('inputImage', 'Image Mobile', ['class' => 'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibida no lightbox do protifólio como background mobile."></i>
                    </div>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_mobile', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_mobile->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_mobile->width, // px
                            'data-min-height' => $cropSetting->path_image_mobile->height, // px
                            'data-box-height' => '180', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($portfolio)
                                ? ($portfolio->path_image_mobile != ''
                                    ? url('storage/' . $portfolio->path_image_mobile)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 ">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <h4 class="mb-3 mt-0">Caso você queira cadastrar algum link para uma página externa
                    <small>(Opcional)</small>
                </h4>
                <div class="col-12 col-sm-8">
                    {!! Form::label(null, 'Link do botão', ['class' => 'form-label']) !!}
                    {!! Form::url('link', null, ['class' => 'form-control', 'parsley-type' => 'url', 'id' => 'targetUrl']) !!}
                </div>
                <div class="col-12 col-sm-4">
                    {!! Form::label('target_link_button', 'Redirecionar para', ['class' => 'form-label']) !!}
                    {!! Form::select('target_link_button', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, [
                        'class' => 'form-select',
                        'id' => 'target_link_button',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="card card-body position-relative" id="tooltip-container">
            <h4 class="mb-3 mt-0">Cores utilizadas no projeto <small>(Opcional)</small></h4>
            <div class="row receiverCloneInput">
                @if (isset($portfolio))
                    @foreach (explode(',', $portfolio->colors) as $color)
                        <div class="inputCloned col-12 col-lg-2 d-flex align-items-center mb-2">
                            {!! Form::text('colors[]', $color, ['class' => 'form-control colorpicker-default']) !!}
                            <a href="javascript:void(0)" class="mdi mdi-trash-can mdi-24px text-danger ms-2"
                                onclick="cloneInputsColorPicker(this, '', '', 'delete')"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Excluir cor"></a>
                        </div>
                    @endforeach
                @endif
            </div>
            <button type="button" onclick="cloneInputsColorPicker(this, '.targetCloneInput', '.receiverCloneInput')"
                class="btn btn-primary font-18 mt-3 d-flex align-items-center justify-content-center">Adicionar cor <i
                    class="mdi mdi-plus-circle mdi-24px ms-2"></i></button>
            <div class="targetCloneInput invisible position-absolute">
                <div class="inputCloned col-12 col-lg-2 d-flex align-items-center mb-2">
                    {!! Form::text('colors[]', '#4a81d4', ['class' => 'form-control']) !!}
                    <a href="javascript:void(0)" class="mdi mdi-trash-can mdi-24px text-danger ms-2"
                        onclick="cloneInputsColorPicker(this, '', '', 'delete')" data-bs-container="#tooltip-container"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Excluir cor"></a>
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}
