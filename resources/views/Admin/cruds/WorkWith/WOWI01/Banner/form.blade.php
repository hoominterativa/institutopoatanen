{!! Form::model($workWith, ['route' => ['admin.wowi01.update', $workWith->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
    <input type="hidden" name="active" value="{{$workWith->active}}">
    <input type="hidden" name="featured_menu" value="{{$workWith->featured_menu}}">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title_banner', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title_banner', null, ['class'=>'form-control', 'id'=>'title_banner']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('file', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensão proporcional mínima 1500x420px</small>
                    {!! Form::file('path_image_banner', [
                        'data-plugins'=>'dropify',
                        'data-height'=>'200',
                        'data-max-file-size-preview'=>'2M',
                        'accept'=>'image/*',
                        'data-default-file'=> isset($workWith)?($workWith->path_image_banner<>''?url('storage/'.$workWith->path_image_banner):''):'',
                    ]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
