@switch($type)
    @case('relations')
        @if ($pages)
            @foreach ($pages as $page => $relations)
                <li class="list-group-item listPages">
                    <a href="javascript:void(0)" class="form-control btnSelectPage" data-relation="this">
                        {!! Form::checkbox('', '', null, ['class'=>'form-check-input', 'id'=>'this']) !!}
                        {!! Form::label('this', $page, ['class'=>'form-check-label']) !!}
                    </a>
                    @if (count($relations))
                        <ul class="list-group listRelations">
                            @foreach ($relations as $name => $relation)
                                <li class="list-group-item">
                                    <div class="form-check">
                                        {!! Form::checkbox('set_dropdown', $name, null, ['class'=>'form-check-input inputSelectRelation', 'id'=>$name.$code]) !!}
                                        {!! Form::label($name.$code, $relation, ['class'=>'form-check-label']) !!}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        @endif
    @break
    @case('conditions')
        <div class="selectConditions">
            <div class="d-flex align-items-center mb-1">
                {!! Form::label('condition', 'Condição de exibição', ['class'=>'form-label mb-0']) !!}
                <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                    data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                    data-bs-original-title="Informe uma condição para que os registros sejam exibidos na lista."></i>
            </div>
            {!! Form::select('condition', $relations, null, [
                'class'=>'form-select activeDropdown',
                'id'=>'condition',
            ]) !!}
        </div>
    @break
@endswitch

