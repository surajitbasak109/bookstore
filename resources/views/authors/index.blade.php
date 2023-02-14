@extends('layouts.app')
@section('title', 'Authors')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <table-list
            label="author"
            data-source-url="{{ route('authors.datatables') }}"
            delete-url="{{ route('authors.delete', ':id') }}"
            store-url="{{ route('authors.store') }}"
            show-url="{{ route('authors.show', ':id') }}"
            update-url="{{ route('authors.update', ':id') }}"
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

                CustomEvent.fire('edit-author-event', { id });
            });
            $(document).on('click', '.delete-btn', function () {
                const { id } = $(this).data();

                CustomEvent.fire('delete-author-event', { id });
            });
        })
    })();
</script>
@endpush
