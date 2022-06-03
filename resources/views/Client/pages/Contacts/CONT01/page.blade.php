@extends('Client.Core.client')
@section('content')
    <section id="CONT01" class="contact-container container-fluid">
        <div class="body-section">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <div class="contact-content">
                        <h4 class="title mb-3">Titulo Chamada <i class="line mt-3"></i></h4>
                        <p>
                            Primeira Travessa São Jorge, 23<br>
                            Lauro de Freitas - Centro<br>
                            Bahia - Brasil
                        </p>
                        <nav class="d-flex align-items-center mt-5">
                            @foreach ($socials as $social)
                                <a href="{{$social->link}}" target="_blank" title="{{$social->title}}" class="mx-1 icon-social-contact font-28 mdi {{$social->icon}}"></a>
                            @endforeach
                        </nav>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    {!! Form::open(['route' => 'cont01.store', 'method' => 'post', 'class'=>'form-contact parsley-examples d-table']) !!}

                        <div class="text-form-contact mb-4">
                            <p>Home is behind, the world ahead and there are many paths to tread through shadows to the edge.</p>
                        </div>

                        @foreach ($contactForm as $name => $input)
                            @include('Client.Components.inputs', [
                                'name' => $name,
                                'options' => $input->option,
                                'placeholder' => $input->placeholder,
                                'type' => $input->type
                            ])
                        @endforeach

                        {!! Form::button('Enviar', ['class'=>'btn btn-primary float-end', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
