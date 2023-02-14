@include('layouts.partials._header')

<body>
    <div id="app">
        @include('layouts.partials._navbar')
        <div class="content-wrapper">
            @auth
            @include('layouts.partials._sidebar')
            @endauth

            <main class="main-content py-3">
                <div class="container-fluid">
                    <div class="content-header">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <h2>@yield('title')</h2>
                            </div>
                            <div class="col-md-6 col-12 text-end">
                                @yield('content-header-right-section')
                            </div>
                        </div>
                        <hr style="margin-top: 0.49rem">
                    </div>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @include('layouts.partials._page-scripts')
</body>

</html>
