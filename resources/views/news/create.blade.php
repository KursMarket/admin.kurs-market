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
                                <form action="{{ route('news.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Название</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="inputText" name="title" value="{{ old('title') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="type_id" class="col-sm-2 col-form-label">Тип</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Тип" name="type_id" id="type_id">
                                                <option value="">-- Выбрать --</option>
                                                @foreach($types as $k => $type)
                                                    <option value="{{ $k }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="text" class="col-sm-2 col-form-label">Описание</label>
                                        <div class="col-sm-10">
                                        <textarea class="tinymce-editor" name="text">
                                            {!! old('text') !!}
                                        </textarea><!-- End TinyMCE Editor -->
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="url" class="col-sm-2 col-form-label">Url</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="link" class="col-sm-2 col-form-label">Ссылка</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="link" name="link" value="{{ old('link') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="image" class="col-sm-2 col-form-label">Изображение</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="file" id="image" name="image">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="video" class="col-sm-2 col-form-label">Видео</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="file" id="video" name="video">
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <label class="col-sm-2 col-form-label">Кому показывать</label>
                                        <div class="col-sm-10">
                                            @foreach($levels as $key => $level)
                                                <div class="form-check form-switch">
                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="visible_for[]"
                                                        id="flexSwitchCheckDefault{{ $key }}"
                                                        value="{{ $key }}"
                                                    >
                                                    <label class="form-check-label" for="flexSwitchCheckDefault{{ $key }}">{{ $level }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="meta_h1" class="col-sm-2 col-form-label">Meta H1</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="meta_h1" name="meta_h1" value="{{ old('meta_h1') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="meta_title" class="col-sm-2 col-form-label">Meta Title</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="meta_description" class="col-sm-2 col-form-label">Meta Description</label>
                                        <div class="col-sm-10">
                                            <textarea type="text" class="form-control" id="meta_description" rows="10" name="meta_description">{{ old('meta_description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="meta_keywords" class="col-sm-2 col-form-label">Meta Keywords</label>
                                        <div class="col-sm-10">
                                            <textarea type="text" class="form-control" id="meta_keywords" rows="10" name="meta_keywords">{{ old('meta_keywords') }}</textarea>
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
