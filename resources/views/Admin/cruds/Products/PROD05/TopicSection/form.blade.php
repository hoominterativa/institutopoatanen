
{!! Form::model($product, ['route' => ['admin.prod05.topicSection.update', $product->id], 'class' => 'parsley-validate', 'files' => true,]) !!}
    @method('PUT')
    <div class="row col-12">
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('title_section_topic', 'Título', ['class' => 'form-label']) !!}
                    {!! Form::text('title_section_topic', null, ['class' => 'form-control', 'id' => 'title_section_topic']) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="col-12 col-lg-6">
            <div class="card card-body" id="tooltip-container">
                <div class="mb-3">
                    {!! Form::label('subtitle_section_topic', 'Subtítulo', ['class' => 'form-label']) !!}
                    {!! Form::text('subtitle_section_topic', null, ['class' => 'form-control', 'id' => 'subtitle_section_topic']) !!}
                </div>
            </div>
            {{-- end card-body --}}
        </div>
        <div class="button-btn d-flex justify-content-end col-12 p-2 m-auto mb-2">
            {!! Form::button('Salvar', ['class' => 'btn btn-primary waves-effect waves-light float-end me-0 width-lg align-items-right me-0','type' => 'submit',]) !!}
        </div>
    </div>
{!! Form::close() !!}
