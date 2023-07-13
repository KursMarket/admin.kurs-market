@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')
        <duration-save
        @isset($id)
            duration-id="{{ $id }}"
        @endisset
        />

    </main><!-- End #main -->
@endsection
