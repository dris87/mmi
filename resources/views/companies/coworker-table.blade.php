<form id="companyCoworkersTableForm" method="POST">
    <table class="table table-responsive-sm table-striped table-bordered" id="companyCoworkersTbl">
        <thead>
        <tr>
            <th scope="col" class="text-center"><input type="checkbox" name="datatableSelectAll" id="datatableSelectAll"></th>
            <th scope="col">{{ __('messages.coworker.id') }}</th>
            <th scope="col">{{ __('messages.coworker.name') }}</th>
            <th scope="col">{{ __('messages.coworker.position') }}</th>
            <th scope="col">{{ __('messages.coworker.contact_details') }}</th>
            <th scope="col">{{ __('messages.coworker.role') }}</th>
            <th scope="col">{{ __('messages.coworker.site') }}</th>
            <th scope="col">{{ __('messages.coworker.status') }}</th>
            <th scope="col">{{ __('messages.common.action') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</form>
