                    </div>
                    <!-- end page-wrapper-->
                </div>

            </div>
            <!-- content -->
            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            2021 © Hoom Interativa
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- bundle -->
    <script src="assets/js/prism.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script>
        $('a').on('click', function(){
            var href = $(this).attr('href')
            if(href.indexOf('#') >= 0){
                event.preventDefault()
                var rolling = $(href).offset().top - 95
                $('body, html').animate({
                    scrollTop: rolling
                })
            }
        })
    </script>
</body>

</html>