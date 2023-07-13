<?php


namespace App\Services\Interfaces;


use App\Dto\CatalogTypeListDto;
use Illuminate\Http\Request;

interface CatalogTypeService
{
    public function getAll(): mixed;

    public function getById(int $id): CatalogTypeListDto;

    public function remove(int $id): void;

    public function removeMultiple(Request $request): void;
}
