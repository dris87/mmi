<aside id="sidebar-wrapper">
    <div class="sidebar-brand admin-sidebar-brand">
        <a href="{{ url('/') }}">
            <img src="{{ getLogoUrl() }}" class="navbar-brand-full"/>
        </a>
        <div class="input-group px-3" style="display: none">
            <input type="text" class="form-control searchTerm" id="searchText" placeholder="Search Menu"
                   autocomplete="off">
            <div class="input-group-append">
                <div class="input-group-text">
                    <i class="fas fa-search search-sign"></i>
                    <i class="fas fa-times close-sign"></i>
                </div>
            </div>
            <div class="no-results mt-3 ml-1">No matching records found</div>
        </div>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ url('/') }}" class="small-sidebar-text">
            <img class="navbar-brand-full" src="{{ getLogoUrl() }}" alt="{{config('app.name')}}"/>
        </a>
    </div>
    <ul class="sidebar-menu mt-3">
        <?php
            $sidebarHtml = \Illuminate\Support\Facades\Cache::remember('asd', 1, function () {
                $html = '';
                $sidebarElementDatas = \Illuminate\Support\Facades\Config::get('sidebar');
                foreach ($sidebarElementDatas as $sidebarElementData) {
                    $html .= view('dynamic_elements.sidebar_element', compact('sidebarElementData'))->render();
                }
                return $html;
            });
            echo $sidebarHtml;
        ?>
    </ul>
</aside>
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebar_menu_search/sidebar_menu_search.js') }}"></script>
