<?php

namespace App\Services\Interfaces;

use App\Http\Resources\Reviews\ReviewResource;
use App\Models\Review;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as Collect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface ReviewServiceInterface
{
    public function getById(int $id): ReviewResource;

    public function save(Request $request): Model|Collection|Builder|string|array|Review|null;

    public function getStatusesList(): array;

    public function getSourcesList(): array;

    public function updateStatuses(Request $request): void;

    public function getUsersList(): Collect;

    public function destroyMultiple(Request $request): void;
}
