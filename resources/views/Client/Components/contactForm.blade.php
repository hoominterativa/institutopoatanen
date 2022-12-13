@switch($model)
    @case('FORM01')
        <section id="CONT01" class="contact-container container-fluid">
            <div class="container py-5">
                <div class="body-section">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-6">
                            <div class="contact-content">
                                <h4 class="title mb-3">{{$contactForm->section_title}} <i class="line mt-3"></i></h4>
                                <p>{{$contactForm->description}}</p>
                                <nav class="d-flex align-items-center mt-5">
                                    @foreach ($socials as $social)
                                        <a href="{{$social->link}}" target="_blank" title="{{$social->title}}" class="mx-1 icon-social-contact font-28 mdi {{$social->icon}}"></a>
                                    @endforeach
                                </nav>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            {!! Form::open(['route' => 'home', 'method' => 'post', 'class'=>'form-contact parsley-validate d-table w-100']) !!}
                                @foreach ($inputs as $name => $input)
                                    @include('Client.Components.inputs', [
                                        'name' => $name,
                                        'options' => $input->option,
                                        'placeholder' => $input->placeholder,
                                        'type' => $input->type,
                                        'required' => isset($input->required)?$input->required:false
                                    ])
                                @endforeach
                                {!! Form::button('Enviar', ['class'=>'btn btn-primary float-end', 'type' => 'submit']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @break
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
                    {!! Form::open(['route' => 'home', 'method' => 'post', 'class'=>'form101__boxRight__form form-contact parsley-validate d-flex row mx-0']) !!}
                    @foreach ($inputs as $name => $input)
                        @include('Client.Components.inputs', [
                            'name' => $name,
                            'options' => $input->option,
                            'placeholder' => $input->placeholder,
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
