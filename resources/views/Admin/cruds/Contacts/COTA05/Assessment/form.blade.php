@if ($contact)
    {!! Form::model($contact, ['route' => ['admin.cota05.assessment.update', $contact->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
@else
    {!! Form::model(null, ['route' => 'admin.cota05.assessment.store', 'class' => 'parsley-validate', 'files' => true]) !!}
@endif
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="mb-3 d-flex align-items-center">
                <div>
                    <h4>Campos do Formulário</h4>
                    <p>Adicione os campos ao formulário, informe os títulos e Opções para o cliente e veja seu formulário ser contruído do seu jeito.</p>
                </div>
            </div>

            <div class="row container-inputs-contact">
                @if (isset($configAssessments))
                    @foreach ($configAssessments as $key => $value)
                        <div class="container-type-input col-12 p-1">
                            <div class="border p-2">
                                <div class="d-flex align-items-center">
                                    <div class="mb-3 w-100">
                                        {!! Form::label(null, 'Tipo do Campo', ['class' => 'form-label']) !!}
                                        {!! Form::select('', ['radio' => 'Escolha única (Um ou outro)'], $value->type,
                                            ['class' => 'form-select selectTypeInput', 'placeholder' => '-'],
                                        ) !!}
                                    </div>
                                    <a href="javascript:void(0)"
                                        class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                                </div>
                                <div class="infoInputs">
                                    @if ($value->placeholder)
                                        <div class="mb-3">
                                            <label class="form-label">Titulo</label>
                                            <div class="row">
                                                <div class="col-9">
                                                    <input type="text" name="{{ $key }}"
                                                        class="form-control inputSetTitle"
                                                        placeholder="Nome que será exibido para o cliente"
                                                        value="{{ $value->placeholder }}">
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-check mt-1">
                                                        <input type="checkbox"
                                                            name="{{ str_replace('column', 'required', $key) }}"
                                                            class="form-check-input inputSetRequired" id="invalidCheck"
                                                            value="1"
                                                            {{ isset($value->required) ? ($value->required ? 'checked' : '') : '' }}>
                                                        <label for="invalidCheck"
                                                            class="form-label">Obrigatório?</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($value->option)
                                        <div class="mb-3">
                                            <label class="form-label">Opções</label>
                                            <input type="text" name="{{ str_replace('column', 'option', $key) }}"
                                                class="form-control inputSetOption"
                                                placeholder="Separar as opções com vírgula"
                                                value="{{ $value->option }}">
                                        </div>
                                    @endif
                                </div>
                                {{-- END .infoInputs --}}
                            </div>
                        </div>
                        {{-- END .container-type-input --}}
                    @endforeach
                @else
                    <div class="container-type-input aux-target col-12 p-1">
                        <div class="border p-2">
                            <div class="d-flex align-items-center">
                                <div class="mb-3 w-100">
                                    {!! Form::label(null, 'Tipo do Campo', ['class' => 'form-label']) !!}
                                    {!! Form::select('', ['radio' => 'Escolha única (Um ou outro)', ], null,
                                        ['class' => 'form-select selectTypeInput', 'placeholder' => '-'], )
                                    !!}
                                </div>
                                <a href="javascript:void(0)"
                                    class="mdi mdi-close-circle-outline font-22 ms-2 text-danger deleteTypeButton"></a>
                            </div>
                        </div>
                    </div>
                    {{-- END .container-type-input --}}
                @endif
            </div>
            <h4 class="mt-3">
                <a href="javascript:void(0)"
                    class="cloneTypeButton--aux font-18 btn btn-info d-flex align-items-center justify-content-center"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Clique para inserir um novo campo ao formulário">
                    Adicionar novo campo
                    <i class="mdi mdi-plus-circle font-22 ms-1"></i>
                </a>
            </h4>
        </div>
    </div>

    <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
        {!! Form::button('Salvar', [
            'class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0',
            'type' => 'submit',
        ]) !!}
    </div>
</div>
{{-- end row --}}
{!! Form::close() !!}
