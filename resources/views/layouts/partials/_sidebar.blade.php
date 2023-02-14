{{-- Sidebar --}}
<div id="sidebar" class="sidebar bg-white border-end">
    <div class="sidebar-content">
        <div class="align-items-center d-flex gap-2 py-3 user-info">
            <div class="image">
                <div class="fake-image img-circle elevation-2">{{ strtoupper(auth()->user()->name[0]) }}</div>
            </div>
            <div class="info">
                <span class="user-name">{{ auth()->user()->name }}</span>
            </div>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a
                    class="nav-link {{ request()->is('home') ? 'active' : '' }}"
                    href="{{ route('home') }}"
                    title="Dashboard"
                >
                    <div class="icon-wrap" style="background-color: green;">
                        <i class="fa fa-dashboard" aria-hidden="true"></i>
                    </div>
                    <div class="text-wrap">Dashboard</div>
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link {{ request()->is('authors*') ? 'active' : '' }}"
                    href="{{ route('authors.default') }}"
                    title="Authors"
                >
                    <div class="icon-wrap" style="background-color:#EF414C">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>
                    <div class="text-wrap">Authors</div>
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link {{ request()->is('genres*') ? 'active' : '' }}"
                    href="{{ route('genres.default') }}"
                    title="Genres"
                >
                    <div class="icon-wrap" style="background-color: #F27C0E;">
                        <i class="fa fa-tags" aria-hidden="true"></i>
                    </div>
                    <div class="text-wrap">Genres</div>
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link {{ request()->is('publishers*') ? 'active' : '' }}"
                    href="{{ route('publishers.default') }}"
                    title="Publishers"
                >
                    <div class="icon-wrap" style="background-color: #319DFF;">
                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                    </div>
                    <div class="text-wrap">Publishers</div>
                </a>
            </li>
            <li class="nav-item">
                <a
                    class="nav-link {{ request()->is('books*') ? 'active' : '' }}"
                    href="{{ route('books.default') }}"
                    title="Books"
                >
                    <div class="icon-wrap" style="background-color: #8051FF;">
                        <i class="fa fa-book" aria-hidden="true"></i>
                    </div>
                    <div class="text-wrap">Books</div>
                </a>
            </li>
        </ul>
    </div>
</div>

@push('js')
<script>
    function toggleSidebar(event) {
        event.preventDefault();
        const sidebarElm = document.getElementById("sidebar");
        sidebarElm.classList.toggle("open");
        if (sidebarElm.classList.contains('open')) {
            window.localStorage.setItem('sidebar-open', true);
        } else {
            window.localStorage.setItem('sidebar-open', false);
        }
    }

    (function () {
        window.onload = function () {
            new ClassWatcher(document.getElementById('navbarSupportedContent'), 'show', function() {
                document.querySelector('.sidebar').style.top = '92px';
            }, function() {
                document.querySelector('.sidebar').style.top = '56px';
            });

            const sidebarOpen = window.localStorage.getItem('sidebar-open');
            if (sidebarOpen && JSON.parse(sidebarOpen) == true) {
                document.getElementById('sidebar').classList.add('open');
            }
        }
    })();
</script>
@endpush
