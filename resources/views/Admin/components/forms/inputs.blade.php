{{--
    DOC
    https://laravelcollective.com/docs/6.x/html

--}}

{{-- Input Default --}}
<div class="mb-3">
    {!! Form::label('title', 'First name', ['class'=>'form-label']) !!}
    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
</div>

{{-- Date Picker --}}
<div class="mb-3">
    {!! Form::label(null, 'Autoclose', ['class'=>'form-label']) !!}
    {!! Form::text('date', null, [
            'class'=>'form-control',
            'required'=>'required',
            'data-provide'=>'datepicker',
            'data-date-autoclose'=>'true',
            'data-date-format'=>'dd/mm/yyyy',
            'data-date-language'=>'pt-BR',
        ])!!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Month View', ['class'=>'form-label']) !!}
    {!! Form::text('date', null, [
            'class'=>'form-control',
            'required'=>'required',
            'data-provide'=>'datepicker',
            'data-date-format'=>'MM yyyy',
            'data-date-min-view-mode'=>'1',
            'data-date-language'=>'pt-BR',
        ])!!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Year View', ['class'=>'form-label']) !!}
    {!! Form::text('date', null, [
            'class'=>'form-control',
            'required'=>'required',
            'data-provide'=>'datepicker',
            'data-date-min-view-mode'=>'2',
            'data-date-language'=>'pt-BR',
        ])!!}
</div>

{{-- Color Picker --}}
<div class="mb-3">
    {!! Form::label('colorpicker-default', 'Simple input field', ['class'=>'form-label']) !!}
    {!! Form::text('date', '#4a81d4', [
            'class'=>'form-control colorpicker-default',
            'id'=>'colorpicker-default',
            'required'=>'required',
        ])!!}
</div>

{{-- Clock Piker --}}
<div class="mb-3">
    {!! Form::label(null, 'Auto close', ['class'=>'form-label']) !!}
    <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
        {!! Form::text('clock', '13:14', ['class'=>'form-control']) !!}
        <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
    </div>
</div>

{{-- Inputs Mask --}}
<div class="mb-3">
    {!! Form::label(null, 'Date', ['class'=>'form-label']) !!}
    {!! Form::text('date', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'00/00/0000',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Hour', ['class'=>'form-label']) !!}
    {!! Form::text('hour', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'00:00:00',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Date & Hour', ['class'=>'form-label']) !!}
    {!! Form::text('data_hour', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'00/00/0000 00:00:00',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'ZIP Code', ['class'=>'form-label']) !!}
    {!! Form::text('data_hour', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'00000-000',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Money', ['class'=>'form-label']) !!}
    {!! Form::text('money', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'#.##0,00',
        'data-reverse'=>'true',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Phone', ['class'=>'form-label']) !!}
    {!! Form::text('phone', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'(00) 0000-0000',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Celphone', ['class'=>'form-label']) !!}
    {!! Form::text('celphone', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'(00) 00000-0000',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'CPF', ['class'=>'form-label']) !!}
    {!! Form::text('cpf', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'000.000.000-00',
        'data-reverse'=>'true',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'CNPJ', ['class'=>'form-label']) !!}
    {!! Form::text('cnpj', null, [
        'class'=>'form-control',
        'data-toggle'=>'input-mask',
        'required'=>'required',
        'data-mask-format'=>'00.000.000/0000-00',
        'data-reverse'=>'true',
    ]) !!}
</div>

{{-- Select --}}
<div class="mb-3">
    {!! Form::label('heard', 'Select', ['class'=>'form-label']) !!}
    {!! Form::select('options', ['1' => 'Option 1', '2' => 'Option 2', '3' => 'Option 2'], null, [
        'class'=>'form-select',
        'id'=>'heard',
        'required'=>'required',
        'placeholder' => 'Pick a size...'
    ]) !!}
</div>

{{-- Validate type --}}
<div class="mb-3">
    {!! Form::label(null, 'Equal To', ['class'=>'form-label']) !!}
    {!! Form::password('password', [
            'class'=>'form-control',
            'id'=>'pass2',
            'required'=>'required',
            'placeholder'=>'Senha',
        ])!!}
    {!! Form::password('password_confirmation', [
            'class'=>'form-control mt-3',
            'required'=>'required',
            'data-parsley-equalto'=>"#pass2",
            'placeholder'=>'Confirmar senha',
        ])!!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'E-mail', ['class'=>'form-label']) !!}
    {!! Form::email('email', null, [
        'class'=>'form-control',
        'required'=>'required',
        'parsley-type'=>'email',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'URL', ['class'=>'form-label']) !!}
    {!! Form::url('url', null, [
        'class'=>'form-control',
        'required'=>'required',
        'parsley-type'=>'url',
    ]) !!}
</div>

{{-- Max, Min, Regular Exp Value --}}
<div class="mb-3">
    {!! Form::label(null, 'Min Length', ['class'=>'form-label']) !!}
    {!! Form::text('min_length', null, [
        'class'=>'form-control',
        'required'=>'required',
        'data-parsley-minlength'=>'6',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Max Length', ['class'=>'form-label']) !!}
    {!! Form::text('max_length', null, [
        'class'=>'form-control',
        'required'=>'required',
        'data-parsley-maxlength'=>'6',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Range Length', ['class'=>'form-label']) !!}
    {!! Form::text('range_length', null, [
        'class'=>'form-control',
        'required'=>'required',
        'data-parsley-length'=>'[5,10]',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label(null, 'Regular Exp', ['class'=>'form-label']) !!}
    {!! Form::text('hex_color', null, [
        'class'=>'form-control',
        'required'=>'required',
        'data-parsley-pattern'=>'#[A-Fa-f0-9]{6}',
        'placeholder'=>'Hex. Color',
    ]) !!}
</div>
<div class="mb-3">
    {!! Form::label('message', 'Mensagem', ['class'=>'form-label']) !!}
    {!! Form::textarea('description', null, [
        'class'=>'form-control',
        'id'=>'message',
        'required'=>'required',
        'data-parsley-trigger'=>'keyup',
        'data-parsley-minlength'=>'20',
        'data-parsley-maxlength'=>'100',
        'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
        'data-parsley-validation-threshold'=>'10',
    ]) !!}
</div>

{{-- Radios, Checkbox --}}
<div class="mb-3 radio">
    {!! Form::radio('radio', '1', null, ['id'=>'genderM', 'required'=>'required']) !!}
    {!! Form::label('genderM', 'Male') !!}
</div>
<div class="mb-3 radio">
    {!! Form::radio('radio', '2', null, ['id'=>'genderF', 'required'=>'required']) !!}
    {!! Form::label('genderF', 'Female',) !!}
</div>
<div class="mb-3 form-check">
    {!! Form::checkbox('checkbox', '1', null, ['class'=>'form-check-input', 'id'=>'invalidCheck', 'required'=>'required']) !!}
    {!! Form::label('invalidCheck', 'Checkbox 1', ['class'=>'form-check-label']) !!}
</div>
<div class="mb-3 form-check">
    {!! Form::checkbox('checkbox', '2', null, ['class'=>'form-check-input', 'id'=>'invalidCheck1', 'required'=>'required']) !!}
    {!! Form::label('invalidCheck1', 'Checkbox 2', ['class'=>'form-check-label']) !!}
</div>

{{-- CK Editor --}}
<div class="basic-editor__content mb-3">
    {!! Form::label('basic-editor', 'Basic Editor', ['class'=>'form-label']) !!}
    {!! Form::textarea('description', null, [
        'class'=>'form-control basic-editor',
        'id'=>'basic-editor',
    ]) !!}
</div>
<div class="normal-editor__content mb-3">
    {!! Form::label('normal-editor', 'Normal Editor', ['class'=>'form-label']) !!}
    {!! Form::textarea('description', null, [
        'class'=>'form-control normal-editor',
        'id'=>'normal-editor',
    ]) !!}
</div>
<div class="complete-editor__content mb-3">
    {!! Form::label('complete-editor', 'Complete Editor', ['class'=>'form-label']) !!}
    {!! Form::textarea('description', null, [
        'class'=>'form-control complete-editor',
        'id'=>'complete-editor',
    ]) !!}
</div>

{{-- Upload File --}}
<div class="mb-3">
    {!! Form::label('file', 'Arquivo', ['class'=>'form-label']) !!}
    {!! Form::file('path_archive', [
        'data-plugins'=>'dropify',
        'data-height'=>'300',
        'data-max-file-size-preview'=>'2M',
        'accept'=>'*',
        'data-default-file'=> isset($test)?($test->path_archive<>''?url('storage/'.$test->path_archive):''):'',
    ]) !!}
</div>

{{--
    Image Crop
    Enviar para a view as dimensões do CROP com a aestrutura abaixo, vc poderá debugar essa funcao para saber qual o seu retorno
    'cropSetting' => getCropImage('Module', 'MODEL')
--}}
<div class="mb-3">
    <div class="container-image-crop">
        {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
        <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}}px!</small>
        <label class="area-input-image-crop" for="inputImage">
            {!! Form::file('path_image', [
                'id'=>'inputImage',
                'class'=>'inputImage',
                'data-status'=>$cropSetting->path_image->activeCrop, // px
                'data-min-width'=>$cropSetting->path_image->width, // px
                'data-min-height'=>$cropSetting->path_image->height, // px
                'data-box-height'=>'225', // Input height in the form
                'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                'data-default-file'=> isset($test)?($test->path_image<>''?url('storage/'.$test->path_image):''):'',
            ]) !!}
        </label>
    </div><!-- END container image crop -->
</div>

{{-- Image Multiple --}}
<div class="mb-3">
    <div class="uploadMultipleImage">
        <label for="path_image" class="content-message">
            {!! Form::file('path_image[]', [ 'id' => 'path_image', 'multiple' => 'multiple', 'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp', 'class' => 'inputGetImage']) !!}
            <i class="mdi mdi-cloud-upload-outline mdi-36px"></i>
            <h4 class="title">Solte as imagens aqui ou clique para fazer upload.</h4>
            <span class="text-muted font-13">Carregar imagens com no máximo <strong>2mb</strong></span>
        </label>
        <div id="containerMultipleImages" class="mt-3"></div>
    </div>
</div>

{{--
    URL de redirecionamento
    Usar em conjunto com a função getUri($url) para proteção dos links do mesmo domínio.
    Caso queira saber o que a função faz, o mesmo está no arquivo HelperComposer.php na linha 193
--}}
<div class="wrapper-links my-2 border px-2 py-3">
    <ul class="nav nav-pills navtab-bg nav-justified">
        <li class="nav-item">
            <a href="#linkPages" data-bs-toggle="tab" aria-expanded="false" class="nav-link py-1">
                <div class="d-flex align-items-center justify-content-center">
                    Link para página do site
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Pode ser usado para cadastrar um link de redirecionamento para uma página do site ou conteúdo específico."></i>
                </div>
            </a>
        </li>
        <li class="nav-item">
            <a href="#linkExternal" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
                <div class="d-flex align-items-center justify-content-center">
                    Link para página externa
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-22 ms-2 btn-icon cloneTypeButton"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="pode ser usado para cadastrar links de redirecionamento para outros sites"></i>
                </div>
            </a>
        </li>
    </ul> {{-- END .nav-tabs --}}
    <div class="tab-content">
        <div class="tab-pane" id="linkPages">
            <div class="row">
                <div class="dropdown mb-3 col-12">
                    {!! Form::label(null, 'Selecione uma página do site', ['class'=>'form-label']) !!}
                    <button class="form-control dropdown-toggle text-start" type="button" id="dropdownPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Páginas <i class="mdi mdi-chevron-down float-end"></i>
                    </button>
                    <ul class="dropdown-menu multi-level col-12" aria-labelledby="dropdownPages">
                        @foreach (listPage() as $page)
                            <li class="dropdown {{$page->dropdown?'dropdown-submenu':''}}">
                                <a href="{{$page->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl" data-bs-toggle="dropdown">{{$page->title}}</a>
                                @if ($page->dropdown)
                                    <ul class="dropdown-menu">
                                        @foreach ($page->dropdown as $itens)
                                            <li><a href="{{$itens->route}}" class="dropdown-item" data-bs-toggle="setUrl" data-target-url="#targetUrl">{{$itens->name}}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-pane show active" id="linkExternal"></div>
    </div> {{-- END .tab-content --}}
    <div class="row">
        <div class="col-12 col-sm-8">
            {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
            {!! Form::url('link', null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
        </div>
        <div class="col-12 col-sm-4">
            {!! Form::label('target_link', 'Redirecionar para', ['class'=>'form-label']) !!}
            {!! Form::select('target_link', ['_self' => 'Na mesma aba', '_target' => 'Em nova aba'], null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
        </div>
    </div>
</div> {{-- END .wrapper-links --}}
