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
                            <h5 class="card-title">{{ $item->title }}</h5>
                            <ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">Общее</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false" tabindex="-1">Медиа</button>
                                </li>
                            </ul>
                            <div class="tab-content pt-2" id="borderedTabContent">
                                <div class="tab-pane fade active show" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
                                    <form action="{{ route('news.update', $item->id) }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="inputEmail3" class="col-sm-2 col-form-label">Название</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputText" name="title" value="{{ $item->title }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="type_id" class="col-sm-2 col-form-label">Тип</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" aria-label="Тип" name="type_id" id="type_id">
                                                    @foreach($types as $k => $type)
                                                        <option value="{{ $k }}" @if($k === $item->type_id){{ 'selected' }}@endif>{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="text" class="col-sm-2 col-form-label">Описание</label>
                                            <div class="col-sm-10">
                                        <textarea class="tinymce-editor" name="text">
                                            {!! $item->text !!}
                                        </textarea><!-- End TinyMCE Editor -->
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="url" class="col-sm-2 col-form-label">Url</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="url" name="url" value="{{ $item->url }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="link" class="col-sm-2 col-form-label">Ссылка</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="link" name="link" value="{{ $item->link }}">
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
                                                            @if(checkVisibleForAttribute($item, $key)){{ 'checked' }}@endif
                                                        >
                                                        <label class="form-check-label" for="flexSwitchCheckDefault{{ $key }}">{{ $level }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="meta_h1" class="col-sm-2 col-form-label">Meta H1</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="meta_h1" name="meta_h1" value="{{ $item->meta_h1 }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="meta_title" class="col-sm-2 col-form-label">Meta Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $item->meta_title }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="meta_description" class="col-sm-2 col-form-label">Meta Description</label>
                                            <div class="col-sm-10">
                                                <textarea type="text" class="form-control" id="meta_description" rows="10" name="meta_description">{{ $item->meta_description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="meta_keywords" class="col-sm-2 col-form-label">Meta Keywords</label>
                                            <div class="col-sm-10">
                                                <textarea type="text" class="form-control" id="meta_keywords" rows="10" name="meta_keywords">{{ $item->meta_keywords }}</textarea>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary">Обновить</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">

                                    <div class="image media-block">
                                        @if($item->hasMedia(\App\Models\News::MEDIA_KEY))
                                            <h5>Изображение:</h5>
                                            <img src="{{ $item->getFirstMedia(\App\Models\News::MEDIA_KEY)->getUrl() }}" alt="{{ $item->title }}" title="{{ $item->title }}" width="200" height="200" style="object-fit: cover">
                                            <button
                                                class="btn btn-danger rm-action rm-image"
                                                data-collection="{{ \App\Models\News::MEDIA_KEY }}"
                                                data-model="{{ \App\Models\News::class }}"
                                                data-id="{{ $item->id }}"
                                                style="display: block"
                                            >Удалить изображение</button>
                                        @endif
                                    </div>

                                    <div class="video media-block">
                                        @if($item->hasMedia(\App\Models\News::MEDIA_KEY_VIDEO))
                                            <h5>Видео:</h5>
                                            <video width="400" controls>
                                                <source src="{{ $item->getFirstMedia(\App\Models\News::MEDIA_KEY_VIDEO)->getUrl() }}" type="video/mp4">
                                                Sorry, your browser doesn't support embedded videos,
                                                but don't worry, you can <a href="{{ $item->getFirstMedia(\App\Models\News::MEDIA_KEY_VIDEO)->getUrl() }}">download it</a>
                                                and watch it with your favorite video player!
                                            </video>
                                            <button
                                                class="btn btn-danger rm-action rm-video"
                                                data-collection="{{ \App\Models\News::MEDIA_KEY_VIDEO }}"
                                                data-model="{{ \App\Models\News::class }}"
                                                data-id="{{ $item->id }}"
                                                style="display: block"
                                            >Удалить изображение</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
