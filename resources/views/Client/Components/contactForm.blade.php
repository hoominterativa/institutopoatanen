@switch($model)
    @case('FORM101')
        <section class="form101 container-fluid px-0" style="background-image: url({{asset('storage/uploads/tmp/bg-slide.jpg')}})">
            <div class="container container--pd">
                <div class="row mx-0">
                    <div class="form101__boxLeft col-lg-6 px-0">
                        <h2 class="form101__boxLeft__subtitle text-center">Subtitulo</h2>
                        <h4 class="form101__boxLeft__title">TITULO COM DESCRIÇÃO</h4>
                        <div class="form101__boxLeft__paragraph">
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras vel tortor eu purus gravida sollicitudin vel non liberolor sit amet, consectetur
                            </p>
                        </div>
                    </div>
                    <div class="form101__boxRight col-lg-6 px-0">
                        {!! Form::open(['route' => 'lead.store', 'method' => 'post', 'files' => true, 'class'=>'send_form_ajax form101__boxRight__form form-contact parsley-validate d-flex row mx-0']) !!}
                            <input type="hidden" name="target_lead" value="TITULO COM DESCRIÇÃO Subtitulo">
                            <input type="hidden" name="target_send" value="{{base64_encode($contactForm->email)}}">
                            @foreach ($inputs as $name => $input)
                                @include('Client.Components.inputs', [
                                    'name' => $name,
                                    'options' => $input->option,
                                    'placeholder' => $input->placeholder,
                                    'required' => $input->required,
                                    'type' => $input->type
                                ])
                            @endforeach
                            <button type="submit" class="form101__boxRight__cta">
                                <img src="{{asset('storage/uploads/tmp/icon-general.svg')}}" alt="Ícone">
                                CTA
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    @break
@endswitch
