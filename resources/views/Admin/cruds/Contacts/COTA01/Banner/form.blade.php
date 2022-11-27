{!! Form::model($contact, ['route' => ['admin.cota01.update', $contact->id], 'class'=>'parsley-validate', 'files' => true, 'method' => 'PUT']) !!}
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
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('path_image_banner', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensão proporcional mínima 1500x360px</small>
                    {!! Form::file('path_image_banner', [
                        'data-plugins'=>'dropify',
                        'data-height'=>'300',
                        'data-max-file-size-preview'=>'2M',
                        'accept'=>'image/*',
                        'data-default-file'=> isset($contact)?($contact->path_image_banner<>''?url('storage/'.$contact->path_image_banner):''):'',
                    ]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
    </div>
{!! Form::close() !!}
