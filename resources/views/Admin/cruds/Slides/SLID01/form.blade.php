{{--
    Para uma boa organização dos inputs, em caso de uma tela de cadastro com muitos campos, recomendamos dividir em dua colunas
    o "div class=card" adicionando a classe 'col-lg-6' e duplicando toda a div class=card e distribuir os inputs nessas colunas.

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
        <div class="card card-body">
            {{-- INSERI OS INPUTS DOS FORMULARIOS AQUI --}}
        </div>
        {{-- end card-body --}}
    </div>
    {{-- end card --}}
</div>
{{-- end row --}}
