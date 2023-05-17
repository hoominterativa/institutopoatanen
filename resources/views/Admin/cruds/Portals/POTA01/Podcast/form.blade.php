<div class="row col-12">
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                {!! Form::label('title', 'Título do Episódio', ['class'=>'form-label']) !!}
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label('duration', 'Duração do Episódio (minutos)', ['class'=>'form-label']) !!}
                {!! Form::text('duration', null, ['class'=>'form-control', 'id'=>'duration', 'data-mask' => '000000']) !!}
            </div>
            <div class="mb-3">
                {!! Form::label(null, 'Data de Publicação do Episódio', ['class'=>'form-label']) !!}
                {!! Form::text('publishing', null, [
                    'class'=>'form-control',
                    'data-provide'=>'datepicker',
                    'data-date-autoclose'=>'true',
                    'data-date-format'=>'dd/mm/yyyy',
                    'data-date-language'=>'pt-BR',
                ])!!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('validationCustom01', 'Incorporar play Spotify', ['class'=>'form-label']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Encontre sua playlist no Spotify, clique com o botão direito do mouse em cima da mesma, depois selecione a opção compartilhar e dpois em Incorporar. Copie o código do embed e cole no campo abaixo."></i>
                </div>
                {!! Form::text('embed', null, ['class'=>'form-control', 'id'=>'embed']) !!}
            </div>
            <div class="basic-editor__content mb-3">
                {!! Form::label('description', 'Descrição', ['class'=>'form-label']) !!}
                {!! Form::textarea('description', null, [
                    'class'=>'form-control basic-editor',
                    'id'=>'basic-editor',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12 col-lg-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="container-image-crop">
                    {!! Form::label('inputImage', 'Thumbnail', ['class'=>'form-label']) !!}
                    <small class="ms-2">Dimensões proporcionais mínimas {{$cropSetting->Podcast->path_image_thumbnail->width}}x{{$cropSetting->Podcast->path_image_thumbnail->height}}px!</small>
                    <label class="area-input-image-crop" for="inputImage">
                        {!! Form::file('path_image_thumbnail', [
                            'id'=>'inputImage',
                            'class'=>'inputImage',
                            'data-status'=>$cropSetting->Podcast->path_image_thumbnail->activeCrop, // px
                            'data-min-width'=>$cropSetting->Podcast->path_image_thumbnail->width, // px
                            'data-min-height'=>$cropSetting->Podcast->path_image_thumbnail->height, // px
                            'data-box-height'=>'225', // Input height in the form
                            'accept'=>'.jpg,.jpeg,.png,.gif,.bmp,.tiff,.webp',
                            'data-default-file'=> isset($podcast)?($podcast->path_image_thumbnail<>''?url('storage/'.$podcast->path_image_thumbnail):''):'',
                        ]) !!}
                    </label>
                </div><!-- END container image crop -->
            </div>

            <div class="mb-3">
                {!! Form::label('file', 'Arquivo de Áudio', ['class'=>'form-label']) !!}
                {!! Form::file('path_archive', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'225',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'.mp3, .3gp, .ogg, .aac, .flac, .wav, .alac, .aiff, .ape, .dsd, .mqa, .opus, .wma',
                    'data-default-file'=> isset($podcast)?($podcast->path_archive<>''?url('storage/'.$podcast->path_archive):''):'',
                ]) !!}
            </div>
            <div class="mb-3">
                @if (isset($podcast))
                    @if ($podcast->path_archive)
                        <audio id="audioPlayer" src="{{asset('storage/'.$podcast->path_archive)}}" controls></audio>
                    @endif
                @endif
            </div>
            <div class="d-flex">
                <div class="mb-3 form-check me-3">
                    {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input', 'id'=>'active']) !!}
                    {!! Form::label('active', 'Ativar exibição?', ['class'=>'form-check-label']) !!}
                </div>
                <div class="mb-3 form-check">
                    {!! Form::checkbox('featured_home', '1', null, ['class'=>'form-check-input', 'id'=>'featured_home']) !!}
                    {!! Form::label('featured_home', 'Destacar na Home do Portal?', ['class'=>'form-check-label']) !!}
                </div>
            </div>
        </div>
        {{-- end card-body --}}
    </div>
</div>
{{-- end row --}}

{{-- Essa estrutura pode ser usada junto ao label do input para aparecer o ícone de duvida do lado do mesmo. pode usar a estutura abaixo substituindo o "Form::label" --}}
{{-- <div class="d-flex align-items-center mb-1">
    {!! Form::label('validationCustom01', 'First name', ['class'=>'form-label']) !!}
    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
        data-bs-original-title="Coloque a mensagem desejado aqui"></i>
</div> --}}
