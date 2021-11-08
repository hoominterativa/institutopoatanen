<div class="row col-12">
    <div class="card col-12 col-lg-6">
        <div class="card-body">
            <div class="mb-3">
                {!! Form::label(null, 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Subtítulo', ['class'=>'form-label']) !!}
                {!! Form::text('subtitle', null, ['class'=>'form-control']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Título Botão', ['class'=>'form-label']) !!}
                {!! Form::text('button_title', null, ['class'=>'form-control']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Link', ['class'=>'form-label']) !!}
                {!! Form::url('button_link', null, [
                    'class'=>'form-control',
                    'parsley-type'=>'url',
                    'placeholder'=>'Ex.: https://google.com'
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control',
                    'data-parsley-trigger'=>'keyup',
                    'data-parsley-maxlength'=>'250',
                ]) !!}
            </div>
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                {!! Form::label('active', 'Ativo?', ['class'=>'form-check-label']) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
    <div class="card col-12 col-lg-6">
        <div class="card-body">
            <div class="mb-3">
                {!! Form::label(null, 'Imagem Background', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_background', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'250',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($slide)?url('storage/'.$slide->path_image_background):'',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Imagem PNG', ['class'=>'form-label']) !!}
                {!! Form::file('path_image_png', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'180',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($slide)?url('storage/'.$slide->path_image_png):'',
                ]) !!}
            </div>
        </div> <!-- end card-body-->
    </div> <!-- end card-->
</div>
<!-- end row -->
