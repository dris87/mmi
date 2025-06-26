<form id="companyTableForm" method="POST">
    <table class="table table-responsive-sm table-striped table-bordered" id="jobsTbl">
        <thead>
        <tr>
            <th scope="col" class="text-center"><input type="checkbox" name="datatableSelectAll" id="datatableSelectAll"></th>
            <th style="width:15%;" scope="col">Cég neve<?php //echo __('messages.application.application_name')?></th>
            <th style="width:15%;" scope="col">Hirdetés címe </th>
            <th style="width:15%;" scope="col">Település</th>
            <th style="width:10%;" scope="col">Érvényesség (tól-ig)</th>
            <th style="width:10%;" scope="col">Jelentkezők</th>
            <th style="width:10%;" scope="col">Státusz</th>
            <th style="width:10%;" scope="col">Létrehozva</th>
            <th style="width:15%;" scope="col">{{ __('messages.application.options') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</form>
