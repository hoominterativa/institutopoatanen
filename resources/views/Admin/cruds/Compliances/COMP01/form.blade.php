
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
            <div class="mb-2 form-check d-flex align-items-center">
                {!! Form::checkbox('active', '1', null, ['class'=>'form-check-input me-1', 'id'=>'active']) !!}
                <div class="d-flex align-items-center">
                    {!! Form::label('active', 'Ativar exibição da página', ['class'=>'form-check-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Não selecionar esta opção desativará a exibição da página no site"></i>
                </div>
            </div>
            <div class="mb-2 form-check d-flex align-items-center">
                {!! Form::checkbox('show_header', '1', null, ['class'=>'form-check-input me-1', 'id'=>'show_header']) !!}
                <div class="d-flex align-items-center">
                    {!! Form::label('show_header', 'Ativar exibição no Topo do site', ['class'=>'form-check-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Selecionar esta opção ativará a exibição de um link no menu do topo e sidebar no site."></i>
                </div>
            </div>
            <div class="form-check d-flex align-items-center">
                {!! Form::checkbox('show_footer', '1', null, ['class'=>'form-check-input me-1', 'id'=>'show_footer']) !!}
                <div class="d-flex align-items-center">
                    {!! Form::label('show_footer', 'Ativar exibição no Rodapé do site', ['class'=>'form-check-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="Selecionar esta opção ativará a exibição de um link no menu do rdapé no site."></i>
                </div>
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
                {!! Form::label('file', 'Imagem', ['class'=>'form-label']) !!}
                <small class="ms-2">Dimensão proporcional mínima 1500x400px</small>
                {!! Form::file('path_image_banner', [
                    'data-plugins'=>'dropify',
                    'data-height'=>'200',
                    'data-max-file-size-preview'=>'2M',
                    'accept'=>'image/*',
                    'data-default-file'=> isset($compliance)?($compliance->path_image_banner<>''?url('storage/'.$compliance->path_image_banner):''):'',
                ]) !!}
            </div>
        </div>
        {{-- end card-body --}}
    </div>
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="complete-editor__content mb-3">
                {!! Form::label('text', 'Texto', ['class'=>'form-label']) !!}
                {!! Form::textarea('text', null, [
                    'class'=>'form-control complete-editor',
                    'id'=>'text',
                ]) !!}
            </div>
        </div>
    </div>
</div>
{{-- end row --}}
