<form id="companyTableForm" method="POST">
    <table class="table table-responsive-sm table-striped table-bordered" id="companyTbl">
        <thead>
        <tr>
            <th scope="col" class="text-center"><input type="checkbox" name="datatableSelectAll" id="datatableSelectAll"></th>
            <th scope="col">{{ __('messages.common.id') }}</th>
            <th scope="col">{{ __('messages.company_table.name') }}</th>
            <th scope="col">{{ __('messages.company_table.name_representative') }}</th>
            <th scope="col">{{ __('messages.company_table.contact_representative') }}</th>
            <th scope="col">{{ __('messages.company_table.name_support') }}</th>
            <th scope="col">{{ __('messages.company_table.last_activity_date') }}</th>
            <th scope="col">{{ __('messages.company_table.status') }}</th>
            <th scope="col">{{ __('messages.company_table.action') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</form>
