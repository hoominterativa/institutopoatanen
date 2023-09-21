<div class="tab-content">
        <div class="row col-12">
            <div class="col-12 col-lg-6">
                <div class="card card-body" id="tooltip-container">
                    <div class="mb-3">
                        {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title']) !!}
                    </div>
                    
                    <div class="col-12">
                        <div class="normal-editor__content mb-3">
                            {!! Form::label('text', 'Descrição', ['class'=>'form-label']) !!}
                            <small class="ms-1"><b>Recomendamos salvar de tempo em tempo caso a matéria seja extensa</b></small>
                            {!! Form::textarea('text', null, [
                                'class'=>'form-control normal-editor',
                                'id'=>'text',
                            ]) !!}
                        </div>
                    </div>
                    <div class="mb-3 form-check">
                        {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                        {!! Form::label('active', 'Ativar Tópico', ['class' => 'form-check-label']) !!}
                    </div>
                </div>
                {{-- end card-body --}}
            </div>
            {{-- end col-12 --}}
            <div class="col-12 col-lg-6">
                <div class="card card-body">
                    <div class="mb-3">
                        <div class="container-image-crop">
                            {!! Form::label('inputImage', 'Imagem do Banner Desktop', ['class' => 'form-label']) !!}
                            <small class="ms-2">Dimensões proporcionais mínimas
                                {{ $cropSetting->path_image_desktop->width }}x{{ $cropSetting->path_image_desktop->height }}px!</small>
                            <label class="area-input-image-crop" for="inputImage">
                                {!! Form::file('path_image_desktop', [
                                    'id' => 'inputImage',
                                    'class' => 'inputImage',
                                    'data-status' => $cropSetting->path_image_desktop->activeCrop, // px
                                    'data-min-width' => $cropSetting->path_image_desktop->width, // px
                                    'data-min-height' => $cropSetting->path_image_desktop->height, // px
                                    'data-box-height' => '250', // Input height in the form
                                    'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                    'data-default-file' => isset($topic)
                                        ? ($topic->path_image_desktop != ''
                                            ? url('storage/' . $topic->path_image_desktop)
                                            : '')
                                        : '',
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
</div>
