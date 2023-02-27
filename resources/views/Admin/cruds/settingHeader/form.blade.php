<input type="hidden" name="module" value="">
<input type="hidden" name="model" value="">
<input type="hidden" name="select_dropdown" value="">
<div class="row col-12">
    <div class="col-12 col-md-6">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('title', 'Título da página', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="O título será exibido no menu do site."></i>
                </div>
                {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
            </div>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-1">
                    {!! Form::label('page', 'Páginas do site', ['class'=>'form-label mb-0']) !!}
                    <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                        data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-original-title="A página selecionada será usada para redirecionar o usuário quando clicar no menu."></i>
                </div>
                {!! Form::select('page', listPage('pages'), null, [
                    'class'=>'form-select selectPage',
                    'id'=>'page',
                    'required'=>'required',
                    'placeholder' => 'Selecione uma página'
                ]) !!}
            </div>
            <div class="ifDropdown" style="display: none;">
                <div class="mb-3">
                    <div class="d-flex align-items-center mb-1">
                        {!! Form::label('dropdown', 'Terá lista suspensa?', ['class'=>'form-label mb-0']) !!}
                        <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                            data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-original-title="Lista suspensa é um submenu que aparece quando um link do menu principal é clicado."></i>
                    </div>
                    {!! Form::select('dropdown', [0 => 'Não', 1 => 'Sim'], null, [
                        'class'=>'form-select activeDropdown',
                        'id'=>'dropdown',
                        'required'=>'required'
                    ]) !!}
                </div>
                <div class="ifRelations" style="display: none;">
                    <div class="mb-3">
                        <div class="dropdown mb-3 col-12">
                            <div class="d-flex align-items-center mb-1">
                                {!! Form::label('dropdown', 'O que será exibido?', ['class'=>'form-label mb-0']) !!}
                                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Selecione o que a lista suspensa deste menu exibirá."></i>
                            </div>
                            <button class="form-control dropdown-toggle text-start btnViewPage" type="button" id="dropdownPages" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="title"></span><i class="mdi mdi-chevron-down float-end"></i>
                            </button>
                            <ul class="dropdown-menu multi-level col-12 containerListPages" aria-labelledby="dropdownPages"></ul>
                        </div>
                    </div>
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
