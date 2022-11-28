@if (isset($archive))
    {!! Form::model($archive, ['route' => ['admin.comp01.archive.update', $archive->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.comp01.archive.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <input type="hidden" name="compliance_id" value="{{$compliance->id}}">
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('file', 'Arquivo', ['class'=>'form-label']) !!}
                {!! Form::file('path_archive', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'300',
                    'data-max-file-size-preview'=>'2M',
                    'data-default-file'=> isset($archive)?($archive->path_image<>''?url('storage/'.$archive->path_image):''):'',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
