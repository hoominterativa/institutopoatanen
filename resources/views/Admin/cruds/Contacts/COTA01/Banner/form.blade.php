{!! Form::model($contact, ['route' => ['admin.cota01.update', $contact->id], 'class'=>'parsley-validate', 'files' => true, 'method' => 'PUT']) !!}
    <input type="hidden" name="title_page" value="{{$contact->title_page}}">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title_banner', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title_banner', null, ['class'=>'form-control', 'id'=>'title_banner']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('description_banner', 'Mensagem', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description_banner', null, [
                        'class'=>'form-control',
                        'id'=>'description_banner',
                        'data-parsley-trigger'=>'keyup',
                        'data-parsley-minlength'=>'20',
                        'data-parsley-maxlength'=>'350',
                        'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                        'data-parsley-validation-threshold'=>'10',
                    ]) !!}
                </div>
                <div class="col-12">
                    {!! Form::label('background_color', 'Cor do background', ['class' => 'form-label']) !!}
                    {!! Form::text('background_color', null, ['class' => 'form-control colorpicker-default','id' => 'background_color',]) !!}
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Desktop', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas
                            {{ $cropSetting->path_image_desktop_banner->width }}x{{ $cropSetting->path_image_desktop_banner->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_desktop_banner', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->path_image_desktop_banner->activeCrop, // px
                                'data-min-width' => $cropSetting->path_image_desktop_banner->width, // px
                                'data-min-height' => $cropSetting->path_image_desktop_banner->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                                'data-default-file' => isset($contact)? ($contact->path_image_desktop_banner != ''? url('storage/' . $contact->path_image_desktop_banner): ''): '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
                <div class="mb-3">
                    <div class="container-image-crop">
                        {!! Form::label('inputImage', 'Background Mobile', ['class' => 'form-label']) !!}
                        <small class="ms-2">Dimensões proporcionais mínimas {{ $cropSetting->path_image_mobile_banner->width }}x{{ $cropSetting->path_image_mobile_banner->height }}px!</small>
                        <label class="area-input-image-crop" for="inputImage">
                            {!! Form::file('path_image_mobile_banner', [
                                'id' => 'inputImage',
                                'class' => 'inputImage',
                                'data-status' => $cropSetting->path_image_mobile_banner->activeCrop, // px
                                'data-min-width' => $cropSetting->path_image_mobile_banner->width, // px
                                'data-min-height' => $cropSetting->path_image_mobile_banner->height, // px
                                'data-box-height' => '170', // Input height in the form
                                'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                                'data-default-file' => isset($contact)? ($contact->path_image_mobile_banner != ''? url('storage/' . $contact->path_image_mobile_banner): ''): '',
                            ]) !!}
                        </label>
                    </div><!-- END container image crop -->
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
    </div>
{!! Form::close() !!}
