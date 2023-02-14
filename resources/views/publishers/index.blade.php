@extends('layouts.app')
@section('title', 'Publishers')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <table-list
            label="publisher"
            data-source-url="{{ route('publishers.datatables') }}"
            delete-url="{{ route('publishers.delete', ':id') }}"
            store-url="{{ route('publishers.store') }}"
            show-url="{{ route('publishers.show', ':id') }}"
            update-url="{{ route('publishers.update', ':id') }}"
        ></table-list>
    </div>
</div>
@endsection

@push('js')
<script>
    (function () {
        $(document).ready(function () {
            $(document).on('click', '.edit-btn', function () {
                const { id } = $(this).data();

                CustomEvent.fire('edit-publisher-event', { id });
            });
            $(document).on('click', '.delete-btn', function () {
                const { id } = $(this).data();

                CustomEvent.fire('delete-publisher-event', { id });
            });
        })
    })();
</script>
@endpush
