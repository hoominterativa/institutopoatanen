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
                                        'required' => $input->required
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
@endswitch
