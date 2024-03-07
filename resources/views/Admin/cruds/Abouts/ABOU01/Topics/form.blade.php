@if (isset($topic))
    {!! Form::model($topic, ['route' => ['admin.abou01.topic.update', $topic->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.abou01.topic.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    {!! Form::hidden('about_id', $about->id) !!}
@endif
    <div class="row col-12">
        <div class="col-12 col-lg-6 ">
            <div class="card card-body wrapper-links my-2 border px-2 py-3" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="basic-editor__content mb-3">
                    {!! Form::label('basic-editor', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description', null, [
                        'class'=>'form-control basic-editor',
                        'id'=>'basic-editor',
                    ]) !!}
                </div>
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body wrapper-links my-2 border px-2 py-3" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Ícone', ['class'=>'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->Topic->path_image_icon->width}}x{{$cropSetting->Topic->path_image_icon->height}}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_icon', [
                                'id'=>'inputImage',
                                'class'=>'inputImage',
                                'data-status'=>$cropSetting->Topic->path_image_icon->activeCrop, // px
                                'data-min-width'=>$cropSetting->Topic->path_image_icon->width, // px
                                'data-min-height'=>$cropSetting->Topic->path_image_icon->height, // px
                                'data-box-height'=>'225', // Input height in the form
                                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp,.svg',
                                'data-default-file'=> isset($topic)?($topic->path_image_icon<>''?url('storage/'.$topic->path_image_icon):''):'',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        {{-- end card --}}
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
