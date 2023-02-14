@extends('layouts.app')
@section('title', 'Edit book')

@section('content-header-right-section')
<a href="{{ route('books.default') }}" class="btn btn-outline-primary">
    <i class="fa fa-angle-double-left" aria-hidden="true"></i> Back
</a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <book-form
            :book-prop="{{ json_encode($book) }}"
            :authors="{{ json_encode($authors) }}"
            :genres="{{ json_encode($genres) }}"
            :publishers="{{ json_encode($publishers) }}"
            update-url="{{ route('books.update', ':id') }}"
        ></book-form>
    </div>
</div>
@endsection
