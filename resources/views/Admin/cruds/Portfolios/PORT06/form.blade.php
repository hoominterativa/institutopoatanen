{{--
    Para uma boa organização dos inputs, em caso de uma tela de cadastro com muitos campos, recomendamos dividir em dua colunas
    o "div class=col-12 dentro de .row" adicionando a classe 'col-lg-6' e duplicando toda a div e distribuir os inputs nessas colunas.

    Lista de Inputs se encontra no arquivo 'resources/views/Admin/components/forms/inputs.blade.php' é só copiar a estrutura do blase desejada e colar
    na área indicada abaixo. Veja abaixo um exemplo da estrutura do input.



    PS.: Excluir esse comentário e todos relacioado a instruções.
--}}
<div class="row col-12">
    <div class="col-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('heard', 'Select', ['class' => 'form-label']) !!}
                {!! Form::select('category_id', $categories, null, [
                    'class' => 'form-select',
                    'id' => 'heard',
                    'required' => 'required',
                    'placeholder' => 'Escolha uma categoria...',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('title', 'Titulo', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, [
                    'class' => 'form-control',
                    'id' => 'title',
                    'placeholder' => 'First name',
                    'required' => 'required',
                ]) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('subtitle', 'Subtitulo', ['class' => 'form-label']) !!}
                {!! Form::text('subtitle', null, [
                    'class' => 'form-control',
                    'id' => 'subtitle',
                    'placeholder' => 'First name',
                    'required' => 'required',
                ]) !!}
            </div>
            <div class="basic-editor__content mb-3">
                {!! Form::label('basic-editor', 'Parágrafo', ['class' => 'form-label']) !!}
                {!! Form::textarea('paragraph', null, [
                    'class' => 'form-control basic-editor',
                    'id' => 'basic-editor',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'path_image_box', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{-- {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}}px! --}}
                    </small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_box', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            // 'data-status'=>$cropSetting->path_image->activeCrop, // px
                            // 'data-min-width'=>$cropSetting->path_image->width, // px
                            // 'data-min-height'=>$cropSetting->path_image->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file' => isset($portfolio)
                                ? ($portfolio->path_image_box != ''
                                    ? url('storage/' . $portfolio->path_image_box)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{-- {{$cropSetting->path_image->width}}x{{$cropSetting->path_image->height}} --}}
                        px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            // 'data-status'=>$cropSetting->path_image->activeCrop, // px
                            // 'data-min-width'=>$cropSetting->path_image->width, // px
                            // 'data-min-height'=>$cropSetting->path_image->height, // px
                            'data-box-height' => '225', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff',
                            'data-default-file' => isset($portfolio)
                                ? ($portfolio->path_image != ''
                                    ? url('storage/' . $portfolio->path_image)
                                    : '')
                                : '',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->

            </div>

        </div>
        <div class="d-flex">
            <div class="mb-3 form-check">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar Portfólio', ['class' => 'form-check-label']) !!}
            </div>
            <div class="mb-3 ms-3 form-check">
                {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                {!! Form::label('featured', 'Ativar na Home', ['class' => 'form-check-label']) !!}
            </div>
        </div>
        {{-- end card-body --}}
        {!! Form::button('Salvar', [
            'class' => 'btn btn-primary waves-effect waves-light float-end me-3 width-lg',
            'type' => 'submit',
        ]) !!}
        <a href="{{ route('admin.port06.index') }}"
            class="btn btn-secondary waves-effect waves-light float-end me-3 width-lg">Voltar</a>
        {!! Form::close() !!}
    </div>
</div>
