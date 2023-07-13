<?php


namespace App\Services\Interfaces;


use App\Dto\StudyDurationDto;
use App\Http\Requests\StudyDurationRequest;
use App\Models\StudyDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface StudyDurationService
{
    public function get(): Collection;

    public function getById(int $id): StudyDurationDto;

    public function save(StudyDurationRequest $request): StudyDuration;

    public function destroy(Request $request): void;

    public function getForSelection(): Collection;
}
