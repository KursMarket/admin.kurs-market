<?php


namespace App\Services;


use App\Dto\CourseSchoolResultForFilters;
use App\Dto\SchoolDto;
use App\Dto\SchoolEditDto;
use App\Http\Requests\SchoolRequest;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SchoolService
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function getWithPaginate(Request $request): mixed
    {
        $limit = $request->has('limit') && $request->input('limit') ? $request->input('limit') : 20;
        $results = School::with('user')->orderBy('user_id', 'desc');
        if ($request->has('search') && $request->input('search')) {
            $results
                ->where(DB::raw('lcase(name)'), 'like', '%'. Str::lower($request->input('search')) .'%')
                ;
        }

        return $results
            ->limit($limit)
            ->offset($request->input('offset'))
            ->get()
            ->map(fn(School $school): SchoolDto => SchoolDto::fromModel($school))
        ;
    }

    /**
     * Get total schools
     *
     * @param Request $request
     * @return int|null
     */
    public function getTotal(Request $request): ?int
    {
        $results = School::orderBy('user_id', 'desc');
        if ($request->has('search') && $request->input('search')) {
            $results
                ->where(DB::raw('lcase(name)'), 'like', '%'. Str::lower($request->input('search')) .'%')
            ;
        }

        return $results->count();
    }

    /**
     * Update school status from id's array
     *
     * @param Request $request
     */
    public function updateStatuses(Request $request): void
    {
        $status = $request->input('status') ?? 0;
        if ($request->has('ids') && $request->input('ids')) {
            array_map(function ($userId) use ($status) {
                School::where('user_id', $userId)->update(['confirm_status' => $status]);
            }, $request->input('ids'));
        }
    }

    /**
     * Delete multiple schools by ids
     *
     * @param Request $request
     */
    public function delete(Request $request): void
    {
        try {
            DB::beginTransaction();
            if ($request->has('ids') && $request->input('ids')) {
                School::whereIn('user_id', $request->input('ids'))->delete();
                $users = User::whereIn('id', $request->input('ids'));

                foreach ($users->get() as $item) {
                        $item->clearMediaCollection('school-preview');
                }

                $users->delete();
            }
            DB::commit();
        } catch (\Exception $e) {
            Log::error("ERROR removing schools: {$e->getMessage()}");
            DB::rollBack();
        }
    }

    /**
     * @param SchoolRequest $request
     * @return bool
     */
    public function saveSchool(SchoolRequest $request): bool
    {
        try {
            DB::beginTransaction();

            if ($request->input('id')) {
                $school = School::where('user_id', $request->input('id'))->first();
                $user = User::find($request->input('id'));
            } else {
                $school = new School();
                $user = new User();
            }

            $data = array_map(fn($d) => str_replace(["null", "false"], [null, false], $d), $request->all());
            $data['password'] = bcrypt($request->input('password'));
            $data['role_id'] = User::getUserRoleId('school');
            $data['confirm_status'] = (bool)$request->input('confirm_status') ? 1 : 0;

            $user->fill($data);
            $user->save();

            if ($request->has('file') && $request->file instanceof UploadedFile) {
                $user->clearMediaCollection('school-preview');
                $user
                    ->addMediaFromRequest('file')
                    ->toMediaCollection('school-preview', 'public')
                ;
            }

            $data['user_id'] = $user->id;
            $school->fill($data);
            $school->save();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Save school error: {$e->getMessage()}, {$e->getFile()}");
            return false;
        }
    }

    /**
     * @param int $schoolId
     * @return SchoolEditDto
     */
    public function get(int $schoolId): SchoolEditDto
    {
        $school = School::with('user')->where('user_id', $schoolId)->first();
        return SchoolEditDto::toDto($school);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function findByName(Request $request): array
    {
        $results =  School::select(['schools.user_id as id', 'schools.name'])
            ->leftJoin('users', 'users.id', '=', 'schools.user_id')
            ->where('users.status', User::CONFIRMED)
            ->where('schools.confirm_status', School::CONFIRMED)
            ->where(DB::raw('lcase(schools.name)'), 'like', '%'. Str::lower($request->name) .'%');

        if ($request->has('ids') && $request->input('ids')) {
            $results->whereNotIn('schools.user_id', explode(',', $request->input('ids')));
        }
        return $results->limit(10)
            ->get()
            ->toArray()
            ;
    }

    public function getSchoolListForFiltering(): Collection
    {
        return School::query()
            ->select(['user_id as id', 'name'])
            ->orderBy('name')
            ->get()
            ->map(fn(School $school): CourseSchoolResultForFilters => CourseSchoolResultForFilters::toDtoWithCorrectId($school));
    }
}
