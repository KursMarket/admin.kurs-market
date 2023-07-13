@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')
        <tag-save
        @isset($id)
            tag-id="{{ $id }}"
        @endisset
        />

    </main><!-- End #main -->
@endsection
