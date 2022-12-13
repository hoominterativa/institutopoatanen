@if (isset($archive))
    {!! Form::model($archive, ['route' => ['admin.copa01.archive.update', $archive->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.copa01.archive.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <input type="hidden" name="section_id" value="{{$section->id}}">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>true]) !!}
            </div>
            <div class="alert alert-warning">
                <p class="mb-0">O campo de link abaixo só deverá ser preenchido caso não exista um arquivo.</p>
            </div>
            <div class="row">
                <div class="mb-3 col-12 col-lg-6">
                    {!! Form::label('link', 'Link', ['class'=>'form-label']) !!}
                    {!! Form::text('link', null, ['class'=>'form-control', 'id'=>'link']) !!}
                </div>
                <div class="mb-3 col-12 col-lg-6">
                    {!! Form::label('link_target', 'Abrir link em', ['class'=>'form-label']) !!}
                    {!! Form::select('link_target', ['_self' => 'Mesma aba', '_blank' => 'Nova aba'], null, [
                        'class'=>'form-select',
                        'id'=>'link_target'
                    ]) !!}
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-6">
            <div class="mb-3">
                {!! Form::label('file', 'Arquivo', ['class'=>'form-label']) !!}
                {!! Form::file('path_archive', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'180',
                    'data-max-file-size-preview'=>'2M',
                    'data-default-file'=> isset($archive)?($archive->path_archive<>''?url('storage/'.$archive->path_archive):''):'',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
