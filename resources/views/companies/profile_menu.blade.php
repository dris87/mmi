<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body px-0 py-0" style="padding-top: 0 !important; margin-top: 0 !important">
                <ul class="nav nav-pills  justify-content-center">
                    <li class="nav-item">
                        <a href="{{ route('company.edit',['section' => 'informations', 'company'=> $company->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'informations') ? 'active' : ''}}">
                            {{ __('messages.company_profile.informations') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('company.edit',['section' => 'profile', 'company'=> $company->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'profile') ? 'active' : ''}}">
                            {{ __('messages.company_profile.profile') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('company.edit',['section' => 'jobs', 'company'=> $company->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'jobs') ? 'active' : ''}}">
                            {{ __('messages.company_profile.jobs') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('company.edit',['section' => 'applications', 'company'=> $company->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'applications') ? 'active' : ''}}">
                            {{ __('messages.company_profile.applications') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('company.edit',['section' => 'activity', 'company'=> $company->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'activity') ? 'active' : ''}}">
                            {{ __('messages.company_profile.activity') }}
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('company.edit',['section' => 'finance', 'company'=> $company->id]) }}"--}}
{{--                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'finance') ? 'active' : ''}}">--}}
{{--                            {{ __('messages.company_profile.finance') }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('company.edit',['section' => 'cv_list', 'company'=> $company->id]) }}"--}}
{{--                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'cv_list') ? 'active' : ''}}">--}}
{{--                            {{ __('messages.company_profile.cv_list') }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
                    <li class="nav-item">
                        <a href="{{ route('company.edit',['section' => 'company_users', 'company'=> $company->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'company_users') ? 'active' : ''}}">
                            {{ __('messages.company_profile.company_users') }}
                        </a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('company.edit',['section' => 'support', 'company'=> $company->id]) }}"--}}
{{--                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'support') ? 'active' : ''}}">--}}
{{--                            {{ __('messages.company_profile.support') }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('company.edit',['section' => 'statistics', 'company'=> $company->id]) }}"--}}
{{--                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'statistics') ? 'active' : ''}}">--}}
{{--                            {{ __('messages.company_profile.statistics') }}--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        @yield('section')
    </div>
</div>

