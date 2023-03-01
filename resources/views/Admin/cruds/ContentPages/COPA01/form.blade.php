
<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="d-flex align-items-center mb-3">
                <h4>Infomações da página</h4>
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title_page', 'Título da página', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Título que será exibido nos links de compliances do site"></i>
                </div>
                {!! Form::text('title_page', null, ['class'=>'form-control', 'id'=>'title_page', 'required'=>'required']) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="d-flex align-items-center mb-3">
                <h4>Banner da página</h4>
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Banner principal da página, é exibido no início da mesma."></i>
            </div>
            <div class="mb-3">
                {!! Form::label('title_banner', 'Título', ['class'=>'form-label']) !!}
                {!! Form::text('title_banner', null, ['class'=>'form-control', 'id'=>'title_banner']) !!}
            </div>
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Imagem', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->path_image_banner->width}}x{{$cropSetting->path_image_banner->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_banner', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->path_image_banner->activeCrop, // px
                            'data-min-width'=>$cropSetting->path_image_banner->width, // px
                            'data-min-height'=>$cropSetting->path_image_banner->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($contentPage)?($contentPage->path_image_banner<>''?url('storage/'.$contentPage->path_image_banner):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}
