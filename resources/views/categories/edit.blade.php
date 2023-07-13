@extends('layouts.main')
@section('content')

    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')

        <category-edit
            list-route="{{ route('categories.index') }}"
            @isset($parentCategoryId)
                parent-category-id="{{ $parentCategoryId }}"
            @endisset
            @isset($id)
                category-id="{{ $id }}"
            @endisset
        >
        </category-edit>

    </main><!-- End #main -->
@endsection
