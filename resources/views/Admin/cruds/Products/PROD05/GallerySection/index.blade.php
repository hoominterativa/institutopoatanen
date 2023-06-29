<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <button id="btSubmitDelete" data-route="{{route('admin.prod05.gallery.destroySelected')}}" type="button" class="btn btn-danger btnDeleteGallery" style="display: none;">Deletar selecionados</button>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)"  data-bs-target="#modal-gallerySection-create" data-bs-toggle="modal" class="btn btn-success float-end">Adicionar Imagens <i class="mdi mdi-plus"></i></a>
                    </div>
                </div>
                <table class="table table-bordered table-sortable">
                    <thead class="table-light">
                        <tr>
                            <th width="50px"></th>
                            <th width="30px" class="bs-checkbox">
                                <label><input name="btnSelectAll" value="btnDeleteGallery" type="checkbox"></label>
                            </th>
                            <th width="60px">Imagem</th>
                            <th>Link Vídeo</th>
                            <th width="90px">Ações</th>
                        </tr>
                    </thead>

                    <tbody data-route="{{route('admin.prod05.gallerySection.sorting')}}">
                        @foreach ($galleriesSection as $gallerySection)
                            <tr data-code="{{$gallerySection->id}}">
                                <td class="align-middle"><span class="btnDrag mdi mdi-drag-horizontal font-22"></span></td>
                                <td class="bs-checkbox align-middle">
                                    <label><input name="btnSelectItem" class="btnSelectItem" type="checkbox" value="{{$gallerySection->id}}"></label>
                                </td>
                                <td class="align-middle avatar-group">
                                    @if ($gallerySection->path_image)
                                        <a href="{{asset('storage/' . $gallerySection->path_image)}}" data-fancybox="gallery">
                                            <div class="avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/' . $gallerySection->path_image)}})"></div>
                                        </a>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex aling-items-center">
                                        <a href="{{$gallerySection->link_video}}" target="_blank" class="mdi mdi-link font-22 me-3" {{!$gallerySection->link_video?'style=display:none;':''}}></a>
                                        {!! Form::text('link_video', $gallerySection->link_video??null, ['data-route' => route('admin.prod05.gallerySection.changeList', ['PROD05ProductsGallerySection' => $gallerySection->id]),'class'=>'form-control link_video embedLinkYoutube', 'id'=>'link_video', 'placeholder'=>'insira o link do vídeo aqui, a imagem servirá para thumbnail do vídeo']) !!}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <form action="{{route('admin.prod05.gallerySection.destroy',['PROD05ProductsGallerySection' => $gallerySection->id])}}" method="POST">
                                        @method('DELETE') @csrf
                                        <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-->
    </div> <!-- end col-->
</div>
<!-- end row -->

{{-- BEGIN MODAL gallery CREATE --}}
<div id="modal-gallerySection-create" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-header p-3 pt-2 pb-2">
                <h4 class="page-title">Cadastrar Imagens</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3 pt-0 pb-3">
                @include('Admin.cruds.Products.PROD05.GallerySection.form')
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
