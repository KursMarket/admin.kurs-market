@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')
        <review-edit
            :back-url="'{{ route('reviews.index') }}'"
            @isset($id)
                review-id="{{ $id }}"
            @endisset
        ></review-edit>
    </main><!-- End #main -->
@endsection
