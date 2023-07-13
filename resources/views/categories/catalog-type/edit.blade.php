@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')
        <edit-type
            type-id="{{ $id }}"
        />

    </main><!-- End #main -->
@endsection
