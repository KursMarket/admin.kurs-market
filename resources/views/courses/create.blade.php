@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')
        <courses-edit
            :back-url="'{{ route('courses.index') }}'"
            @isset($id)
                course-id="{{ $id }}"
            @endisset
        ></courses-edit>
    </main><!-- End #main -->
@endsection
