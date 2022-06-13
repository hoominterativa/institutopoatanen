<?php include_once "_includes/header.php"; ?>
<div class="page-content">
    <div class="card">
        <div class="card-body">

            <h4 class="mt-0 mb-2 font-weight-semibold">Introdução</h4>

            <p>
                Sistema para criação de site em módulos, oferecendo facilidade na construção e funcionalidades para indexação.
                <br> Nessa documentação você encontrará tudo que precisa para montar um site ou construir os módulos, recomendamos ler com atenção toda a documentação antes de começar a trabalhar no sistema.
                <br><br> O sistema consiste basicamente em <b>Módulos</b> (module) e <b>Modelos</b> (code), os módulos representam a área principal de um site, Ex.: Artigos, Produtos, Slides e etc. Já os modelos representam os
                tipos de estilos e formatações do módulo logo cada modelo pode ou não ter as mesmas informações porém com formatações diferentes.
                <br> A construção dos códigos dos modelos são basicamente as 4 primeiras letras do nome do Módulo em maiúsculo e a sequencia numeral do proximo modelo Ex.: Articles (ARTI01). Em nomes compostos poderá ser usado 2 letras de cada palavra. Ex.: ArticlesAuthor (ARAU01)
            </p>
        </div>
    </div>
    <div class="card m-b-30">
        <div class="card-body">

            <h4 class="mt-0 mb-2 font-weight-semibold">Estrutura base Laravel Modificada</h4>

            <pre>

├── app
├── bootstrap
├── config
├── database
├── defaults
├── public
├── resources
│   ├── views
│   │   └── Admin
│   │   │   └── assets
│   │   │   └── auth
│   │   │   └── components
│   │   │   └── core
│   │   │   └── cruds
│   │   │   │   └── contactForm
│   │   │   │   └── contactLead
│   │   │   │   └── generalSettings
│   │   │   │   └── Optimization
│   │   │   │   └── OptimizePage
│   │   │   │   └── User
│   │   │   └── dashboard.blade.php
│   │   │   └── icons.blade.php
│   │   └── Client
│   │   │   └── assets
│   │   │   └── core
│   │   │   └── pages
│   │   │   └── home.blade.php
├── routes
├── storage
├── stubs
└── tests

            </pre>

        </div>
    </div>
    <div class="card">
        <div class="card-body">


            <h4 class="mt-0 mb-2 font-weight-semibold">Créditos/Plugins</h4>
            <p>
                Aqui está a lista de plugins com a documentação oficial. Não seria fácil de construir sem usá-los e somos gratos a eles.
            </p>

            <div class="table-responsive">
                <table class="table table-sm mb-0 font-14">
                    <thead>
                        <tr>
                            <th class="font-weight-semibold">Plugins</th>
                            <th class="font-weight-semibold">Url</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Bootstrap</td>
                            <td><a href="http://getbootstrap.com/" target="_blank">http://getbootstrap.com/</a></td>
                        </tr>
                        <tr>
                            <td>jQuery</td>
                            <td><a href="https://jquery.com/" target="_blank">https://jquery.com/</a></td>
                        </tr>
                        <tr>
                            <td>Animate</td>
                            <td><a href="https://daneden.github.io/animate.css/" target="_blank">https://daneden.github.io/animate.css/</a></td>
                        </tr>
                        <tr>
                            <td>Autocomplete</td>
                            <td><a href="https://github.com/devbridge/jQuery-Autocomplete" target="_blank">https://github.com/devbridge/jQuery-Autocomplete</a></td>
                        </tr>
                        <tr>
                            <td>Autonumeric</td>
                            <td><a href="https://github.com/autoNumeric/autoNumeric" target="_blank">https://github.com/autoNumeric/autoNumeric</a></td>
                        </tr>
                        <tr>
                            <td>Bootstrap-colorpicker</td>
                            <td><a href="https://farbelous.io/bootstrap-colorpicker/" target="_blank">https://farbelous.io/bootstrap-colorpicker/</a></td>
                        </tr>
                        <tr>
                            <td>Bootstrap Maxlength</td>
                            <td><a href="https://mimo84.github.io/bootstrap-maxlength/" target="_blank">https://mimo84.github.io/bootstrap-maxlength/</a></td>
                        </tr>
                        <tr>
                            <td>Bootstrap-select</td>
                            <td><a href="https://developer.snapappointments.com/bootstrap-select/" target="_blank">https://developer.snapappointments.com/bootstrap-select/</a></td>
                        </tr>
                        <tr>
                            <td>Bootstrap-table</td>
                            <td><a href="https://github.com/wenzhixin/bootstrap-table" target="_blank">https://github.com/wenzhixin/bootstrap-table</a></td>
                        </tr>
                        <tr>
                            <td>Clockpicker</td>
                            <td><a href="http://weareoutman.github.io/clockpicker/" target="_blank">http://weareoutman.github.io/clockpicker/</a></td>
                        </tr>
                        <tr>
                            <td>Dropify</td>
                            <td><a href="http://jeremyfagis.github.io/dropify/" target="_blank">http://jeremyfagis.github.io/dropify/</a></td>
                        </tr>
                        <tr>
                            <td>Fullcalendar</td>
                            <td><a href="https://fullcalendar.io/" target="_blank">https://fullcalendar.io/</a></td>
                        </tr>
                        <tr>
                            <td>Jquery-mask-plugin</td>
                            <td><a href="https://github.com/igorescobar/jQuery-Mask-Plugin" target="_blank">https://github.com/igorescobar/jQuery-Mask-Plugin</a></td>
                        </tr>

                        <tr>
                            <td>Parsleyjs</td>
                            <td><a href="http://parsleyjs.org/" target="_blank">http://parsleyjs.org/</a></td>
                        </tr>
                        <tr>
                            <td>Select2</td>
                            <td><a href="https://select2.org/" target="_blank">https://select2.org/</a></td>
                        </tr>
                        <tr>
                            <td>Summernote</td>
                            <td><a href="https://summernote.org/" target="_blank">https://summernote.org/</a></td>
                        </tr>
                        <tr>
                            <td>Sweetalert2</td>
                            <td><a href="https://sweetalert2.github.io/" target="_blank">https://sweetalert2.github.io/</a></td>
                        </tr>
                        <tr>
                            <td>Tippy-js</td>
                            <td><a href="https://atomiks.github.io/tippyjs/" target="_blank">https://atomiks.github.io/tippyjs/</a></td>
                        </tr>
                        <tr>
                            <td>toastr</td>
                            <td><a href="https://github.com/CodeSeven/toastr" target="_blank">https://github.com/CodeSeven/toastr</a></td>
                        </tr>
                        <tr>
                            <td>Bootstrap Datepicker</td>
                            <td><a href="https://uxsolutions.github.io/bootstrap-datepicker/" target="_blank">https://uxsolutions.github.io/bootstrap-datepicker/</a></td>
                        </tr>
                        <tr>
                            <td>Sortable JS</td>
                            <td><a href="https://github.com/SortableJS/Sortable" target="_blank">https://github.com/SortableJS/Sortable</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once "_includes/footer.php"; ?>
                    