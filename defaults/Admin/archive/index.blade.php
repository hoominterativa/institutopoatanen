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
                                    <li class="breadcrumb-item active">TESTE</li>
                                </ol>
                            </div>
                            <h4 class="page-title">TESTE</h4>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <button id="btSubmitDelete" data-route="{{route('delete')}}" type="button" class="btn btn-danger" onclick="" style="display: none;">Deletar selecionados</button>
                                <table data-toggle="table" data-page-size="5" data-pagination="false" class="table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="bs-checkbox">
                                                <label><input name="btSelectAll" type="checkbox"></label>
                                            </th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Job Title</th>
                                            <th>DOB</th>
                                            <th>Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($teste as $key => $test)
                                            <tr>
                                                <td class="bs-checkbox">
                                                    <label><input data-index="{{$key}}" name="btSelectItem" class="btSelectItem" type="checkbox" value="{{$test->id}}"></label>
                                                </td>
                                                <td>Isidra</td>
                                                <td>Boudreaux</td>
                                                <td>Traffic Court Referee</td>
                                                <td>22 Jun 1972</td>
                                                <td>
                                                    <span class="badge bg-success">Ativo</span>
                                                    <span class="badge bg-primary text-white">Destaque</span>
                                                    <span class="badge bg-danger">Inativo</span>
                                                </td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <a href="" class="btn-icon mdi mdi-square-edit-outline"></a>
                                                        </div>
                                                        <form action="{{route('code.delete')}}" class="col-4" method="POST">
                                                            @method('DELETE') @csrf
                                                            <button type="button" class="btn-icon btSubmitDeleteItem"><i class="mdi mdi-trash-can"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {{-- PAGINATION --}}
                                {{-- <div class="mt-3 float-end">
                                    {{$teste->links()}}
                                </div> --}}
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
    @include('Admin.components.links.resourcesIndex')
@endsection
