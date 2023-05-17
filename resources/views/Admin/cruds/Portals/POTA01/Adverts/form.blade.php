{!! Form::hidden('type', $request->type) !!}

<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            @if ($request->type == 'category')
                <div class="mb-3">
                    {!! Form::label('category_id', 'Categoria', ['class'=>'form-label']) !!}
                    {!! Form::select('category_id', $categories, null, [
                        'class'=>'form-select',
                        'id'=>'category_id',
                        'required'=>'required',
                        'placeholder' => '--'
                    ]) !!}
                </div>
            @endif
            <div class="mb-3">
                {!! Form::label('position', 'Posição do Anúncio', ['class'=>'form-label']) !!}
                {!! Form::select('position', $positions, null, [
                    'class'=>'form-select',
                    'id'=>'position',
                    'required'=>'required',
                    'placeholder' => '--'
                ]) !!}
            </div>
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
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 row">
                <div class="col-12 col-sm-8">
                    {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                    {!! Form::url('link', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                </div>
                <div class="col-12 col-sm-4">
                    {!! Form::label('link_target', 'Redirecionar para', ['class'=>'form-label']) !!}
                    {!! Form::select('link_target', ['_self' => 'Na mesma aba', '_target' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Thumbnail', ['class'=>'form-label']) !!}
                    <small class="ms-2 receiverDimension text-warning"></small>
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
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}

<script>
    function dimensions(value){
        switch (value) {
            case 'homeBottomPodcast':
                var dimension = 'Dimensões proporcionais mínimas 375x305px';
            break;
            case 'bottomLatestNews':
                var dimension = 'Dimensões proporcionais mínimas 1235x144px';
            break;
            case 'categoryInnerBeginPage':
                var dimension = 'Dimensões proporcionais mínimas 582x83px';
            break;
            case 'categoryInnerEndPage':
                var dimension = 'Dimensões proporcionais mínimas 1235x144px';
            break;
            case 'podcastBeforeArticle':
                var dimension = 'Dimensões proporcionais mínimas 375x305px';
            break;
            case 'podcastAfterArticle':
                var dimension = 'Dimensões proporcionais mínimas 375x305px';
            break;
        }

        $('.receiverDimension').text(dimension);
    }
    $(function(){
        dimensions('{{isset($advert)?$advert->position:''}}')
        $('#position').on('change', function(){
            var value = $(this).val()
            dimensions(value)
        })
    })
</script>

{{-- Essa estrutura pode ser usada junto ao label do input para aparecer o ícone de duvida do lado do mesmo. pode usar a estutura abaixo substituindo o "Form::label" --}}
{{-- <div class="d-flex align-items-center mb-1">
    {!! Form::label('validationCustom01', 'First name', ['class'=>'form-label']) !!}
    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-original-title="Coloque a mensagem desejado aqui"></i>
</div> --}}
