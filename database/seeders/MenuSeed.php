<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MenuSeed extends Seeder
{

    public function run()
    {
        DB::table('menus')->delete();

        DB::table('menus')->insert([
            [
                'id' => 1,
                'title' => 'Главная',
                'path' => 'dashboard.index',
                'parent' => 0,
                'icon' => 'bi bi-grid',
                'sort_order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 2,
                'title' => 'Курсы',
                'path' => 'courses.index',
                'parent' => 0,
                'icon' => 'bi bi-columns-gap',
                'sort_order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'title' => 'Школы',
                'path' => 'schools.index',
                'parent' => 0,
                'icon' => 'bi bi-book-fill',
                'sort_order' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 3,
                'title' => 'Новости/Статьи',
                'path' => 'news.index',
                'parent' => 0,
                'icon' => 'bi bi-journal-text',
                'sort_order' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'title' => 'Тип каталога',
                'path' => 'types.index',
                'parent' => 0,
                'icon' => 'bi bi-bookmarks',
                'sort_order' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 6,
                'title' => 'Категории',
                'path' => 'categories.index',
                'parent' => 0,
                'icon' => 'bi bi-card-checklist',
                'sort_order' => 6,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 7,
                'title' => 'Теги',
                'path' => 'tags.index',
                'parent' => 0,
                'icon' => 'bi bi-tags-fill',
                'sort_order' => 7,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 8,
                'title' => 'Длительность',
                'path' => 'durations.index',
                'parent' => 0,
                'icon' => 'bi bi-hourglass-bottom',
                'sort_order' => 8,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 9,
                'title' => 'Модули',
                'path' => '',
                'parent' => 0,
                'icon' => 'bi bi-gear',
                'sort_order' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 10,
                'title' => 'Главный банер',
                'path' => 'settings.banner',
                'parent' => 9,
                'icon' => 'bi bi-circle',
                'sort_order' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 11,
                'title' => 'Преимущества',
                'path' => 'setting.advantages',
                'parent' => 9,
                'icon' => 'bi bi-circle',
                'sort_order' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 12,
                'title' => 'QUIZ',
                'path' => 'setting.quiz',
                'parent' => 9,
                'icon' => 'bi bi-circle',
                'sort_order' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 13,
                'title' => 'Промокод',
                'path' => 'setting.promo',
                'parent' => 9,
                'icon' => 'bi bi-circle',
                'sort_order' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 14,
                'title' => 'Мы сотрудничаем',
                'path' => 'setting.collaborate',
                'parent' => 9,
                'icon' => 'bi bi-circle',
                'sort_order' => 5,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 15,
                'title' => 'Скидки/Акции',
                'path' => 'sales.index',
                'parent' => 0,
                'icon' => 'bi bi-percent',
                'sort_order' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 16,
                'title' => 'Отзывы',
                'path' => 'reviews.index',
                'parent' => 0,
                'icon' => 'bi bi-card-text',
                'sort_order' => 9,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
