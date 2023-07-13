@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')

        @include('news._includes._filters')

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('news.create') }}" class="btn btn-outline-success mb-3">Добавить новость</a>
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Тип</th>
                                    <th scope="col">Название</th>
                                    <th scope="col">Дата добавления</th>
                                    <th scope="col">Кто видит</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($news->isNotEmpty())
                                    @foreach($news as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ generateHumanNewsType($item) }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ generateHumanDate($item->created_at) }}</td>
                                            <td>{{ getHumanVisibleAttribute($item) }}</td>
                                            <td>
                                            @include('_includes._actions', ['routeEdit' => route('news.edit', $item->id), 'action' => route('news.destroy', $item->id)])
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">Новости отсутствуют</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        {!! $news->withQueryString()->links('_includes._pagination') !!}
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
