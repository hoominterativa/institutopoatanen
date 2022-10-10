<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex">
                    {!! Form::label('heard', 'Categoria', ['class'=>'form-label']) !!}
                    <i class="text-danger">*</i>
                </div>
                {!! Form::select('category_id', $categories, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'required'=>'required',
                    'placeholder' => 'Informe a categoria do portifólio'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('heard', 'Subcategoria', ['class'=>'form-label']) !!}
                {!! Form::select('subcategory_id', $subcategories, null, [
                    'class'=>'form-select',
                    'id'=>'heard',
                    'placeholder' => 'Informe a subcategoria do portifólio'
                ]) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    <i class="text-danger">*</i>
                </div>
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Breve descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'rows'=>'7',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'300',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir uma descrição de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('text', 'Detalhes', ['class'=>'form-label', 'id' => 'text']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'text',
                ]) !!}
            </div>
            <div class="d-flex">
                <div class="form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                    {!! Form::label('active', 'Ativar Exibição', ['class'=>'form-check-label']) !!}
                </div>
                <div class="form-check me-3">
                    {!! Form::checkbox('featured', '1', null, ['class'=>'form-check-input', 'id'=>'featured']) !!}
                    {!! Form::label('featured', 'Destacar na home', ['class'=>'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-12 --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">

            <div class="mb-3">
                <div class="container-image-crop">
                    <div class="d-flex align-items-center mb-1">
                        <div class="d-flex">
                            {!! Form::label('inputImage', 'Image Miniatura', ['class'=>'form-label mb-0']) !!}
                            <i class="text-danger">*</i>
                        </div>
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibida na listagem dos protifólios nos boxs."></i>
                    </div>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_box', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'3/4',
                            'data-height'=>'212',
                            'required'=>isset($portfolio)?false:true,
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($portfolio)?$portfolio->path_image_box<>''?url('storage/'.$portfolio->path_image_box):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('inputImage', 'Image Interna Esquerda', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibida na interna do protifólio no lado esquerdo da sua tela."></i>
                    </div>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_left', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'3/7',
                            'data-height'=>'212',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($portfolio)?$portfolio->path_image_left<>''?url('storage/'.$portfolio->path_image_left):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div>
                <div class="container-image-crop">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('inputImage', 'Image Interna Direita', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibida na interna do protifólio no lado direito da sua tela."></i>
                    </div>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_right', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'4/3',
                            'data-height'=>'212',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($portfolio)?$portfolio->path_image_right<>''?url('storage/'.$portfolio->path_image_right):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-12 --}}
    <div class="col-12">
        <div class="card card-body position-relative" id="tooltip-container">
            <h4 class="mb-3 mt-0">Cores utilizadas no projeto <small>(Opcional)</small></h4>
            <div class="row receiverCloneInput">
                @foreach (explode(',', $portfolio->colors) as $color)
                    <div class="inputCloned col-12 col-lg-2 d-flex align-items-center mb-2">
                        {!! Form::text('colors[]', $color, ['class'=>'form-control colorpicker-default',])!!}
                        <a href="javascript:void(0)" class="mdi mdi-trash-can mdi-24px text-danger ms-2" onclick="cloneInputsColorPicker(this, '', '', 'delete')" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Excluir cor"></a>
                    </div>
                @endforeach
            </div>
            <button type="button" onclick="cloneInputsColorPicker(this, '.targetCloneInput', '.receiverCloneInput')" class="btn btn-primary font-18 mt-3 d-flex align-items-center justify-content-center">Adicionar cor <i class="mdi mdi-plus-circle mdi-24px ms-2"></i></button>
            <div class="targetCloneInput invisible position-absolute">
                <div class="inputCloned col-12 col-lg-2 d-flex align-items-center mb-2">
                    {!! Form::text('colors[]', '#4a81d4', ['class'=>'form-control'])!!}
                    <a href="javascript:void(0)" class="mdi mdi-trash-can mdi-24px text-danger ms-2" onclick="cloneInputsColorPicker(this, '', '', 'delete')" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Excluir cor"></a>
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-12 --}}
    <h4 class="mb-3 mt-0">Depoimento <small>(Opcional)</small></h4>

    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3 col-12 col-sm-7">
                    {!! Form::label('title_testimonial', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title_testimonial', null, ['class'=>'form-control', 'id'=>'title_testimonial']) !!}
                </div>
                <div class="mb-3 col-12 col-sm-5">
                    {!! Form::label('subtitle_testimonial', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle_testimonial', null, ['class'=>'form-control', 'id'=>'subtitle_testimonial']) !!}
                </div>
            </div>
            <div>
                {!! Form::label('description', 'Depoimento', ['class'=>'form-label']) !!}
                {!! Form::textarea('text_testimonial', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'rows'=>'7',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'800',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir uma depoimento de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-12 --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div>
                <div class="container-image-crop">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('inputImage', 'Image Interna Esquerda', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Será exibida no depoimento do protifólio."></i>
                    </div>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_testimonial', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'1/1',
                            'data-height'=>'240',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($portfolio)?$portfolio->path_image_testimonial<>''?url('storage/'.$portfolio->path_image_testimonial):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-12 --}}
</div>
{{-- end row --}}
