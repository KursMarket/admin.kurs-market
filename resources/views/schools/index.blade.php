@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')
        <school-list
            add-url="{{ route('schools.create') }}"
        ></school-list>

    </main><!-- End #main -->
@endsection
