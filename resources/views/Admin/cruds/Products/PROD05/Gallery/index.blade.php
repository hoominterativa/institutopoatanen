<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.prod05.gallery.destroySelected')}}" type="button" class="btn btn-danger btnDeleteGallery" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)"  data-bs-target="#modal-gallery-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar Imagens <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <div class="wrapper-links">
                    <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                        @foreach ($galleryTypes as $key => $galleryType)
                            <li class="nav-item">
                                <a href="#galleryType-{{$galleryType->id}}" style="background-color: {{$galleryType->color}}" data-bs-toggle="tab" aria-expanded="true" class="nav-link d-flex align-items-center {{$key===0?'active':''}}">
                                {{$galleryType->color}}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach ($galleryTypes as $key => $galleryType)
                            <div class="tab-pane {{$key===0?'show active':''}}" id="galleryType-{{$galleryType->id}}">
                                <table class="table table-bordered table-sortable">
                                    <thead class="table-light">
                                        <tr>
                                            <th width="50px"></th>
                                            <th width="30px" class="bs-checkbox">
                                                <label><input name="btnSelectAll" value="btnDeleteGallery" type="checkbox"></label>
                                            </th>
                                            <th width="60px">Imagem</th>
                                            <th width="30px">Cor</th>
                                            <th>Link Vídeo</th>
                                            <th width="90px">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody data-route="{{route('admin.prod05.gallery.sorting')}}">
                                        @foreach ($galleryType->galleries as $gallery)
                                            <tr data-code="{{$gallery->id}}">
                                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                                <td class="bs-checkbox align-middle">
                                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$gallery->id}}"></label>
                                                </td>
                                                <td class="align-middle avatar-group">
                                                    @if ($gallery->path_image)
                                                        <a href="{{asset('storage/' . $gallery->path_image)}}" data-fancybox="gallery-{{$gallery->color->id}}">
                                                            <div class="avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $gallery->path_image)}})"></div>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td class="align-middle" style="background-color: {{$gallery->color->color}}"></td>
                                                <td class="align-middle">
                                                    <div class="d-flex aling-items-center">
                                                        <a href="{{$gallery->link_video}}" target="_blank" class="mdi mdi-link font-22 me-3" {{!$gallery->link_video?'style=display:none;':''}}></a>
                                                        {!! Form::text('link_video', $gallery->link_video??null, ['data-route' => route('admin.prod05.changeList', ['PROD05ProductsGallery' => $gallery->id]),'class'=>'form-control link_video embedLinkYoutube', 'id'=>'link_video', 'placeholder'=>'insira o link do vídeo aqui, a imagem servirá para thumbnail do vídeo']) !!}
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    <form action="{{route('admin.prod05.gallery.destroy',['PROD05ProductsGallery' => $gallery->id])}}" method="POST">
                                                        @method('DELETE') @csrf
                                                        <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
<!-- end row -->

{{-- BEGIN MODAL gallery CREATE --}}
<div id="modal-gallery-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Imagens</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Products.PROD05.Gallery.form')
            </div>
        </div>
    </div>
</div>
{{-- END MODAL gallery CREATE --}}

<script>
    $(function(){
        $('.link_video').on('change', function(){
            embedLinkYoutube($(this))

            var link_video = $(this).val();
            $(this).parent().find('a').attr('href', link_video);

            if(link_video != ''){
                $(this).parent().find('a').show();
            }else{
                $(this).parent().find('a').hide();
            }

            $.ajax({
                url: $(this).data('route'),
                type: 'POST',
                data: {link_video}
            })
        })
    })
</script>
