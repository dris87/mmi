<form id="backofficeUserTableForm" method="POST">
    <table class="table table-responsive-sm table-striped table-bordered" id="backofficeUserTable">
        <thead>
        <tr>
            <th scope="col" class="text-center"><input type="checkbox" name="datatableSelectAll" id="datatableSelectAll"></th>
            <th scope="col">{{ __('messages.common.id') }}</th>
            <th scope="col">{{ __('messages.backoffice.user.name') }} <br> {{ __('messages.backoffice.user.branch_office') }}</th>
            <th scope="col">{{ __('messages.backoffice.user.position') }}</th>
            <th scope="col">{{ __('messages.backoffice.user.contact') }}</th>
            <th scope="col">{{ __('messages.backoffice.user.permission') }}</th>
            <th scope="col">{{ __('messages.backoffice.user.superior') }}</th>
            <th scope="col">{{ __('messages.backoffice.user.status') }}</th>
            <th scope="col">{{ __('messages.backoffice.user.options') }}</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</form>
