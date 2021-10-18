@extends('Client.Core.client')
@section('content')
    <section id="cont01" class="contact-container container-fluid">
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

                        @if (isset($contactForm->name))
                            {!! Form::text('name', null, [
                                'class' => 'form-control mb-3 ps-3',
                                'required'=>'required',
                                'placeholder' => $contactForm->name->title
                            ]) !!}
                        @endif
                        @if (isset($contactForm->email))
                            {!! Form::email('email', null, [
                                'class'=>'form-control mb-3 ps-3',
                                'required'=>'required',
                                'parsley-type'=>'email',
                                'placeholder' => $contactForm->email->title
                            ]) !!}
                        @endif
                        @if (isset($contactForm->phone))
                            {!! Form::text('phone', null, [
                                'class'=>'form-control mb-3 ps-3',
                                'data-toggle'=>'input-mask',
                                'data-mask-format'=>'(00) 0000-0000',
                                'placeholder' => $contactForm->phone->title
                            ]) !!}
                        @endif
                        @if (isset($contactForm->cellphone))
                            {!! Form::text('cellphone', null, [
                                'class'=>'form-control mb-3 ps-3',
                                'data-toggle'=>'input-mask',
                                'data-mask-format'=>'(00) 00000-0000',
                                'placeholder' => $contactForm->cellphone->title
                            ]) !!}
                        @endif
                        @if (isset($contactForm->subject))
                            @if (count($subject))
                                {!! Form::select('subject', $subject, null, [
                                    'class'=>'form-select mb-3 ps-3',
                                    'id'=>'heard',
                                    'required'=>'required',
                                    'placeholder' => $contactForm->subject->title
                                ]) !!}
                            @else
                                {!! Form::text('subject', null, [
                                    'class' => 'form-control mb-3 ps-3',
                                    'required'=>'required',
                                    'placeholder' => $contactForm->subject->title
                                ]) !!}
                            @endif
                        @endif
                        @if (isset($contactForm->met_us))
                            @if (count($metUs))
                                {!! Form::select('met_us', $metUs, null, [
                                    'class'=>'form-select mb-3 ps-3',
                                    'id'=>'heard',
                                    'required'=>'required',
                                    'placeholder' => $contactForm->met_us->title
                                ]) !!}
                            @else
                                {!! Form::text('met_us', null, [
                                    'class' => 'form-control mb-3 ps-3',
                                    'required'=>'required',
                                    'placeholder' => $contactForm->met_us->title
                                ]) !!}
                            @endif
                        @endif
                        @if (isset($contactForm->description))
                            {!! Form::textarea('description', null, [
                                'class'=>'form-control mb-3 ps-3',
                                'id'=>'message',
                                'required'=>'required',
                                'placeholder' => $contactForm->description->title,
                                'data-parsley-trigger'=>'keyup',
                                'data-parsley-minlength'=>'20',
                                'data-parsley-maxlength'=>'500',
                                'data-parsley-minlength-message'=>'Vamos lá! Você precisa inserir um texto de pelo menos 20 caracteres.',
                                'data-parsley-validation-threshold'=>'10',
                            ]) !!}
                        @endif
                        {!! Form::button('Enviar', ['class'=>'btn btn-primary float-end', 'type' => 'submit']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
