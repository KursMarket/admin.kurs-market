<?php


namespace App\Services;

use App\Dto\CatalogTypeListDto;
use App\Models\CatalogType;
use App\Services\Interfaces\CatalogTypeService;
use Illuminate\Http\Request;

class CatalogTypeServiceImpl implements CatalogTypeService
{
    /**
     * @override
     * @return mixed
     */
    public function getAll(): mixed
    {
        return CatalogType::select([
            'id',
            'title',
            'url',
            'sort_order'
        ])
            ->orderBy('sort_order')
            ->get()
            ->map(fn(CatalogType $type): CatalogTypeListDto => CatalogTypeListDto::toDto($type))
            ;
    }

    /**
     * @override
     * @param int $id
     * @return CatalogTypeListDto
     */
    public function getById(int $id): CatalogTypeListDto
    {
        $type = CatalogType::find($id);
        return CatalogTypeListDto::toDto($type);
    }

    /**
     * @override
     * @param int $id
     * @return void
     */
    public function remove(int $id): void
    {
        $type = CatalogType::find($id);
        $type->delete();
    }

    /**
     * @override
     * @param Request $request
     * @return void
     */
    public function removeMultiple(Request $request): void
    {
        CatalogType::whereIn('id', $request->input('types'))->delete();
    }
}
