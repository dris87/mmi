<form id="candidateTableForm" method="POST">
    <table class="table table-responsive-sm table-striped table-bordered" id="candidateTbl">
        <thead>
        <tr>
            <th scope="col" class="text-center"><input type="checkbox" name="datatableSelectAll" id="datatableSelectAll"</th>
            <th scope="col">{{ __('messages.common.id') }}</th>
            <th scope="col">{{ __('messages.common.name') }}</th>
            <th scope="col">{{ __('messages.common.contact_details') }}</th>
            <th scope="col">{{ __('messages.candidates_table.last_activity_date') }}</th>
            <th scope="col">{{ __('messages.candidates_table.status') }}</th>
            <th scope="col">{{ __('messages.candidates_table.action') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</form>
