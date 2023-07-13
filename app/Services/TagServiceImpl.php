<?php

namespace App\Services;

use App\Dto\TagDto;
use App\Dto\TagRequestSelectDto;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use App\Services\Interfaces\TagService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TagServiceImpl implements TagService
{
    /**
     * @override
     * @param int $id
     * @return TagDto
     */
    public function getById(int $id): TagDto
    {
        return TagDto::toDto(Tag::find($id));
    }

    /**
     * @override
     * @return Collection<TagDto>
     */
    public function get(): Collection
    {
        return Tag::orderBy('sort_order')
            ->get()
            ->map(fn(Tag $t): TagDto => TagDto::toDto($t));
    }

    /**
     * @override
     * @param TagRequest $request
     * @return Tag
     */
    public function save(TagRequest $request): Tag
    {
        $tag = $request->has('id') && $request->id !== null
            ? Tag::find($request->id)
            : new Tag();

        $tag->fill($request->all());
        $tag->save();

        return $tag;
    }

    /**
     * @override
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        Tag::whereIn('id', $request->input('ids'))->delete();
    }

    public function getForSelection(): Collection
    {
        return Tag::select(['id', 'title'])
            ->orderBy('sort_order')
            ->get()
            ->map(fn(Tag $t): TagRequestSelectDto => TagRequestSelectDto::toSelectDto($t));
    }
}
