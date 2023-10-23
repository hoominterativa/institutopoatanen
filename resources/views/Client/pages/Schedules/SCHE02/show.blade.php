@extends('Client.Core.client')
@section('content')
{{-- BEGIN Page content --}}
<section id="ligtbox-SCHE02-show" class="lish">
    <div class="container">
        <header class="lish__topo">
            <div class="lish__topoengPrev">
                <a href="#" class="lish__topoengPrev__prev"><</a>
                <span class="lish__topoengPrev__date">09/Abril/2023</span>
            </div>
            <a href="#" class="lish__topo__close">x</a>
        </header>
        <div class="lish__content">
            <div class="lish__content__box">
                <div class="lish__content__box__top accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#lish-1" aria-expanded="false" aria-controls="collapseTwo">
                    <div class="lish__content__box__top__left">
                        <h4 class="lish__content__box__top__left__title">Sexta</h4>
                        <h5 class="lish__content__box__top__left__subtitle">Salvador-BA</h5>
                    </div>
                </div>
                <div id="#lish-1" class="lish__content__box__bottom accordion-collapse collapse" data-bs-parent="#lish-1">
                    <div class="lish__content__box__bottom__paragraph">
                        <p>
                            Lorem ipsum dolor sit amet. Aut quasi rerum et nulla voluptatem et accusamus nihil et magnam 
                            tempore quo dolore quis ea voluptatum odit. Qui vero rerum ab consequatur nobis est temporibus 
                            deserunt qui sapiente suscipit. t suscipit odio eos vitae ~
                            perferendis eos totam sunt At galisum internos. Et voluptatem eveniet quo 
                        </p>
                    </div>
                    {{-- fim-paragraph --}}
                    <div class="lish__content__box__bottom__buttons">
                        <a href="" target="" class="lish__content__box__bottom__buttons__btn">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                            CTA
                        </a>
                        <a href="" target="" class="lish__content__box__bottom__buttons__btn">
                            <img src="{{ asset('storage/uploads/tmp/icon-general.svg') }}">
                            CTA
                        </a>
                    </div>
                    {{-- fim-buttons --}}
                </div>
            </div>
        </div>
    </div>
</section>
{{-- Finish Content page Here --}}
@foreach ($sections as $section)
    {!!$section!!}
@endforeach
@endsection
