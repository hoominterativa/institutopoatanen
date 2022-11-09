@if (isset($topic))
    {!! Form::model($topic, ['route' => ['admin.abou01.topic.update', $topic->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.abou01.topic.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
    <input type="hidden" name="about_id" value="{{$about->id}}">
@endif
    <div class="row col-12">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label('message', 'Descrição', ['class'=>'form-label']) !!}
                    {!! Form::textarea('description', null, [
                        'class'=>'form-control',
                        'id'=>'message',
                        'required'=>'required',
                        'data-parsley-trigger'=>'keyup',
                        'data-parsley-minlength'=>'20',
                        'data-parsley-maxlength'=>'300',
                        'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                        'data-parsley-validation-threshold'=>'10',
                    ]) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('file', 'Ícone', ['class'=>'form-label']) !!}
                    {!! Form::file('path_image_icon', [
                        'data-plugins'=>'dropify',
                        'data-height'=>'300',
                        'data-max-file-size-preview'=>'2M',
                        'accept'=>'image/*',
                        'data-default-file'=> isset($topic)?$topic->path_image_icon<>''?url('storage/'.$topic->path_image_icon):'':'',
                    ]) !!}
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
