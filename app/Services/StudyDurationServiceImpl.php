<?php


namespace App\Services;


use App\Dto\StudyDurationDto;
use App\Dto\StudyDurationRequestSelectDto;
use App\Http\Requests\StudyDurationRequest;
use App\Models\StudyDuration;
use App\Services\Interfaces\StudyDurationService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StudyDurationServiceImpl implements StudyDurationService
{

    /**
     * @override
     * @return Collection
     */
    public function get(): Collection
    {
        return StudyDuration::orderBy('sort_order')
            ->get()
            ->map(fn(StudyDuration $duration): StudyDurationDto => StudyDurationDto::toDto($duration));
    }

    /**
     * @override
     * @param int $id
     * @return StudyDurationDto
     */
    public function getById(int $id): StudyDurationDto
    {
        return StudyDurationDto::toDto(StudyDuration::find($id));
    }

    /**
     * @override
     * @param StudyDurationRequest $request
     * @return StudyDuration
     */
    public function save(StudyDurationRequest $request): StudyDuration
    {
        $duration = $request->has('id') && $request->input('id')
            ? StudyDuration::find($request->input('id'))
            : new StudyDuration()
        ;

        $duration->fill($request->all());
        $duration->save();

        return $duration;
    }

    /**
     * @override
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        StudyDuration::whereIn('id', $request->input('ids'))->delete();
    }

    /**
     * @return Collection
     */
    public function getForSelection(): Collection
    {
        return StudyDuration::select(['id', 'title'])
            ->orderBy('sort_order')
            ->get()
            ->map(fn(StudyDuration $duration): StudyDurationRequestSelectDto => StudyDurationRequestSelectDto::toSelectionDto($duration));
    }
}
