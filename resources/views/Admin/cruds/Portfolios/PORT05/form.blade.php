<div class="row col-12">
    <div class="col-12 col-lg-6">
        {!! Form::hidden('active_banner', isset($portfolio) ? $portfolio->active_banner : '') !!}
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 d-flex align-items-start flex-column">
                <label for="port05-select" class="form-label">Categorias</label>
                <script>
                    function deleteChannelHandler(event) {
                        event.target.parentNode.parentNode.removeChild(event.target.parentNode);
                    }
                </script>
                <select class="form-select port05-select" id="port05-select" name="category_id">
                    <option disabled selected>Selecione a categoria</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->title }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="category_id" value="{{ isset($category->id) ? $category->id : '' }}">
                <div class="categories_container mt-2" id="categories_container">
                    {{-- BACKEND: FAZER UM FOR EACH PARA OS ELEMENTOS SELECIONADOS --}}
                    <label class="btn btn-light btn-xs waves-effect waves-light">{{-- $category->title --}}
                        <i class="mdi mdi-close" onclick="deleteChannelHandler(event)"></i>
                        <input type="hidden" value='{{$category->id}}' name="value_id[]"></label>
                </div>
            </div>

            <div class="mb-3">
                {!! Form::label('title', 'Título', ['class' => 'form-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control', 'id' => 'title', 'required' => 'required']) !!}
            </div>
            <div class="col-12">
                <div class="normal-editor__content mb-3">
                    {!! Form::label('description', 'Texto', ['class' => 'form-label']) !!}
                    {!! Form::textarea('description', null, [
                        'class' => 'form-control normal-editor',
                        'data-height' => 500,
                        'id' => 'description',
                    ]) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
        <div class="d-flex">
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('active', '1', null, ['class' => 'form-check-input', 'id' => 'active']) !!}
                {!! Form::label('active', 'Ativar exibição?', ['class' => 'form-check-label']) !!}
            </div>
            <div class="mb-3 form-check me-3">
                {!! Form::checkbox('featured', '1', null, ['class' => 'form-check-input', 'id' => 'featured']) !!}
                {!! Form::label('featured', 'Destacar na home?', ['class' => 'form-check-label']) !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Background do Box', ['class' => 'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas
                        {{ $cropSetting->path_image->width }}x{{ $cropSetting->path_image->height }}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image', [
                            'id' => 'inputImage',
                            'class' => 'inputImage',
                            'data-status' => $cropSetting->path_image->activeCrop, // px
                            'data-min-width' => $cropSetting->path_image->width, // px
                            'data-min-height' => $cropSetting->path_image->height, // px
                            'data-box-height' => '205', // Input height in the form
                            'accept' => '.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
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
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}
