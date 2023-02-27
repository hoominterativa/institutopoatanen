@if ($pages)
    @foreach ($pages as $page => $relations)
        <li class="dropdown {{ count($relations)?'dropdown-submenu':'' }} listPages">
            <a href="javascript:void(0)" class="dropdown-item btnSelectPage" data-relation="this">{{$page}}</a>
            @if (count($relations))
                <ul class="dropdown-menu listRelations">
                    @foreach ($relations as $name => $relation)
                        <li>
                            <div class="form-check">
                                {!! Form::checkbox('set_dropdown', $name, null, ['class'=>'form-check-input inputSelectRelation', 'id'=>$name.$code]) !!}
                                {!! Form::label($name.$code, $name, ['class'=>'form-check-label']) !!}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
@endif
