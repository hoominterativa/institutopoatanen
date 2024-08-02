@extends('Admin.core.admin')
@section('content')
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">{{getTitleModel($configModelsMain, 'ContentPages', 'COPA04')}}</li>
                                </ol>
                            </div>
                            <h4 class="page-title">{{getTitleModel($configModelsMain, 'ContentPages', 'COPA04')}}</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->
                <ul class="mb-0 nav nav-tabs" id="tooltip-container">
                    <li class="nav-item">
                        <a href="#sectionHero" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link active d-flex align-items-center">
                            Seção Banner
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do conteúdo principal"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionVideo" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Vídeo
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Cadastro do banner da página"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionHighlighteds" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Destaque
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida abaixo do conteúdo principal na página"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionTopic" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Tópico
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Aqui você pode cadastrar um ou mais tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#topicCarousel" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Carossel
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida como complemento dos tópicos"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionGallery" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Galeria
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#additionalContents" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Conteúdo adicional
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#additionalTopics" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Tópico adicional
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#faq" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção FAQ
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#sectionProduct" data-bs-toggle="tab" aria-expanded="true"
                            class="nav-link d-flex align-items-center">
                            Seção Produtos
                            <i href="javascript:void(0)" class="mdi mdi-help-circle font-20 ms-2 btn-icon"
                                data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-original-title="Esta seção será exibida no final da página."></i>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="sectionHero">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <button id="btSubmitDelete" data-route="{{route('admin.copa04.sectionHero.destroySelected')}}" type="button" class="btn btn-danger btnDeleteContentPages" style="display: none;">Deletar selecionados</button>
                                            </div>
                                            <div class="col-6">
                                                @if (!$sectionHero)
                                                    <a href="{{route('admin.copa04.sectionHero.create')}}" class="btn btn-success float-end">Adicionar novo <i class="mdi mdi-plus"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                        <table class="table table-bordered table-sortable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Título</th>
                                                    <th>Imagem</th>
                                                    <th width="100px">Status</th>
                                                    <th width="90px">Ações</th>
                                                </tr>
                                            </thead>
        
                                            <tbody>
                                                @if ($sectionHero)
                                                    <tr>
                                                        <td class="align-middle">{{$sectionHero->title}}</td>
                                                        <td class="align-middle avatar-group">
                                                            <div class="avatar-group-item avatar-bg rounded-circle avatar-sm" style="background-image: url({{asset('storage/'.$sectionHero->path_image)}})"></div>
                                                        </td>
                                                        <td class="align-middle">
                                                            @switch($sectionHero->active)
                                                                @case(1)
                                                                    <span class="badge bg-success">Ativo</span>
                                                                    @break
                                                                @case(0)
                                                                    <span class="badge bg-danger">Inativo</span>
                                                                    @break
                                                                @default                                                            
                                                            @endswitch
                                                        </td>
                                                        <td class="align-middle">
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <a href="{{route('admin.copa04.sectionHero.edit',['COPA04ContentPagesSectionHero' => $sectionHero->id])}}" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                                </div>
                                                                <form action="{{route('admin.copa04.sectionHero.destroy',['COPA04ContentPagesSectionHero' => $sectionHero->id])}}" class="col-4" method="POST">
                                                                    @method('DELETE') @csrf
                                                                    <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                    </div>
                    <div class="tab-pane" id="sectionVideo">
                        @include('Admin.cruds.ContentPages.COPA04.SectionVideo.index')
                    </div>
                    <div class="tab-pane" id="sectionHighlighteds">
                        @include('Admin.cruds.ContentPages.COPA04.SectionHighlighted.index')
                    </div>
                    <div class="tab-pane" id="sectionTopic">
                        @include('Admin.cruds.ContentPages.COPA04.SectionTopic.index')
                    </div>
                    <div class="tab-pane" id="topicCarousel">
                        @include('Admin.cruds.ContentPages.COPA04.TopicCarousel.index')
                    </div>
                    <div class="tab-pane" id="sectionGallery">
                        @include('Admin.cruds.ContentPages.COPA04.Gallery.index')
                    </div>
                    <div class="tab-pane" id="additionalContents">
                        @include('Admin.cruds.ContentPages.COPA04.AdditionalContent.index')
                    </div>
                    <div class="tab-pane" id="additionalTopics">
                        @include('Admin.cruds.ContentPages.COPA04.AdditionalTopics.index')
                    </div>
                    <div class="tab-pane" id="faq">
                        @include('Admin.cruds.ContentPages.COPA04.Faq.index')
                    </div>
                    <div class="tab-pane" id="sectionProduct">
                        @include('Admin.cruds.ContentPages.COPA04.SectionProducts.index')
                    </div>
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
