@if ($section)
    {!! Form::model($section, ['route' => ['admin.abou05.section_content.update', $section->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    {!! Form::hidden('active_section', $section->active_section) !!}
    {!! Form::hidden('active_banner', $section->active_banner) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou05.section_content.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3 col-12 col-lg-6">
                    {!! Form::label('title_content', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title_content', null, ['class'=>'form-control', 'id'=>'title_content']) !!}
                </div>
                <div class="mb-3 col-12 col-lg-6">
                    {!! Form::label('subtitle_content', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle_content', null, ['class'=>'form-control', 'id'=>'subtitle_content']) !!}
                </div>
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active_content', '1', null, ['class' => 'form-check-input', 'id' => 'active_content']) !!}
                {!! Form::label('active_content', 'Ativar exibição da seção?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>

{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
