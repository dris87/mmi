
<?php $hasDropDown =  isset($sidebarElementData['sub_menu_items']); ?>
@if($UserPermissionService->userHasPermission('sidebar', $sidebarElementData['permission_name']))
<li class="side-menus @if($hasDropDown) nav-item dropdown @else {{ Request::is($sidebarElementData['active_pattern']) ? 'active' : '' }} @endif">
    <a
        class="nav-link @if($hasDropDown) has-dropdown @endif"
        href="{{ isset($sidebarElementData['route']) ? route($sidebarElementData['route']) : '#' }}"
    >
        <i class="{{ $sidebarElementData['icon'] }}"></i>
        <span>{{ __($sidebarElementData['title']) }}</span>
    </a>

    @if($hasDropDown)
    <ul class="dropdown-menu side-menus">
        @foreach($sidebarElementData['sub_menu_items'] as $subMenuItem)
            @if($UserPermissionService->userHasPermission('sidebar', $subMenuItem['permission_name']))
            <li class="side-menus {{ Request::is($subMenuItem['active_pattern']) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route($subMenuItem['route']) }}">
                    <i class="{{ $subMenuItem['icon'] }}"></i>
                    <span>{{ __($subMenuItem['title']) }}</span>
                </a>
            </li>
            @endif
        @endforeach
    </ul>
    @endif
</li>
@endif
