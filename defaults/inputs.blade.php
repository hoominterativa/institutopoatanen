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
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Tópicos</a></li>
                                    <li class="breadcrumb-item active">Cadastro de Tópico</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Cadastro de Tópico</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <form class="parsley-examples">
                                    <h4 class="mt-3 mb-3">Input Default</h4>
                                    <div class="mb-3">
                                        <label for="validationCustom01" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="validationCustom01" placeholder="First name" />
                                    </div>
                                    <h4 class="mt-3 mb-3">Date and color Picker</h4>
                                    <div class="mb-3">
                                        <label class="form-label">Autoclose</label>
                                        <input type="text" class="form-control" required data-provide="datepicker" data-date-autoclose="true">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Month View</label>
                                        <input type="text" class="form-control" required data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Year View</label>
                                        <input type="text" class="form-control" required data-provide="datepicker" data-date-min-view-mode="2">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Simple input field</label>
                                        <input type="text" class="form-control" id="colorpicker-default" value="#4a81d4">
                                    </div>
                                    <h4 class="mt-3 mb-3">Selects</h4>
                                    <div class="mb-3">
                                        <label for="heard" class="form-label">Select *:</label>
                                        <select id="heard" class="form-select" required="">
                                            <option value="">Option 1</option>
                                            <option value="Option 2">Option 2</option>
                                            <option value="Option 3">Option 3</option>
                                            <option value="Option 4">Option 4</option>
                                            <option value="Option 5">Option 5</option>
                                        </select>
                                    </div>
                                    <h4 class="mt-3 mb-3">Validate type</h4>
                                    <div class="mb-3">
                                        <label class="form-label">Equal To</label>
                                        <input type="password" id="pass2" class="form-control" required placeholder="Password" />
                                        <input type="password" class="form-control mt-3" required data-parsley-equalto="#pass2" placeholder="Re-Type Password" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">E-Mail</label>
                                        <input type="email" class="form-control" required parsley-type="email" placeholder="Enter a valid e-mail" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">URL</label>
                                        <input parsley-type="url" type="url" class="form-control" required placeholder="URL" />
                                    </div>
                                    <h4 class="mt-3 mb-3">Max, Min, Regular Exp Value</h4>
                                    <div class="mb-3">
                                        <label class="form-label">Min Length</label>
                                        <div>
                                            <input type="text" class="form-control" required data-parsley-minlength="6" placeholder="Min 6 chars." />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Max Length</label>
                                        <div>
                                            <input type="text" class="form-control" required data-parsley-maxlength="6" placeholder="Max 6 chars." />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Range Length</label>
                                        <div>
                                            <input type="text" class="form-control" required data-parsley-length="[5,10]" placeholder="Text between 5 - 10 chars length" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Min Value</label>
                                        <div>
                                            <input type="text" class="form-control" required data-parsley-min="6" placeholder="Min value is 6" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Max Value</label>
                                        <div>
                                            <input type="text" class="form-control" required data-parsley-max="6" placeholder="Max value is 6" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Range Value</label>
                                        <div>
                                            <input class="form-control" required type="text" min="6" max="100" placeholder="Number between 6 - 100" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Regular Exp</label>
                                        <div>
                                            <input type="text" class="form-control" required data-parsley-pattern="#[A-Fa-f0-9]{6}" placeholder="Hex. Color" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Textarea (20 chars min, 100 max) :</label>
                                        <textarea id="message" class="form-control" name="message" required
                                            data-parsley-trigger="keyup"
                                            data-parsley-minlength="20"
                                            data-parsley-maxlength="100"
                                            data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."
                                            data-parsley-validation-threshold="10"></textarea>
                                    </div>
                                    <h4 class="mt-3 mb-3">Radios, Checkbox</h4>
                                    <div class="mb-3 radio">
                                        <input type="radio" name="gender" id="genderM" value="Male" required="">
                                        <label for="genderM">Male</label>
                                    </div>
                                    <div class="mb-3 radio">
                                        <input type="radio" name="gender" id="genderF" value="Female">
                                        <label for="genderF">Female</label>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="invalidCheck" required />
                                        <label class="form-check-label" for="invalidCheck">Checkbox 1</label>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="invalidCheck" required />
                                        <label class="form-check-label" for="invalidCheck">Checkbox 2</label>
                                    </div>
                                    <div class="mb-3 form-check">
                                        <input type="checkbox" class="form-check-input" id="invalidCheck" required />
                                        <label class="form-check-label" for="invalidCheck">Checkbox 3</label>
                                    </div>
                                    <h4 class="mt-3 mb-3">Clock Piker</h4>
                                    <div>
                                        <label class="form-label">Auto close</label>
                                        <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                            <input type="text" class="form-control" value="13:14">
                                            <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                        </div>
                                    </div>
                                    <h4 class="mt-3 mb-3">CK Editor</h4>
                                    <div class="mb-3">
                                        <label for="basic-editor" class="form-label">Description</label>
                                        <textarea id="basic-editor" class="form-control" name="message"></textarea>
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </form>

                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">File Upload</h4>

                                <input type="file" data-plugins="dropify" data-height="300" />

                                <div class="mt-3">
                                    <input type="file" data-plugins="dropify" data-default-file="../assets/images/small/img-2.jpg"  />
                                    <p class="text-muted text-center mt-2 mb-0">Default File</p>
                                </div>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Input Masks</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="mb-3">
                                                <label class="form-label">Date</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00/00/0000">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Hour</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00:00:00">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Date & Hour</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00/00/0000 00:00:00">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">ZIP Code</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00000-000">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Crazy Zip Code</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0-00-00-00">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Money</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Money 2</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="#.##0,00" data-reverse="true">
                                            </div>

                                        </form>
                                    </div> <!-- end col -->

                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="mb-3">
                                                <label class="form-label">Telephone</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0000-0000">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Telephone with Code Area</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(00) 0000-0000">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">US Telephone</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(000) 000-0000">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">São Paulo Celphones</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(00) 00000-0000">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">CPF</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000-00" data-reverse="true">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">CNPJ</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00.000.000/0000-00" data-reverse="true">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">IP Address</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="099.099.099.099" data-reverse="true">
                                            </div>

                                        </form>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div> <!-- end row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Auto Numberic</h4>

                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="mb-3">
                                                <label>Default</label>
                                                <input type="text" placeholder="" class="form-control autonumber" data-digit-group-separator="." data-decimal-character=",">
                                            </div>
                                            <div class="mb-3">
                                                <label>Auto Numeric ($)</label>
                                                <input type="text" placeholder="" data-currency-symbol="$ " class="form-control autonumber">
                                            </div>
                                            <div class="mb-3">
                                                <label>Auto Numeric (€)</label>
                                                <input type="text" placeholder="" data-currency-symbol="€ " class="form-control autonumber">
                                            </div>
                                            <div class="mb-3">
                                                <label>Auto Numeric (Rs.)</label>
                                                <input type="text" placeholder="" data-currency-symbol="Rs. " class="form-control autonumber">
                                            </div>
                                            <div class="mb-3"m-b-0">
                                                <label>4 digit Group (¥)</label>
                                                <input type="text" placeholder="" data-digital-group-spacing="4" data-currency-symbol="¥ " class="form-control autonumber">
                                            </div>

                                        </form>
                                    </div> <!-- end col -->

                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="mb-3">
                                                <label>Auto Numeric (£)</label>
                                                <input type="text" placeholder="" data-currency-symbol="£ " class="form-control autonumber">
                                            </div>
                                            <div class="mb-3">
                                                <label>Auto Numeric (%)</label>
                                                <input type="text" placeholder="" data-currency-symbol="%" data-currency-symbol-placement="s" class="form-control autonumber">
                                            </div>
                                            <div class="mb-3">
                                                <label>Maximum Value (0 - 9999)</label>
                                                <input type="text" placeholder="" data-maximum-value="9999" data-minimum-value="0" class="form-control autonumber">
                                            </div>

                                            <div class="mb-3">
                                                <label>Range Value (-99.99 - 1000.00)</label>
                                                <input type="text" placeholder="" data-minimum-value="-99.99" data-maximum-value="1000.00" class="form-control autonumber">
                                            </div>

                                            <div class="mb-3">
                                                <label>Bracket Value</label>
                                                <input type="text" placeholder="" data-digit-group-separator="." data-decimal-character="," data-minimum-value="-9999.99"
                                                    data-maximum-value="0.00" data-negative-brackets-type-on-blur="(,)" class="form-control autonumber">
                                            </div>

                                        </form>
                                    </div> <!-- end col -->
                                </div>
                                <!-- end row -->

                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div> <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->

    </div>

    @include('Admin.components.links.resources')
@endsection
