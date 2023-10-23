@if ($section)
    {!! Form::model($section, ['route' => ['admin.abou05.section_content.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.abou05.section_content.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="col-sm-6">
                    {!! Form::label('title_content', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title_content', null, ['class'=>'form-control', 'id'=>'title_content']) !!}
                </div>
                <div class="col-sm-6">
                    {!! Form::label('subtitle_content', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle_content', null, ['class'=>'form-control', 'id'=>'subtitle_content']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
