<?php include_once "_includes/header.php"; ?>
<div class="page-content">
    <div class="card">
        <div class="card-body">
            <div class="p-lg-1">
                <h4 class="mb-2 mt-0 font-weight-semibold">Padrões e etilos</h4>

                <p>
                    O sistema utiliza para a árrea administrativa a estrutura padrão do <b>UBOLD 5.1.0</b> template. Para o site um padrão rigoroso deverá ser seguido no desenvolvimento.<br>
                    Para facilitar estamos utilizando o <a href="https://getbootstrap.com/docs/5.0/getting-started/introduction/" target="_blank">Bootstrap 5</a> 
                </p>

                <p class="mb-4">In your html file, simply change the reference of
                    <code>app.min.css</code> and <code>app-dark.min</code> with respective demo (skin) css file and you would have it activated.
                </p>
                <div class="mt-2">
                    <h4 class="mt-0 mb-2 font-weight-semibold">Customizing Color Palette
                    </h4>
                    <p>You can change the color palatte of any demo very easily by simply changing the few scss variables value.</p>
                    <p class="mb-0">In order to modify the colors in existing themes, open the <code>_variables.scss</code> file from
                        <code>src/assets/scss/config/&lt;DEMO_NAME&gt;</code> and change any variable in it. Your changes would get reflected automatically in any bootstrap based components or elements. Note that, this requires
                        you to setup and run gulp flow provided in installation steps earlier.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="p-lg-1">
                <h4 class="mb-2 mt-0 font-weight-semibold">In-built Layouts</h4>

                <p>Ubold provides multiple choices when it comes to layouting. There are multiple layout choices available. I.e. Vertical (main navigation on "Left"), Horizontal (main navigation on "Top") and Detached (main navigation
                    on "Left" side but part of main content area). You can easily use any of them by simply changing the few partials and using data attributes on
                    <code>body</code> element.</p>

                <p class="mb-0">Check out the pages
                    <code>layouts-horizontal.html</code>, <code>layouts-detached.html</code> or <code>layouts-two-column</code> files available in folder
                    <code>src/html/default/</code> or <code>dist/default/</code> to see how the respective layout can be activated.</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="p-lg-1">
                <h4 class="mb-2 mt-0 font-weight-semibold">Customizing Color Mode, Left Sidebar, Topbar, Layout Width and Right Sidebar</h4>
                <p>Ubold allows you to have customized left sidebar, overall layout width or right sidebar. You could turn the left sidebar to different size, theme (look) and size. You can customize it by specifying the layout data
                    attribute (<code>data-layout={}</code>) on <code>body</code> element in your html. The config object properties accept the following values:</p>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th width="25%">Options</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code class="text-nowrap">mode</code></td>
                                <td>String</td>
                                <td>'light' | 'dark'</td>
                                <td>Changes overall color scheme to light or dark</td>
                            </tr>
                            <tr>
                                <td><code class="text-nowrap">width</code>
                                </td>
                                <td>String</td>
                                <td>'fluid' | 'boxed'</td>
                                <td>Changes the width of overall layout to fluid or boxed</td>
                            </tr>
                            <tr>
                                <td><code class="text-nowrap">menuPosition</code>
                                </td>
                                <td>String</td>
                                <td>"fixed" | "scrollable"</td>
                                <td>Sets the menu position. Scrollable would makes both the menus scrollable with body element.</td>
                            </tr>
                            <tr>
                                <td><code class="text-nowrap">sidebar</code>
                                </td>
                                <td>Object</td>
                                <td>
                                    {
                                    <br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"color": "light" | "dark" | "brand" | "gradient",<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"size": "default" | "condensed" | "compact",<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"showuser":
                                    true | false
                                    <br /> }
                                </td>
                                <td>
                                    The left sidebar related configuration. It's nested object. <br /> The <code>color</code> can be set to "light", "dark", "brand" or "gradient". <br /> The <code>size</code> would allow to change
                                    the size of sidebar to condensed (coompact) or even more small by setting "compact".<br /> The <code>showuser</code>, if set to <code>true</code>, would display a user in left sidebar</td>
                            </tr>
                            <tr>
                                <td><code class="text-nowrap">topbar</code>
                                </td>
                                <td>Object</td>
                                <td>
                                    {
                                    <br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"color": "light" | "dark"
                                    <br /> }
                                </td>
                                <td>The topbar related configuration. It's nested object. <br /> The <code>color</code> can be set to "light", "dark", "brand" or "gradient".
                                </td>
                            </tr>
                            <tr>
                                <td><code class="text-nowrap">showRightSidebarOnPageLoad</code>
                                </td>
                                <td>Boolean</td>
                                <td>true | false</td>
                                <td>Indicates whether to show right sidebar on opening up the page</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <p>Following are few examples:</p>
                <ul>
                    <li>
                        <h5>Changes the left sidebar theme to "Dark"</h5>
                        <code>&lt;body class="loading"
                            data-layout='{"sidebar": { "color": "dark"}}'&gt;&lt;/body&gt;</code>
                    </li>
                    <li>
                        <h5>Changes the left sidebar theme to "Light (White)"</h5>
                        <code>&lt;body class="loading"
                            data-layout='{"sidebar": {"color": "light"}}'&gt;&lt;/body&gt;</code>
                    </li>
                    <li>
                        <h5>Sets the menus (left sidebar and topbar) scrollable with body</h5>
                        <code>&lt;body class="loading"
                            data-layout='{"menuPosition":
                            true}'&gt;&lt;/body&gt;</code>
                    </li>
                    <li>
                        <h5>Changes the left sidebar size to small</h5>
                        <code>&lt;body class="loading"
                            data-layout='{"sidebar": {"size": "compact"}}'&gt;&lt;/body&gt;</code>
                    </li>
                    <li>
                        <h5>Changes the topbar color to light (white)</h5>
                        <code>&lt;body class="loading"
                            data-layout='{"topbar": {"color": "light"}}'&gt;&lt;/body&gt;</code>
                    </li>
                    <li>
                        <h5>Changes the overall color mode to dark</h5>
                        <code>&lt;body class="loading"
                            data-layout='{"mode": "dark"}'&gt;&lt;/body&gt;</code>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="p-lg-1">
                <h4 class="mb-2 mt-0">Adding new page</h4>
                <p>We have provided a starter page (check
                    <code>src/html/default/pages-starter.html</code>). It allows you to get started easily and helps you to add new page. Please note following important points:</p>
                <p></p>
                <ul>
                    <li>Make sure you have included <code>css/bootstrap.min.css</code>, <code>css/app.min.css,
                            css/icons.min.css</code>, <code>js/vendor.min.js</code> and <code>js/app.min.js</code> in your html. <br /> If you would like to have dark mode, make sure to include the <code>css/app-dark.min.css</code>.
                        <br /> If you are using other demos available in theme, make sure to replace
                        <code>app.min.css</code> with
                        <code>app-&lt;DEMO_NAME&gt;.min.css</code> respectively.</li>

                    <li>Most of default/basic form elements along with few advanced elements are available and bundled in above css and js and so you don't need to include any css or js separately.</li>
                    <li>Few elements e.g. charts, data tables, calendar, maps etc requires you to include corresponding css and js files in your html. Please check corresponding documentation page for the same.</li>
                </ul>
                <p></p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="p-lg-1">
                <h4 class="mb-3 mt-0">RTL Version</h4>
                <h5 class=" font-weight-bold">Light Version:</h5>
                <p>
                    In order to have RTL enabled with light version, replace the reference of <code>bootstrap.min.css</code> stylesheet file to <code>bootstrap-rtl.min.css</code> and <code>app.min.css</code> to <code>app-rtl.min.css</code>
                </p>

                <h5 class=" font-weight-bold mt-3">Dark Version:</h5>
                <p>
                    In order to have RTL enabled with dark version, replace the reference of <code>bootstrap.min.css</code> stylesheet file to <code>bootstrap-dark-rtl.min.css</code> and <code>app.min.css</code> to <code>app-dark-rtl.min.css</code>
                </p>
            </div>
        </div>
    </div>
</div>
<?php include_once "_includes/footer.php"; ?>