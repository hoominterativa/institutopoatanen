@if ($about)
    {!! Form::model($about, ['route' => ['admin.abou02.update', $about->id], 'class'=>'parsley-validate', 'method'=>'PUT', 'files'=>true]) !!}
@else
    {!! Form::model(null, ['route' => 'admin.abou02.store', 'class'=>'parsley-validate', 'files'=>true]) !!}
@endif

<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3 col-12 col-lg-6">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="mb-3 col-12 col-lg-6">
                    {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                </div>
            </div>
            <div class="normal-editor__content mb-3">
                {!! Form::label('normal-editor', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control normal-editor',
                    'id'=>'normal-editor',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
</div>

{!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-3 width-lg', 'type' => 'submit']) !!}
<a href="{{route('admin.dashboard')}}" class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
{!! Form::close() !!}
{{-- end row --}}
