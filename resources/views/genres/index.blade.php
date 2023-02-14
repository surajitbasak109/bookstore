@extends('layouts.app')
@section('title', 'Genres')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <table-list
            label="genre"
            data-source-url="{{ route('genres.datatables') }}"
            delete-url="{{ route('genres.delete', ':id') }}"
            store-url="{{ route('genres.store') }}"
            show-url="{{ route('genres.show', ':id') }}"
            update-url="{{ route('genres.update', ':id') }}"
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

                CustomEvent.fire('edit-genre-event', { id });
            });
            $(document).on('click', '.delete-btn', function () {
                const { id } = $(this).data();

                CustomEvent.fire('delete-genre-event', { id });
            });
        })
    })();
</script>
@endpush
