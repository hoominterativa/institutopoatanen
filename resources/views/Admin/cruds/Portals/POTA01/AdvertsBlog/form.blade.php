@if (isset($advert))
    {!! Form::model($advert, ['route' => ['admin.pota01.adverts.update', $advert->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.pota01.adverts.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
{!! Form::hidden('position', 'blogInner') !!}
{!! Form::hidden('blog_id', $portal->id) !!}

    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        {!! Form::label(null, 'Início da Exibição', ['class'=>'form-label']) !!}
                        {!! Form::text('date_start', null, [
                            'class'=>'form-control',
                            'data-provide'=>'datepicker',
                            'data-date-autoclose'=>'true',
                            'data-date-format'=>'dd/mm/yyyy',
                            'data-date-language'=>'pt-BR',
                        ])!!}
                    </div>
                    <div class="col-12 col-sm-6">
                        {!! Form::label(null, 'Horário', ['class'=>'form-label']) !!}
                        <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                            {!! Form::text('hour_start', null, ['class'=>'form-control']) !!}
                            <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        {!! Form::label(null, 'Fim da Exibição', ['class'=>'form-label']) !!}
                        {!! Form::text('date_end', null, [
                            'class'=>'form-control',
                            'data-provide'=>'datepicker',
                            'data-date-autoclose'=>'true',
                            'data-date-format'=>'dd/mm/yyyy',
                            'data-date-language'=>'pt-BR',
                        ])!!}
                    </div>
                    <div class="col-12 col-sm-6">
                        {!! Form::label(null, 'Horário', ['class'=>'form-label']) !!}
                        <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                            {!! Form::text('hour_end', null, ['class'=>'form-control']) !!}
                            <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('adsense', 'Google Adsense', ['class'=>'form-label']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Insira o código completo do adsense aqui."></i>
                </div>
                {!! Form::textarea('adsense', null, [
                    'class'=>'form-control',
                    'id'=>'message',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-minlength'=>'20',
                    'data-parsley-maxlength'=>'100',
                    'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                    'data-parsley-validation-threshold'=>'10',
                ]) !!}
            </div>
            <div class="mb-3 row">
                <div class="col-12 col-sm-8">
                    {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                    {!! Form::url('link', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                </div>
                <div class="col-12 col-sm-4">
                    {!! Form::label('link_target', 'Redirecionar para', ['class'=>'form-label']) !!}
                    {!! Form::select('link_target', ['_self' => 'Na mesma aba', '_blank' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Thumbnail', ['class'=>'form-label']) !!}
                    <small class="ms-2 receiverDimension text-warning">Dimensões proporcionais mínimas 613x162px</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->Adverts->path_image->activeCrop, // px
                            'data-min-width'=>$cropSetting->Adverts->path_image->width, // px
                            'data-min-height'=>$cropSetting->Adverts->path_image->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($advert)?($advert->path_image<>''?url('storage/'.$advert->path_image):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class'=>'form-check-label']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
