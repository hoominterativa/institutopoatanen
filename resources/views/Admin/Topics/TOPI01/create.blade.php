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
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <form class="parsley-examples">
                                    <div class="mb-3">
                                        <label for="validationCustom01" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="validationCustom01" placeholder="First name" />
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Radio *:</label>

                                        <div class="radio mb-1">
                                            <input type="radio" name="gender" id="genderM" value="Male" required="">
                                            <label for="genderM">Male</label>
                                        </div>
                                        <div class="radio">
                                            <input type="radio" name="gender" id="genderF" value="Female">
                                            <label for="genderF">Female</label>
                                        </div>
                                    </div>
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
                                    <div class="mb-3">
                                        <label for="message" class="form-label">Textarea (20 chars min, 100 max) :</label>
                                        <textarea id="message" class="form-control" name="message" required
                                            data-parsley-trigger="keyup"
                                            data-parsley-minlength="20"
                                            data-parsley-maxlength="100"
                                            data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."
                                            data-parsley-validation-threshold="10"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="invalidCheck" required />
                                            <label class="form-check-label" for="invalidCheck">Checkbox</label>
                                            <div class="invalid-feedback">
                                                You must agree before submitting.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-description" class="form-label">Product Description <span class="text-danger">*</span></label>
                                        <div id="snow-editor" style="height: 150px;"></div> <!-- end Snow-editor-->
                                    </div>
                                    <button class="btn btn-primary" type="submit">Submit form</button>
                                </form>

                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Dropify File Upload</h4>
                                <p class="sub-header">
                                    Override your input files with style. Your so fresh input file — Default version.
                                </p>

                                <input type="file" data-plugins="dropify" data-height="300" />

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mt-3">
                                            <input type="file" data-plugins="dropify" data-default-file="../assets/images/small/img-2.jpg"  />
                                            <p class="text-muted text-center mt-2 mb-0">Default File</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mt-3">
                                            <input type="file" data-plugins="dropify" disabled="disabled"  />
                                            <p class="text-muted text-center mt-2 mb-0">Disabled the input</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mt-3">
                                            <input type="file" data-plugins="dropify" data-max-file-size="1M" />
                                            <p class="text-muted text-center mt-2 mb-0">Max File size</p>
                                        </div>
                                    </div>
                                </div> <!-- end row -->

                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Parsley Examples</h4>
                                <p class="sub-header">Parsley is a javascript form validation library. It helps you provide your users with feedback on
                                their form submission before sending it to your server.</p>

                                <div class="alert alert-warning d-none fade show">
                                    <h4 class="mt-0 text-warning">Oh snap!</h4>
                                    <p class="mb-0">This form seems to be invalid :(</p>
                                </div>

                                <div class="alert alert-info d-none fade show">
                                    <h4 class="mt-0 text-info">Yay!</h4>
                                    <p class="mb-0">Everything seems to be ok :)</p>
                                </div>

                                <form id="demo-form" data-parsley-validate="">
                                    <div class="mb-3">
                                        <label for="fullname" class="form-label">Full Name * :</label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" required="">
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email * :</label>
                                        <input type="email" id="email" class="form-control" name="email" data-parsley-trigger="change" required="">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Gender *:</label>

                                        <div class="radio mb-1">
                                            <input type="radio" name="gender" id="genderM" value="Male" required="">
                                            <label for="genderM">Male</label>
                                        </div>
                                        <div class="radio">
                                            <input type="radio" name="gender" id="genderF" value="Female">
                                            <label for="genderF">Female</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Hobbies (Optional, but 2 minimum):</label>

                                        <div class="checkbox checkbox-pink mb-1">
                                            <input type="checkbox" name="hobbies[]" id="hobby1" value="ski" data-parsley-mincheck="2" />
                                            <label for="hobby1"> Skiing </label>
                                        </div>
                                        <div class="checkbox checkbox-pink mb-1">
                                            <input type="checkbox" name="hobbies[]" id="hobby2" value="run" />
                                            <label for="hobby2"> Running </label>
                                        </div>
                                        <div class="checkbox checkbox-pink">
                                            <input type="checkbox" name="hobbies[]" id="hobby3" value="eat" />
                                            <label for="hobby3"> Eating </label>
                                        </div>
                                    </div>


                                    <div class="mb-3">
                                        <label for="heard" class="form-label">Heard about us via *:</label>
                                        <select id="heard" class="form-select" required="">
                                            <option value="">Choose..</option>
                                            <option value="press">Press</option>
                                            <option value="net">Internet</option>
                                            <option value="mouth">Word of mouth</option>
                                            <option value="other">Other..</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">Message (20 chars min, 100 max) :</label>
                                        <textarea id="message" class="form-control" name="message"
                                            data-parsley-trigger="keyup" data-parsley-minlength="20"
                                            data-parsley-maxlength="100"
                                            data-parsley-minlength-message="Come on! You need to enter at least a 20 character comment.."
                                            data-parsley-validation-threshold="10">
                                        </textarea>
                                    </div>

                                    <div>
                                        <input type="submit" class="btn btn-success" value="Validate">
                                    </div>

                                </form>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div>
                <!-- end row-->


                <div class="row">
                    <div class="col-lg-6">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Basic Form</h4>
                                <p class="text-muted font-14">
                                    Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.
                                </p>

                                <form action="#" class="parsley-examples">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">User Name<span class="text-danger">*</span></label>
                                        <input type="text" name="nick" parsley-trigger="change" required placeholder="Enter user name" class="form-control" id="userName" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="emailAddress" class="form-label">Email address<span class="text-danger">*</span></label>
                                        <input type="email" name="email" parsley-trigger="change" required placeholder="Enter email" class="form-control" id="emailAddress" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="pass1" class="form-label">Password<span class="text-danger">*</span></label>
                                        <input id="pass1" type="password" placeholder="Password" required class="form-control" />
                                    </div>
                                    <div class="mb-3">
                                        <label for="passWord2" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <input data-parsley-equalto="#pass1" type="password" required placeholder="Password" class="form-control" id="passWord2" />
                                    </div>
                                    <div class="mb-3">
                                        <div class="checkbox checkbox-purple">
                                            <input id="checkbox6a" type="checkbox" />
                                            <label for="checkbox6a">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
                                        <button type="reset" class="btn btn-secondary waves-effect">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div>
                    <!-- end col -->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Horizontal Form</h4>
                                <p class="text-muted font-14">
                                    Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.
                                </p>

                                <form role="form" class="parsley-examples">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-4 col-form-label">Email<span class="text-danger">*</span></label>
                                        <div class="col-7">
                                            <input type="email" required parsley-type="email" class="form-control" id="inputEmail3" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="hori-pass1" class="col-4 col-form-label">Password<span class="text-danger">*</span></label>
                                        <div class="col-7">
                                            <input id="hori-pass1" type="password" placeholder="Password" required class="form-control" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="hori-pass2" class="col-4 col-form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="col-7">
                                            <input data-parsley-equalto="#hori-pass1" type="password" required placeholder="Password" class="form-control" id="hori-pass2" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="webSite" class="col-4 col-form-label">Web Site<span class="text-danger">*</span></label>
                                        <div class="col-7">
                                            <input type="url" required parsley-type="url" class="form-control" id="webSite" placeholder="URL" />
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-8 offset-4">
                                            <div class="checkbox checkbox-purple">
                                                <input id="checkbox6" type="checkbox" />
                                                <label for="checkbox6">Remember me</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-8 offset-4">
                                            <button type="submit" class="btn btn-primary waves-effect waves-light">Register</button>
                                            <button type="reset" class="btn btn-secondary waves-effect">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Validation type</h4>
                                <p class="text-muted font-14">
                                    Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.
                                </p>

                                <form action="#" class="parsley-examples">
                                    <div class="mb-3">
                                        <label class="form-label">Required</label>
                                        <input type="text" class="form-control" required placeholder="Type something" />
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Equal To</label>
                                        <div>
                                            <input type="password" id="pass2" class="form-control" required placeholder="Password" />
                                        </div>
                                        <div class="mt-2">
                                            <input type="password" class="form-control" required data-parsley-equalto="#pass2" placeholder="Re-Type Password" />
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">E-Mail</label>
                                        <div>
                                            <input type="email" class="form-control" required parsley-type="email" placeholder="Enter a valid e-mail" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">URL</label>
                                        <div>
                                            <input parsley-type="url" type="url" class="form-control" required placeholder="URL" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Digits</label>
                                        <div>
                                            <input data-parsley-type="digits" type="text" class="form-control" required placeholder="Enter only digits" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Number</label>
                                        <div>
                                            <input data-parsley-type="number" type="text" class="form-control" required placeholder="Enter only numbers" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alphanumeric</label>
                                        <div>
                                            <input data-parsley-type="alphanum" type="text" class="form-control" required placeholder="Enter alphanumeric value" />
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Textarea</label>
                                        <div>
                                            <textarea required class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                        <button type="reset" class="btn btn-secondary waves-effect">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col-->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Range validation</h4>
                                <p class="text-muted font-14">
                                    Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.
                                </p>

                                <form action="#" class="parsley-examples">
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

                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button>
                                        <button type="reset" class="btn btn-secondary waves-effect">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Flatpickr - Date picker</h4>
                                <p class="sub-header">A lightweight and powerful datetimepicker</p>

                                <div class="mb-3">
                                    <label class="form-label">Basic</label>
                                    <input type="text" id="basic-datepicker" class="form-control" placeholder="Basic datepicker">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Date & Time</label>
                                    <input type="text" id="datetime-datepicker" class="form-control" placeholder="Date and Time">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Human-friendly Dates</label>
                                    <input type="text" id="humanfd-datepicker" class="form-control" placeholder="October 9, 2018">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">MinDate and MaxDate</label>
                                    <input type="text" id="minmax-datepicker" class="form-control" placeholder="mindate - maxdate">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Disabling dates</label>
                                    <input type="text" id="disable-datepicker" class="form-control" placeholder="Disabling dates">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Selecting multiple dates</label>
                                    <input type="text" id="multiple-datepicker" class="form-control" placeholder="Multiple dates">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Selecting multiple dates - Conjunction</label>
                                    <input type="text" id="conjunction-datepicker" class="form-control" placeholder="2018-10-10 :: 2018-10-11">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Range Calendar</label>
                                    <input type="text" id="range-datepicker" class="form-control" placeholder="2018-10-03 to 2018-10-10">
                                </div>

                                <div>
                                    <label class="form-label">Inline Calendar</label>
                                    <input type="text" id="inline-datepicker" class="form-control" placeholder="Inline calendar">
                                </div>
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col -->

                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Flatpickr - Time Picker</h4>
                                <p class="sub-header">A lightweight and powerful datetimepicker</p>

                                <div class="mb-3">
                                    <label class="form-label">Basic</label>
                                    <input type="text" id="basic-timepicker" class="form-control" placeholder="Basic timepicker">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">24-hour Time Picker</label>
                                    <input type="text" id="24hours-timepicker" class="form-control" placeholder="16:21">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Time Picker w/ Limits</label>
                                    <input type="text" id="minmax-timepicker" class="form-control" placeholder="Limits">
                                </div>

                                <div>
                                    <label class="form-label">Preloading Time</label>
                                    <input type="text" id="preloading-timepicker" class="form-control" placeholder="Pick a time">
                                </div>
                            </div>
                        </div> <!-- end card-->


                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Colorpicker</h4>
                                <p class="sub-header">Examples of Spectrum Colorpicker.</p>

                                <div class="mb-3">
                                    <label class="form-label">Simple input field</label>
                                    <input type="text" class="form-control" id="colorpicker-default" value="#4a81d4">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Show Alpha</label>
                                    <input type="text" class="form-control" id="colorpicker-showalpha" value="rgba(26, 188, 156, 0.6)">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Show Palette Only</label>
                                    <input type="text" class="form-control" id="colorpicker-showpaletteonly" value="#f1556c">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Toggle Palette Only</label>
                                    <input type="text" class="form-control" id="colorpicker-togglepaletteonly" value="#f7b84b">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Show Initial</label>
                                    <input type="text" class="form-control" id="colorpicker-showintial" value="#f672a7">
                                </div>
                                <div>
                                    <label class="form-label">Show Input And Initial</label>
                                    <input type="text" class="form-control" id="colorpicker-showinput-intial" value="#4fc6e1">
                                </div>
                            </div>
                        </div> <!-- end card-->

                    </div> <!-- end col -->
                </div>
                <!-- end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Clock Picker</h4>
                                <p class="sub-header">A clock-style timepicker for Bootstrap.</p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Default Clock Picker</label>
                                            <div class="input-group clockpicker">
                                                <input type="text" class="form-control" value="09:30">
                                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="form-label">Auto close</label>
                                            <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                                                <input type="text" class="form-control" value="13:14">
                                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                            </div>
                                        </div>
                                    </div> <!-- end col-->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Now time</label>
                                            <div class="input-group">
                                                <input class="form-control" id="single-input" type="text" value="" placeholder="Now">
                                                <button type="button" id="check-minutes" class="btn waves-effect waves-light btn-primary">Check the minutes</button>
                                            </div>
                                        </div>

                                        <div>
                                            <label class="form-label">Place at left, align the arrow to top </label>
                                            <div class="input-group clockpicker" data-placement="top" data-align="top">
                                                <input type="text" class="form-control" value="13:14">
                                                <span class="input-group-text"><i class="mdi mdi-clock-outline"></i></span>
                                            </div>
                                        </div>
                                    </div> <!-- end col-->
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
                <!-- end row-->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Bootstrap Datepicker</h4>
                                <p class="text-muted font-14">
                                    Bootstrap-datepicker provides a flexible datepicker widget in the Bootstrap style.
                                </p>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date Picker</label>
                                            <input type="text" class="form-control" data-provide="datepicker">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Date View</label>
                                            <input type="text" class="form-control" data-provide="datepicker" data-date-format="d-M-yyyy">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Multi Datepicker</label>
                                            <input type="text" class="form-control" data-provide="datepicker" data-date-multidate="true">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Autoclose</label>
                                            <input type="text" class="form-control" data-provide="datepicker" data-date-autoclose="true">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Month View</label>
                                            <input type="text" class="form-control" data-provide="datepicker" data-date-format="MM yyyy" data-date-min-view-mode="1">
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Year View</label>
                                            <input type="text" class="form-control" data-provide="datepicker" data-date-min-view-mode="2">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Inline Datepicker</label>
                                            <div data-provide="datepicker-inline"></div>
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- end card-body -->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Input Masks</h4>
                                <p class="sub-header">
                                    A jQuery Plugin to make masks on form fields and HTML elements.
                                </p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="mb-3">
                                                <label class="form-label">Date</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00/00/0000">
                                                <span class="font-13 text-muted">e.g "DD/MM/YYYY"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Hour</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00:00:00">
                                                <span class="font-13 text-muted">e.g "HH:MM:SS"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Date & Hour</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00/00/0000 00:00:00">
                                                <span class="font-13 text-muted">e.g "DD/MM/YYYY HH:MM:SS"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">ZIP Code</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00000-000">
                                                <span class="font-13 text-muted">e.g "xxxxx-xxx"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Crazy Zip Code</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0-00-00-00">
                                                <span class="font-13 text-muted">e.g "x-xx-xx-xx"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Money</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000.000.000,00" data-reverse="true">
                                                <span class="font-13 text-muted">e.g "Your money"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Money 2</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="#.##0,00" data-reverse="true">
                                                <span class="font-13 text-muted">e.g "#.##0,00"</span>
                                            </div>

                                        </form>
                                    </div> <!-- end col -->

                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="mb-3">
                                                <label class="form-label">Telephone</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="0000-0000">
                                                <span class="font-13 text-muted">e.g "xxxx-xxxx"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Telephone with Code Area</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(00) 0000-0000">
                                                <span class="font-13 text-muted">e.g "(xx) xxxx-xxxx"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">US Telephone</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(000) 000-0000">
                                                <span class="font-13 text-muted">e.g "(xxx) xxx-xxxx"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">São Paulo Celphones</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="(00) 00000-0000">
                                                <span class="font-13 text-muted">e.g "(xx) xxxxx-xxxx"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">CPF</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="000.000.000-00" data-reverse="true">
                                                <span class="font-13 text-muted">e.g "xxx.xxx.xxxx-xx"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">CNPJ</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="00.000.000/0000-00" data-reverse="true">
                                                <span class="font-13 text-muted">e.g "xx.xxx.xxx/xxxx-xx"</span>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">IP Address</label>
                                                <input type="text" class="form-control" data-toggle="input-mask" data-mask-format="099.099.099.099" data-reverse="true">
                                                <span class="font-13 text-muted">e.g "xxx.xxx.xxx.xxx"</span>
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
                                <p class="sub-header">
                                    A jQuery Plugin to make masks on form fields and HTML elements.
                                </p>

                                <div class="row">
                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="form-group">
                                                <label>Default</label>
                                                <input type="text" placeholder="" class="form-control autonumber" data-digit-group-separator="." data-decimal-character=",">
                                                <span class="font-13 text-muted">e.g. "1.234.567.890.123"</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Auto Numeric ($)</label>
                                                <input type="text" placeholder="" data-currency-symbol="$ " class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "$ $ 1,234,567,890,123"</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Auto Numeric (€)</label>
                                                <input type="text" placeholder="" data-currency-symbol="€ " class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "€ 1,234,567,890,123"</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Auto Numeric (Rs.)</label>
                                                <input type="text" placeholder="" data-currency-symbol="Rs. " class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "Rs. 1,234,567,890,123"</span>
                                            </div>
                                            <div class="form-group m-b-0">
                                                <label>4 digit Group (¥)</label>
                                                <input type="text" placeholder="" data-digital-group-spacing="4" data-currency-symbol="¥ " class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "¥ 1,2345,6789,0123"</span>
                                            </div>

                                        </form>
                                    </div> <!-- end col -->

                                    <div class="col-md-6">
                                        <form action="#">
                                            <div class="form-group">
                                                <label>Auto Numeric (£)</label>
                                                <input type="text" placeholder="" data-currency-symbol="£ " class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "£ 1,234,567,890,123"</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Auto Numeric (%)</label>
                                                <input type="text" placeholder="" data-currency-symbol="%" data-currency-symbol-placement="s" class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "11%"</span>
                                            </div>
                                            <div class="form-group">
                                                <label>Maximum Value (0 - 9999)</label>
                                                <input type="text" placeholder="" data-maximum-value="9999" data-minimum-value="0" class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "9,999"</span>
                                            </div>

                                            <div class="form-group">
                                                <label>Range Value (-99.99 - 1000.00)</label>
                                                <input type="text" placeholder="" data-minimum-value="-99.99" data-maximum-value="1000.00" class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "1000 Or -99.99"</span>
                                            </div>

                                            <div class="form-group m-b-0">
                                                <label>Bracket Value</label>
                                                <input type="text" placeholder="" data-digit-group-separator="." data-decimal-character="," data-minimum-value="-9999.99"
                                                    data-maximum-value="0.00" data-negative-brackets-type-on-blur="(,)" class="form-control autonumber">
                                                <span class="font-13 text-muted">e.g. "(9,999.00)"</span>
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

    @include('Admin.components.links.index.link')
@endsection
