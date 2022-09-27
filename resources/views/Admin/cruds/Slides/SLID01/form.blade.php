<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3 col-12 col-sm-6">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="mb-3 col-12 col-sm-6">
                    {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                </div>
            </div>
            <div class="mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::text('description', null, ['class'=>'form-control', 'id'=>'description']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('title_button', 'Título Botão', ['class'=>'form-label']) !!}
                {!! Form::text('title_button', null, ['class'=>'form-control', 'id'=>'title_button']) !!}
            </div>
            <div class="row">
                <div class="mb-3 col-12 col-sm-8">
                    {!! Form::label(null, 'Link Botão', ['class'=>'form-label']) !!}
                    {!! Form::url('link_button', null, ['class'=>'form-control','parsley-type'=>'url']) !!}
                </div>
                <div class="mb-3 col-12 col-sm-4">
                    {!! Form::label('target_link_button', 'Redirecionar', ['class'=>'form-label']) !!}
                    {!! Form::select('target_link_button', ['_self' => 'Na mesma aba', '_target' => 'Em nova aba'], isset($slide)?$slide->target_link_button:'_self', [
                        'class'=>'form-select', 'id'=>'target_link_button']) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('position_content', 'Posição do Conteudo', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Informa em qual posição o conteúdo do banner ficará"></i>
                </div>
                {!! Form::select('position_content', ['start' => 'A esquerda', 'center' => 'No Centro', 'end' => 'A direita'], isset($slide)?$slide->position_content:'start', [
                    'class'=>'form-select', 'id'=>'position_content']) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativar Banner', ['class'=>'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end col-12 --}}
    <div class="col-12 col-lg-6">
        <div class="card card-body">
            <div class="mb-3">
                <div class="mb-3">
                    {!! Form::label('file', 'Imagem Desktop', ['class'=>'form-label']) !!}
                    {!! Form::file('path_archive', [
                        'data-plugins'=>'dropify',
                        'data-height'=>'150',
                        'data-max-file-size-preview'=>'2M',
                        'accept'=>'image/*',
                        'data-default-file'=> isset($slide)?$slide->path_image_desktop<>''?url('storage/'.$slide->path_image_desktop):'':'',
                    ]) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem Mobile', ['class'=>'form-label']) !!}
                    <label class="area-input-image-crop" for="inputImage" title="Upload image file">
                        {!! Form::file('path_image_mobile', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'4/7',
                            'data-height'=>'150',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($slide)?$slide->path_image_mobile<>''?url('storage/'.$slide->path_image_mobile):'':'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('inputImage', 'Imagem Flutuante png', ['class'=>'form-label']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Imagem que ficará visível sobre a imagem do desktop e ao lado do conteúdo de texto no banner."></i>
                    </div>
                    <label class="area-input-image-crop" for="inputImage" title="Upload image file">
                        {!! Form::file('path_image_png', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-scale'=>'1/1',
                            'data-height'=>'150',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($slide)?$slide->path_image_png<>''?url('storage/'.$slide->path_image_png):'':'',
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
