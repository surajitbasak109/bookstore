@include('layouts.partials._header')

@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-typeahead/2.11.2/jquery.typeahead.min.css" />
@endpush

<body>
    <div id="app">
        @include('layouts.partials.guest._navbar')
        <div class="content-wrapper">
            <main class="guest-content">
                @yield('content')
            </main>

            @if (isset($showFooter))
            @include('layouts.partials.guest._footer')
            @endif
        </div>
    </div>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    {{-- Typeahead --}}
    <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.min.js"></script>

    <script>
        window.BASE_URL = "{{ url('') }}";
    </script>

    @stack('js')
</body>

</html>
