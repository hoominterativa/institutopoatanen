@if (isset($gallery))
    {!! Form::model($gallery, [
        'route' => ['admin.port101.gallery.update', $gallery->id],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    @method('PUT')
@else
    {!! Form::model(null, [
        'route' => ['admin.port101.gallery.store'],
        'class' => 'parsley-validate',
        'files' => true,
    ]) !!}
    <input type="hidden" name="portfolio_id" value="{{ $portfolio->id }}">
@endif


<div class="col-12 ">
    <div class="mb-3">
        {!! Form::label('title', 'Galeria de Imagens', ['class' => 'form-label']) !!}
        <div class="uploadMultipleImage">
            <label for="path_image" class="content-message">
                {!! Form::file('path_image[]', [
                    'id' => 'path_image',
                    'multiple' => 'multiple',
                    'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                    'class' => 'inputGetImage',
                ]) !!}
                <i class="mdi mdi-cloud-upload-outline mdi-36px"></i>
                <h4 class="title">Solte as imagens aqui ou clique para fazer upload.</h4>
                <span class="text-muted font-13">Carregar imagens com no máximo <strong>2mb</strong></span>
            </label>
            <div id="containerMultipleImages" class="mt-3"></div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Fechar', [
            'class' => 'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left',
            'data-bs-dismiss' => 'modal',
            'type' => 'button',
        ]) !!}
    </div>
    {!! Form::close() !!}
</div>

{{-- end row --}}
