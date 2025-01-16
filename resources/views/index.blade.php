@extends('layouts.app')

@section('title', 'Home Owners')

@section('content')
    <h1 class="text-center mb-3">Upload CSV File</h1>

    <x-form />
    <x-persons :persons="$persons" />
@endsection
