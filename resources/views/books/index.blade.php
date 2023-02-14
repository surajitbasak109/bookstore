@extends('layouts.app')
@section('title', 'Books')

@section('content-header-right-section')
    <a href="{{ route('books.create') }}" class="btn btn-outline-primary">
        <i class="fa fa-plus"></i> New book
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <books-table-list
            data-source-url="{{ route('books.datatables') }}"
            delete-url="{{ route('books.delete', ':id') }}"
        ></books-table-list>
    </div>
</div>
@endsection

@push('js')
<script>
    const editUrl = "{{ route('books.edit', ':id') }}";
    (function () {
        $(document).ready(function () {
            $(document).on('click', '.edit-btn', function () {
                const { id } = $(this).data();

                const url = editUrl.replace(':id', id);
                window.location.href = url;
            });
            $(document).on('click', '.delete-btn', function () {
                const { id } = $(this).data();

                CustomEvent.fire('delete-book-event', { id });
            });
        })
    })();
</script>
@endpush
