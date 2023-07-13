@extends('layouts.main')
@section('content')
    <main id="main" class="main">
        @include('_includes._success')

        @include('_includes._title_breadcrumbs')

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{ route('sales.create') }}" class="btn btn-outline-success mb-3">Добавить скидку</a>
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Тип</th>
                                    <th scope="col">Период</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($sales->isNotEmpty())
                                    @foreach($sales as $item)
                                        <tr>
                                            <th scope="row">{{ $item->id }}</th>
                                            <td>{{ $item->type === \App\Models\Sale::SALE_TYPE ? 'Скидка на школу: ' . ($item->school->short_title ? $item->school->short_title : $item->school->name) : '' }}</td>
                                            <td>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            @if($item->date_from)
                                                                <td>{{ \Illuminate\Support\Carbon::parse($item->date_from)->format('d.m.Y H:i:s') }}</td>
                                                            @else
                                                                <td>-- не указано --</td>
                                                            @endif
                                                                <td> | </td>
                                                            @if($item->date_to)
                                                                <td>{{ \Illuminate\Support\Carbon::parse($item->date_to)->format('d.m.Y H:i:s') }}</td>
                                                            @else
                                                                <td>-- не указано --</td>
                                                            @endif
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                            <td>
                                                @include('_includes._actions', ['routeEdit' => route('sales.edit', $item->id), 'action' => route('sales.destroy', $item->id)])
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">Скидки отсутствуют</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        {!! $sales->withQueryString()->links('_includes._pagination') !!}
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
