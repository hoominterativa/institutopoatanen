{!! Form::model($workWith, ['route' => ['admin.wowi01.update', $workWith->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
    <input type="hidden" name="active" value="{{$workWith->active}}">
    <input type="hidden" name="featured_menu" value="{{$workWith->featured_menu}}">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <h4 class="mb-4">
                    Infomações da seção
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Na seção de Conteúdo essas informações aparecem logo no topo."></i>
                </h4>
                <div class="mb-3">
                    {!! Form::label('title_section_content', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title_section_content', null, ['class'=>'form-control', 'id'=>'title_section_content']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('subtitle_section_content', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle_section_content', null, ['class'=>'form-control', 'id'=>'subtitle_section_content']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('description_section_content', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description_section_content', null, [
                        'class'=>'form-control',
                        'id'=>'description_section_content',
                        'data-parsley-trigger'=>'keyup',
                        'data-parsley-minlength'=>'20',
                        'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                        'data-parsley-validation-threshold'=>'10',
                    ]) !!}
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <h4 class="mb-4">
                    Infomações
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Na seção de Conteúdo essas informações aparecem ao lado da imagem."></i>
                </h4>
                <div class="row">
                    <div class="mb-3 col-lg-6">
                        {!! Form::label('title_content', 'Título', ['class'=>'form-label']) !!}
                        {!! Form::text('title_content', null, ['class'=>'form-control', 'id'=>'title_content']) !!}
                    </div>
                    <div class="mb-3 col-lg-6">
                        {!! Form::label('subtitle_content', 'Subtítulo', ['class'=>'form-label']) !!}
                        {!! Form::text('subtitle_content', null, ['class'=>'form-control', 'id'=>'subtitle_content']) !!}
                    </div>
                </div>
                <div class="mb-3">
                    {!! Form::label('description_content', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description_content', null, [
                        'class'=>'form-control',
                        'id'=>'description_content',
                        'rows'=>5,
                        'data-parsley-trigger'=>'keyup',
                        'data-parsley-minlength'=>'20',
                        'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                        'data-parsley-validation-threshold'=>'10',
                    ]) !!}
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_content->width}}x{{$cropSetting->path_image_content->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_content', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->path_image_content->activeCrop, // px
                                'data-min-width'=>$cropSetting->path_image_content->width, // px
                                'data-min-height'=>$cropSetting->path_image_content->height, // px
                                'data-box-height'=>'200', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file'=> isset($workWith)?($workWith->path_image_content<>''?url('storage/'.$workWith->path_image_content):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
