@extends('layouts.guest')
@section('title', 'Search')

@section('content')
    <search
        query-prop="{{ $query }}"
        search-url="{{ route('guest.search-ajax') }}"
        :authors="{{ json_encode($authors) }}"
        :genres="{{ json_encode($genres) }}"
        :publishers="{{ json_encode($publishers) }}"
        :isbns="{{ json_encode($isbns) }}"
    ></search>
@endsection
