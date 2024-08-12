{{--
    Para uma boa organização dos inputs, em caso de uma tela de cadastro com muitos campos, recomendamos dividir em dua colunas
    o "div class=col-12 dentro de .row" adicionando a classe 'col-lg-6' e duplicando toda a div e distribuir os inputs nessas colunas.

    Lista de Inputs se encontra no arquivo 'resources/views/Admin/components/forms/inputs.blade.php' é só copiar a estrutura do blase desejada e colar
    na área indicada abaixo. Veja abaixo um exemplo da estrutura do input.

    <div class="mb-3">
        {!! Form::label('validationCustom01', 'First name', ['class'=>'form-label']) !!}
        {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'validationCustom01', 'placeholder'=>'First name', 'required'=>'required']) !!}
    </div>

    PS.: Excluir esse comentário e todos relacioado a instruções.
--}}
<div class="row col-12">
    <div class="col-12">
        <div class="card card-body" id="tooltip-container">
            <div class="row">
                <div class="mb-3">
                    {!! Form::label('title', 'Nome da Categoria', ['class'=>'form-label']) !!}
                    {!! Form::text('title', null, ['class'=>'form-control', 'id'=>'title', 'required'=>'required']) !!}
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
