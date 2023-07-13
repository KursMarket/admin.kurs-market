@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')
        <catalog-types-list
            add-url="{{ route('types.create') }}"
        ></catalog-types-list>

    </main><!-- End #main -->
@endsection
