<?php


namespace App\Services\Interfaces;


use App\Dto\TagDto;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface TagService
{
    public function getById(int $id): TagDto;

    public function get(): Collection;

    public function save(TagRequest $request): Tag;

    public function destroy(Request $request): void;

    public function getForSelection(): Collection;
}
