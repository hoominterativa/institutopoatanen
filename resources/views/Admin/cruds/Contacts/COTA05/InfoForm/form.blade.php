@if ($contact)
    {!! Form::model($contact, ['route' => ['admin.cota05.update', $contact->id],'class' => 'parsley-validate','files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('slug', $contact->slug) !!}
    {!! Form::hidden('active', $contact->active) !!}
    {!! Form::hidden('active_banner',  $contact->active_banner ) !!}
@else
    {!! Form::model(null, ['route' => 'admin.cota05.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title_form', 'Título', ['class' => 'form-label mb-0']) !!}
                {!! Form::text('title_form', null, ['class' => 'form-control', 'id' => 'title_form']) !!}
            </div>
            <div class="col-12">
                <div class="normal-editor__content mb-3">
                    {!! Form::label('description_form', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description_form', null, [ 'class'=>'form-control normal-editor', 'id'=>'normal-editor', ]) !!}
                </div>
            </div>
        </div>
        <div class="mb-3 form-check">
            {!! Form::checkbox('active_form', '1', null, ['class'=>'form-check-input', 'id'=>'active_form']) !!}
            {!! Form::label('active_form', 'Ativar exbição?', ['class'=>'form-check-label']) !!}
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image_icon_form->width }}x{{ $cropSetting->path_image_icon_form->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_icon_form', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image_icon_form->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image_icon_form->width, // px
                            'data-min-height' => $cropSetting->path_image_icon_form->height, // px
                            'data-box-height' => '300', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file' => isset($contact)
                                ? ($contact->path_image_icon_form != ''
                                    ? url('storage/' . $contact->path_image_icon_form)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [ 'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0', 'type' => 'submit', ]) !!}
    </div>
</div>
{!! Form::close() !!}
