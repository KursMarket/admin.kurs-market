@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')
        <edit-school
            list-url="{{ route('schools.index') }}"
        @isset($school_id)
            school-id="{{ $school_id }}"
        @endisset
        ></edit-school>

    </main><!-- End #main -->
@endsection
