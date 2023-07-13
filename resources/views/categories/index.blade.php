@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')

        <category-list
            add-url="{{ route('categories.create') }}"
        ></category-list>
    </main><!-- End #main -->
@endsection
