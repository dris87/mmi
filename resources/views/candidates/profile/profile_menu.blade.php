
<div class="row mt-3">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body px-0 py-0" style="padding-top: 0 !important; margin-top: 0 !important">
                <ul class="nav nav-pills  justify-content-center">
                    <li class="nav-item">
                        <a href="{{ route('candidates.edit',['section' => 'profile','candidate'=> $candidate->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'profile') ? 'active' : ''}}">
                            {{ __('messages.information') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('candidates.edit',['section' => 'resumes','candidate'=> $candidate->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'resumes') ? 'active' : ''}}">
                            {{ __('messages.apply_job.resumes') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('candidates.edit',['section' => 'activity_log','candidate'=> $candidate->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'activity_log') ? 'active' : ''}}">
                            {{ __('messages.activity_log') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('candidates.edit',['section' => 'applications','candidate'=> $candidate->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'applications') ? 'active' : ''}}">
                            {{ __('messages.applications') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('candidates.edit',['section' => 'general','candidate'=> $candidate->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'general') ? 'active' : ''}}">
                            {{ __('messages.common.editing') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('candidates.edit',['section' => 'career_informations','candidate'=> $candidate->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'career_informations') ? 'active' : ''}}">
                            {{ __('messages.career_informations') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('candidates.edit',['section' => 'documents','candidate'=> $candidate->id]) }}"
                           class="nav-link {{ (isset($data['sectionName']) && $data['sectionName'] == 'documents') ? 'active' : ''}}">
                            {{ __('messages.documents') }}
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

