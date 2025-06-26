<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body px-0 py-0" style="padding-top: 0 !important; margin-top: 0 !important">
                <ul class="nav nav-pills  justify-content-center">
                    <li class="nav-item">
                        <a href="{{ route('candidate.profile',['section' => 'general']) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'general') ? 'active' : ''}}">
                            {{ __('messages.common.editing') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('candidate.profile',['section' => 'career_informations']) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'career_informations') ? 'active' : ''}}">
                            {{ __('messages.career_informations') }}
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        @yield('section')
    </div>
</div>

