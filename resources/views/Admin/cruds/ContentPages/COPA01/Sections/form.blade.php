@if (isset($section))
    <div class="row mb-3">
        <div class="col-6">
            <a href="javascript:void(0)"  data-bs-target="#modal-archive-create-{{$section->id}}" data-bs-toggle="modal" class="btn btn-warning">Arquivos <i class="mdi mdi-plus"></i></a>
        </div>
    </div>

    {{-- BEGIN MODAL ARCHIVE CREATE --}}
    <div id="modal-archive-create-{{$section->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" style="max-width: 1100px;">
            <div class="modal-content">
                <div class="modal-header p-3 pt-2 pb-2">
                    <h4 class="page-title">Cadastrar Arquivos</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-3 pt-0 pb-3">
                    @include('Admin.cruds.ContentPages.COPA01.Archives.form',[
                        'archive' => null,
                        'section' => $section
                    ])
                    @include('Admin.cruds.ContentPages.COPA01.Archives.index',[
                        'archives' => $section->archives,
                        'section' => $section
                    ])
                </div>
            </div>
        </div>
    </div>
    {{-- END MODAL ARCHIVE CREATE --}}

    {!! Form::model($section, ['route' => ['admin.copa01.section.update', $section->id], 'class'=>'parsley-validate', 'files' => true]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => ['admin.copa01.section.store'], 'class'=>'parsley-validate', 'files' => true]) !!}
@endif
    <input type="hidden" name="contentPage_id" value="{{$contentPage->id}}">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="mb-3 col-lg-6">
                    {!! Form::label('title', 'Título', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
                </div>
                <div class="mb-3 col-lg-6">
                    {!! Form::label('subtitle', 'Subtítulo', ['class'=>'form-label']) !!}
                    {!! Form::text('subtitle', null, ['class'=>'form-control', 'id'=>'subtitle']) !!}
                </div>
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Ícone', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensão proporcional mínima 400x400px</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_icon', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-min-width'=>'300',
                            'data-min-height'=>'300',
                            'data-box-height'=>'200',
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($section)?($section->path_image_icon<>''?url('storage/'.$section->path_image_icon):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
            <div class="complete-editor__content mb-3">
                {!! Form::label('text', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control complete-editor',
                    'id'=>'text',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', ['class'=>'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-3', 'type' => 'submit']) !!}
        {!! Form::button('Fechar', ['class'=>'btn btn-secondary waves-effect waves-light float-end me-0 width-lg align-items-left', 'data-bs-dismiss'=> 'modal', 'type' => 'button']) !!}
    </div>
{!! Form::close() !!}
