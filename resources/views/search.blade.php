@extends('layouts.guest')
@section('title', 'Search')

@section('content')
    <search
        query-prop="{{ $query }}"
        search-url="{{ route('guest.search-ajax') }}"
        filter-data-url="{{ route('guest.filter-data') }}"
    ></search>
@endsection
