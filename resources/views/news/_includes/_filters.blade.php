<section class="section section-filter">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <form action="{{ route('news.index') }}" method="get" enctype="multipart/form-data" class="card-body">
                    <h5 class="card-title">Фильтры</h5>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Название</label>
                        <div class="col-sm-10">
                            <input type="text" id="inputText" name="title" class="form-control" @if(request()->has('title') && request()->input('title')) value="{{request()->input('title')}}" @endif>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputDateFrom" class="col-sm-2 col-form-label">Дата <b>С</b></label>
                        <div class="col-sm-10">
                            <input type="date" name="date_from" id="inputDateFrom" class="form-control" @if(request()->has('date_from') && request()->input('date_from')) value="{{ request()->input('date_from') }}" @endif>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputDateTo" class="col-sm-2 col-form-label">Дата <b>ПО</b></label>
                        <div class="col-sm-10">
                            <input type="date" id="inputDateTo" name="date_to" class="form-control" @if(request()->has('date_from') && request()->input('date_from')) value="{{ request()->input('date_to') }}" @endif>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Тип</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" name="type_id">
                                <option value="">-- Выберите --</option>
                                @foreach($types as $key => $type)
                                    <option
                                        value="{{ $key }}"
                                        @if(request()->has('type_id') && \Illuminate\Support\Str::lower(request()->input('type_id')) === \Illuminate\Support\Str::lower($key)) selected @endif
                                    >{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <label class="col-sm-2 col-form-label">Кто видит</label>
                        <div class="col-sm-10">
                            @foreach($levels as $key => $level)
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="flexSwitchCheckDefault{{ $key }}"
                                        name="visible_for[]"
                                        value="{{ $key }}"
                                        @if(request()->has('visible_for') && in_array(\Illuminate\Support\Str::lower($key), request()->input('visible_for'))) checked @endif
                                    >
                                    <label class="form-check-label" for="flexSwitchCheckDefault{{ $key }}">{{ $level }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-outline-dark filter-news" data-route="{{ route('news.index') }}">Применить</button>
                    <a class="btn btn-danger" href="{{ url('news') }}">Сбросить фильтр</a>
                </form>
            </div>

        </div>
    </div>
</section>
