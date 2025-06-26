<?php
/** @var \App\Models\User $user */
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        * {
            font-family: DejaVu Sans, sans-serif;

        }
        .bg-dark {
            background: #414042;
        }

        .bg-blue {
            background: #1d75bc;
        }

        .bg-white {
            background: #ffffff;
        }

        .bg-gray {
            background: #ededed;
        }

        .color-white {
            color: #ffffff;
        }

        .color-blue {
            color: #1d75bc;
        }

        .w-20 {
            width: 20% !important;
        }

        .w-30 {
            width: 30% !important;
        }

        .w-40 {
            width: 40% !important;
        }

        .w-60 {
            width: 60% !important;
        }

        .w-70 {
            width: 70% !important;
        }

        .w-80 {
            width: 80% !important;
        }

        .w-100 {
            width: 100% !important;
        }

        .subheader {
            font-size: 8px !important;
        }
    </style>

    <style>
        * {
            line-height: 1;
            margin: 0;
        }



        @page {
            margin: 100px 0 100px 0 !important;
        }

        .space {
            height: 15px;
        }

        hr {
            display: block !important;
            height: 1px !important;
            border: 0 !important;
            border-top: 1px solid #f79f38 !important;
            padding: 0 !important;
            margin: 0 0 10px 0 !important;
        }

        .container h3 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 0;
        }

        .container p {
            font-size: 12px;
        }

        .container td {
            vertical-align: top;
            padding-bottom: 8px;
        }

        .right-section {
            padding: 10px 0 25px 20px;
        }

        .left-section {
            text-align: right;
            background: #ededed;
            padding: 10px 20px 20px 0;
        }

        .text-r {
            text-align: right;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        header {
            margin-top: -100px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            color: white;
            z-index: -4;
        }

        .container {
            margin-top: -100px;
        }

        footer {
            margin-bottom: -100px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 15px 50px 30px 50px;
            height: 60px;

            background: #414042;
            color: white;
        }

        footer td, header td {
            vertical-align: top;
        }

        footer h4 {
            font-size: 12px;
            font-weight: normal;
        }

        .dot {
            height: 3px;
            width: 3px;
            margin: 2px;
            background-color: #f79f38;
            border-radius: 50%;
            display: inline-block;
        }

        .triangle-left {
            width: 0;
            height: 0;
            border-top: 4px solid transparent;
            border-right: 6px solid #f79f38;
            border-bottom: 4px solid transparent;
            display: inline-block;
            margin-left: 5px;
        }

        .triangle-right {
            width: 0;
            height: 0;
            border-top: 4px solid transparent;
            border-left: 6px solid #f79f38;
            border-bottom: 4px solid transparent;
            display: inline-block;
            margin-right: 5px;
            margin-top: 3px;
        }

        .nobreak {
            page-break-inside: avoid;
        }
    </style>

</head>
<body style="z-index: 0;">
<script type="text/php">
        if ( isset($pdf) ) {
            $x = 510;
            $y = 778;
            $text = "{PAGE_NUM} / {PAGE_COUNT}";
            $font = $fontMetrics->get_font("helvetica", "bold");
            $size = 7;
            $color = array(255,255,255);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
</script>

<header>
    <table class="w-100">
        <tr class="w-100">
            <td class="w-40 bg-blue text-r" style="padding: 20px 20px;">
                <h3>{{ $user->getFirstName() }}<br>{{ $user->getLastName() }}</h3>
            </td>
            <td class="w-60 bg-dark" style="padding: 20px 20px;">
                <table class="w-100">
                    <tr class="w-100">
                        <td class="w-70" style="padding-top: 16px;">
                            <h4 style="font-size: 7px;">AZ ÖNÉLETRAJZ A MUMI.HU WEBOLDALÁN KERESZTÜL JÖTT LÉTRE.<br>
                                LÉTREHOZÁS DÁTUMA: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</h4>
                        </td>
                        <td class="w-30">
                            <img class="w-100" src="{{ $img_logo }}">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</header>

<footer>
    <table class="w-100">
        <tr class="w-100">
            <td class="w-80">
                <h4><strong>www.mumi.hu</strong><br>MUNKALEHETŐSÉG MINDENKINEK KFT.</h4>
            </td>
            <td class="w-20 text-r">
                <h4><strong>oldal</strong></h4>
            </td>
        </tr>
    </table>
</footer>



<main style="height: 600px !important;">
    <div class="container w-100 bg-gray">
        <div class="w-40" style="float: left;">
            <div class="bg-blue color-white" style="text-align: right; padding: 50px 0 20px 0;">
                <table class="w-100">
                    <tr class="w-100">
                        <td class="w-40"></td>
                        <td class="w-60 text-r">
                            <div class=""
                                 style="text-align: center; background-color: #f79f38; width: 180px; height: 180px; border-radius: 50%;">
                                <img class="" src="{{ $photo ?? "" }}" style="border-radius: 50%; width: 160px; height: 160px; margin-top: 10px">
                            </div>
                        </td>
                    </tr>
                    <tr style="">
                        <td class="w-30"></td>
                        <td class="w-70 text-r" style="padding-right: 20px; white-space: nowrap;">
                            <h4>{{ $user->getFirstName() }}</h4>
                            <h4 style="margin-bottom: 5px;">{{ $user->getLastName() }}</h4>
                            <p>
                                @if($candidate->nationality) {{ $candidate->nationality }} <span class="dot"></span> @endif
                                {{ $user->gender==0?__("messages.common.male"):__('messages.common.female') }} <span class="dot"></span>
                                {{ $user->dob }}</p>
                        </td>
                    </tr>
                </table>

            </div>

            <div class="space bg-white"></div>

            <div class="left-section">
                <h3 class="color-blue" style="line-height: 2;">KAPCSOLAT</h3>
                <hr>
                <p>{{ $user->getPhone() }} <img width="10px" src="{{ $icons['mobile'] }}" /></p>
                <p>{{ $user->getEmail() }} <img width="10px" src="{{ $icons['mail'] }}" /></p>
                <p><?=($objPostCode ? $objPostCode->postal_code : "") . " " . ($objCity ? $objCity->name : "") . " " . $user->candidate->address?>
                    <img width="10px" src="{{ $icons['pin'] }}" /></p>
            </div>

            @if($candidate->expected_salary > 0 && $candidate->expected_salary_to > 0)
            <div class="space bg-white"></div>
            <div class="left-section">
                <h3 class="color-blue" style="line-height: 2;">BÉRIGÉNY</h3>
                <hr>
                <p><strong><?=number_format($candidate->expected_salary, 0, '.', '.') . " Ft"; ?>
                        -tól <?=number_format($candidate->expected_salary_to, 0, '.', '.') . " Ft"; ?>-ig</strong></p>
            </div>
            @endif
            <div class="space bg-white"></div>




        </div>
        <div class="w-60" style="float: left; ">
            <div class="bg-dark color-white">
                <table class="w-100" style="padding: 20px 20px;">
                    <tr class="w-100">
                        <td class="w-70" style="padding-top: 15px; vertical-align: auto !important; ">
                            <h4 style="font-size: 7px;">AZ ÖNÉLETRAJZ A MUMI.HU WEBOLDALÁN KERESZTÜL JÖTT LÉTRE.<br>
                                LÉTREHOZÁS DÁTUMA: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</h4>
                        </td>
                        <td class="w-30" style="vertical-align: center !important;">
                            <img class="w-100" src="{{ $img_logo }}">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="right-section bg-white">
                <h3 class="color-blue" style="line-height: 2;">KERESETT MUNKAKÖRÖK</h3>
                <hr>
                <p style="width: 80%;">{{ $candidate->candidateJobCategories->pluck('name')->implode(', ') }}</p>
            </div>

            <div class="space bg-gray"></div>

            <div class="right-section bg-white">
                <h3 class="color-blue" style=" line-height: 2;">ÁLLÁSKERESÉSI INFORMÁCIÓK</h3>
                <hr>
                <table>
                    <tr>
                        <td style="white-space: nowrap;"><strong><p>Munkaidő:</p></strong></td>
                        <td style="padding-left: 10px;">
                            <p>
                                {{ $candidate->candidateJobShift->pluck('shift')->implode(', ') }}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="white-space: nowrap;"><strong><p>Szerződés típusa:</p></strong></td>
                        <td style="padding-left: 10px;">
                            <p>
                                {{ $candidate->candidateJobType->pluck('name')->implode(', ') }}
                            </p>
                        </td>
                    </tr>
                    @if($candidate->candidateAbleToMoveCity->isNotEmpty())
                        <tr>
                            <td style="white-space: nowrap;"><strong><p>Utazási hajlandóság:</p></strong></td>
                            <td style="padding-left: 10px;">
                                <p>
                                    Ha szükséges, utazom az alábbi településekre:
                                    {{ $candidate->candidateAbleToMoveCity->pluck('name')->implode(', ') }}
                                </p>
                            </td>
                        </tr>
                    @endif
                    @if($candidate->move_anywhere || $candidate->candidateAbleToTravelCity->isNotEmpty())
                        <tr>
                            <td style="white-space: nowrap;"><strong><p>Költözési hajlandóság:</p></strong></td>
                            <td style="padding-left: 10px;">
                                <p>
                                    @if($candidate->move_anywhere)
                                        Ha szükséges, bárhova költöznék
                                    @else
                                        {{ $candidate->candidateAbleToTravelCity->pluck('name')->implode(', ') }}
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endif
                    @if($candidate->candidateCircumstances->isNotEmpty())
                        <tr>
                            <td style="white-space: nowrap;"><strong><p>Jelenlegi státusz:</p></strong></td>
                            <td style="padding-left: 10px;">
                                <p>
                                    {{ $candidate->candidateCircumstances->pluck('name')->implode(', ') }}
                                </p>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>

            <div class="space bg-gray"></div>

            <div class="right-section">
                <h3 class="color-blue" style="line-height: 2;">INFORMÁCIÓK</h3>
                <hr>

                <table>
                    <tr>
                        <td>
                            <div>
                                <div>
                                    @php
                                        $listedData = [];
                                        foreach ($candidateDrivingLicences as $key => $value) {
                                            if (isset($driving_lincences[$value])) {
                                                $listedData[] = $driving_lincences[$value];
                                            }

                                        }
                                    @endphp
                                </div>
                                @if(!empty($listedData))
                                    <p><strong>Jogosítvány</strong></p>
                                    <p style="margin-bottom: 20px;">
                                        {!!  implode(',', $listedData) . ' <span class="dot"></span> kategória <span class="triangle-left"></span>' !!}
                                    </p>
                                @endif
                                @php
                                    $listedData = [];
                                    foreach ($candidateLanguage as $key => $value) {
                                        if (isset($language[$value["language_id"]]) && isset($language_level[$value["language_level_id"]])) {
                                            $listedData[] = $language[$value["language_id"]] . " <span class=\"dot\"></span> " . $language_level[$value["language_level_id"]] . '<span class="triangle-left"></span>';
                                        }
                                    }
                                @endphp
                                @if(!empty($listedData))
                                    <p><strong>Nyelvismeret</strong></p>
                                    <p style="margin-bottom: 20px;">
                                        {!! implode("<br>", $listedData) !!}
                                    </p>
                                @endif
                                @php
                                    $listedData = [];
                                    foreach ($candidateBasicSkills as $key => $value) {
                                        if (isset($skill_level[$value["skill_level_id"]])) {
                                            $listedData[] = $value["skill"] . " <span class=\"dot\"></span> " . $skill_level[$value["skill_level_id"]] . " <span class=\"triangle-left\"></span>";
                                        }
                                    }
                                @endphp
                                @if (!empty($listedData))
                                    <p><strong>Számítógépes ismeretek</strong></p>
                                    <p style="margin-bottom: 20px;">
                                        {!! implode("<br>", $listedData) !!}
                                    </p>
                                @endif
                                @php
                                    $listedData = [];
                                    foreach ($candidateAdvancedSkills as $key => $value) {
                                        if (isset($skill_level[$value["skill_level_id"]])) {
                                            $listedData[] = $value["skill"] . " <span class=\"dot\"></span> " . $skill_level[$value["skill_level_id"]] . " <span class=\"triangle-left\"></span>";
                                        }

                                    }
                                @endphp

                            </div>
                        </td>
                        <td style="padding-left: 40px">
                            <div>
                                @if (!empty($listedData))
                                    <p><strong>Számítógépes ismeretek</strong></p>
                                    <p style="margin-bottom: 20px;">
                                        {!! implode("<br>", $listedData) !!}
                                    </p>
                                @endif
                                @php
                                    $listedData = [];
                                    foreach ($candidateAdvancedSkills as $key => $value) {
                                        if (isset($skill_level[$value["skill_level_id"]])) {
                                            $listedData[] = $value["skill"] . " <span class=\"dot\"></span> " . $skill_level[$value["skill_level_id"]] . " <span class=\"triangle-left\"></span>";
                                        }

                                    }
                                @endphp
                                @if(!empty($listedData))
                                    <p><strong>IT szakismeretek</strong></p>
                                    <p style="margin-bottom: 20px;">
                                        {!! implode("<br>", $listedData)  !!}
                                    </p>
                                @endif
                                @php
                                    $listedData = [];
                                    foreach ($candidateSoftwareSkills as $key => $value) {
                                        if (isset($skill_level[$value["skill_level_id"]])) {
                                            $listedData[] = $value["skill"] . " <span class=\"dot\"></span> " . $skill_level[$value["skill_level_id"]] . " <span class=\"triangle-left\"></span>";
                                        }

                                    }
                                @endphp
                                @if(!empty($listedData))
                                    <p><strong>Software ismeret</strong></p>
                                    <p style="margin-bottom: 20px;">
                                        {!! implode("<br>", $listedData) !!}
                                    </p>
                                @endif

                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            @if($candidateExperiences->isNotEmpty())
            <div class="space bg-gray"></div>

            <div class="right-section bg-white">
                <h3 class="color-blue" style="line-height: 2;">SZAKMAI TAPASZTALATOK</h3>
                <hr>
                @foreach($candidateExperiences as $candidateExperience)
                    <p><strong>{{ $candidateExperience->experience_title }}</strong></p>
                    <p class="subheader">{{ \Carbon\Carbon::parse($candidateExperience->start_date)->format('Y-m-d')}} -
                        @if($candidateExperience->currently_working)
                            {{ __('messages.candidate_profile.present') }}
                        @else
                            {{\Carbon\Carbon::parse($candidateExperience->end_date)->format('Y-m-d')}}
                        @endif
                        <span class="dot"></span> {{ $candidateExperience->company }} <span
                            class="dot"></span> {{ $candidateExperience->getCityName() }}
                    </p>
                    @if(!empty($candidateExperience->description))
                    <div style="margin: 15px 0 15px 0;">
                        <div style="float: left;"><span class="triangle-right"></span></div>
                        <div style="margin-left: 10px;"><p style="padding-right: 30px;">{{ $candidateExperience->description }}</p></div>
                    </div>
                    @endif
                @endforeach
            </div>
            @endif

            @if($candidateEducations->isNotEmpty())
            <div class="space bg-gray"></div>
            <div class="right-section bg-white">
                <h3 class="color-blue" style=" line-height: 2;">TANULMÁNYOK</h3>
                <hr>
                @foreach($candidateEducations as $candidateEducation)
                    <p style="margin-top: 10px;"><strong>{{ $candidateEducation->institute }}</strong></p>
                    <p class="subheader">
                        {{ $candidateEducation->year }}
                        - {{ empty($candidateEducation->year_to) ? "Folyamatban" : $candidateEducation->year_to }}
                        <span class="dot"></span>
                        {{ $candidateEducation->degree_title }}
                        <span class="dot"></span>
                        {{ $candidateEducation->getCityName() }}
                    </p>
                    @if($candidateEducation->description)
                        <div style="margin: 15px 0 15px 0;">
                            <div style="float: left;"><span class="triangle-right"></span></div>
                            <div style="margin-left: 10px;"><p>{{ $candidateEducation->description }}</p></div>
                        </div>
                    @endif
                @endforeach
            </div>
            @endif


            <?php $objCandidateExtraQualifications = $objCandidateExtraQualifications
                ? $objCandidateExtraQualifications->getHobbies() : null; ?>

            @if(!empty($candidateSkills) ||
                !empty($objCandidateExtraQualifications) ||
                !empty($candidateExtraRequirements)
                )
                <div class="space bg-gray"></div>

            <div class="right-section bg-white nobreak">
                <h3 class="color-blue" style="line-height: 2;">EGYÉB</h3>
                <hr>
                <table>
                    @php
                        $listedData = [];
                        foreach ($candidateSkills as $key => $value){
                            if( isset($skills[$value])){
                                $listedData[]= $skills[$value];
                            }

                        }
                    @endphp
                    @if(!empty($listedData))
                        <tr>
                            <td style="white-space: nowrap;"><strong><p>Kompetenciák:</p></strong></td>
                            <td style="padding-left: 10px; width: 90%;">
                                <p>

                                    {{ implode(",",$listedData) }}
                                </p>
                            </td>
                        </tr>
                    @endif
                    @if($objCandidateExtraQualifications)
                        <tr>
                            <td style="white-space: nowrap;"><strong><p>Szabadidő, hobbi:</p></strong></td>
                            <td style="padding-left: 10px; padding-right: 30px;">
                                <p>
                                    {{ $objCandidateExtraQualifications }}
                                </p>
                            </td>
                        </tr>
                    @endif
                    @php
                        $listedData = [];
                        foreach ($candidateExtraRequirements as $key => $value){
                            if( isset($extra_requirements[$value])){
                                $listedData[]= $extra_requirements[$value];
                            }

                        }
                    @endphp
                    @if(!empty($listedData))
                        <tr>
                            <td style="white-space: nowrap;"><strong><p>Támogatás:</p></strong></td>
                            <td style="padding-left: 10px;">
                                <p>
                                    {{ implode(",",$listedData) }}
                                </p>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>

            @endif

        </div>
    </div>
</main>



</body>
</html>
