@extends('layouts.app')
@section('title')
    {{ __('messages.transactions') }}
@endsection
@push('css')
    <link href="{{ asset('assets/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('messages.transactions') }}</h1>
        </div>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    @include('transactions.table')
                </div>
            </div>
        </div>
        @include('transactions.templates.templates')
    </section>
@endsection
@push('scripts')
    <script>
        let transactionUrl = "{{ route('transactions.index') }}";
        let invoiceUrl = "{{ url('admin/invoices') }}/";
    </script>
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/custom-datatable.js') }}"></script>
    <script src="{{ asset('js/currency.js') }}"></script>
    <script src="{{asset('assets/js/transactions/transactions.js')}}"></script>
@endpush
