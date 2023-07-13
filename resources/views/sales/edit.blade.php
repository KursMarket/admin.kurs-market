@extends('layouts.main')
@section('content')
<main id="main" class="main">

    @include('_includes._title_breadcrumbs')
    @include('_includes._errors')

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $title }}</h5>
                        <div class="tab-pane fade active show" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('sales.update', $sale->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <sale-type
                                    sale-type="{{ $sale->type === \App\Models\Sale::SALE_TYPE ? 'school' : 'course' }}"
                                    school-id="{{ $sale->school_id }}"
                                    course-id="{{ $sale->course_id }}"
                                ></sale-type>
                                <div class="row mb-3">
                                    <label for="discount_type" class="col-sm-2 col-form-label">Тип скидки</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" aria-label="Тип" name="discount_type" id="discount_type">
                                            <option value="{{ \App\Models\Sale::PERCENT_DISCOUNT }}" @if($sale->discount_type === \App\Models\Sale::PERCENT_DISCOUNT){{ 'selected' }}@endif>Процент</option>
                                            <option value="{{ \App\Models\Sale::FIX_DISCOUNT }}" @if($sale->discount_type === \App\Models\Sale::FIX_DISCOUNT){{ 'selected' }}@endif>Фиксированная сумма</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="discount" class="col-sm-2 col-form-label">Скидка</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="discount" name="discount" value="{{ $sale->discount }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="date_from" class="col-sm-2 col-form-label">Дата с</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ \Illuminate\Support\Carbon::parse($sale->date_from)->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="date_to" class="col-sm-2 col-form-label">Дата по</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ \Illuminate\Support\Carbon::parse($sale->date_to)->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->
@endsection
