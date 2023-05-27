@switch($config->type)
    @case('text')
        <div class="mb-3">
            {!! Form::label($name, $config->name, ['class'=>'form-label']) !!}
            {!! Form::text('content['.$name.']', $content?$content->$name->value:null, ['class'=>'form-control', 'id'=>$name]) !!}
        </div>
    @break
    @case('cellphone')
        <div class="mb-3">
            {!! Form::label($name, $config->name, ['class'=>'form-label sp_celphones']) !!}
            {!! Form::text('content['.$name.']', $content?$content->$name->value:null, ['class'=>'form-control']) !!}
        </div>
    @break
    @case('email')
        <div class="mb-3">
            {!! Form::label($name, $config->name, ['class'=>'form-label']) !!}
            {!! Form::email('content['.$name.']', $content?$content->$name->value:null, [
                'class'=>'form-control',
                'parsley-type'=>'email',
            ]) !!}
        </div>
    @break
    @case('textarea')
        <div class="mb-3">
            {!! Form::label('message', $config->name, ['class'=>'form-label']) !!}
            {!! Form::textarea('content['.$name.']', $content?$content->$name->value:null, [
                'class'=>'form-control',
                'id'=>'message',
                'data-parsley-trigger'=>'keyup',
                'data-parsley-minlength'=>'20',
                'data-parsley-maxlength'=>'100',
                'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                'data-parsley-validation-threshold'=>'10',
            ]) !!}
        </div>
    @break
    @case('checkbox')
        <div class="mb-3 form-check">
            {!! Form::checkbox('content['.$name.'[]]', '1', $content?$content->$name->value:null, ['class'=>'form-check-input', 'id'=>'invalidCheck']) !!}
            {!! Form::label('invalidCheck', $config->name, ['class'=>'form-check-label']) !!}
        </div>
    @break
    @case('textlong')
        <div class="basic-editor__content mb-3">
            {!! Form::label('basic-editor', $config->name, ['class'=>'form-label']) !!}
            {!! Form::textarea('content['.$name.']', $content?$content->$name->value:null, [
                'class'=>'form-control basic-editor',
                'id'=>'basic-editor',
            ]) !!}
        </div>
    @break
    @case('image')
        <div class="mb-3">
            <div class="container-image-crop">
                {!! Form::label('inputImage', $config->name, ['class'=>'form-label']) !!}
                <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->$name->width}}x{{$cropSetting->$name->height}}px!</small>
                <label class="area-input-image-crop" for="inputImage">
                    {!! Form::file($name, [
                        'id'=>'inputImage',
                        'class'=>'inputImage',
                        'data-status'=>$cropSetting->$name->activeCrop, // px
                        'data-min-width'=>$cropSetting->$name->width, // px
                        'data-min-height'=>$cropSetting->$name->height, // px
                        'data-box-height'=>'225', // Input height in the form
                        'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                        'data-default-file'=> $content?asset('storage/'.$content->$name->value):'',
                    ]) !!}
                </label>
            </div><!-- END container image crop -->
            {!! Form::hidden('content['.$name.']', $config->type) !!}
        </div>
    @break
    @case('link')
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
                <div class="col-12 mb-3">
                    {!! Form::label('title_button', 'Título do Botão', ['class'=>'form-label']) !!}
                    {!! Form::text('content[title_button]', $content?$content->$name->value:null, ['class'=>'form-control', 'id'=>'title_button']) !!}
                </div>
                <div class="col-12 col-sm-8">
                    {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                    {!! Form::url('content[link]', $content?$content->$name->value:null, ['class'=>'form-control','parsley-type'=>'url', 'id' => 'targetUrl']) !!}
                </div>
                <div class="col-12 col-sm-4">
                    {!! Form::label('target_link', 'Redirecionar para', ['class'=>'form-label']) !!}
                    {!! Form::select('content[target_link]', ['_self' => 'Na mesma aba', '_target' => 'Em nova aba'], $content?$content->$name->value:null, ['class'=>'form-select', 'id'=>'target_link_button']) !!}
                </div>
            </div>
        </div> {{-- END .wrapper-links --}}
    @break
@endswitch
{!! Form::hidden('type_'.$name, $config->type) !!}




