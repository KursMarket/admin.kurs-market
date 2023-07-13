<?php

namespace App\Services;

use App\Dto\CourseListDto;
use App\Dto\StudentDto;
use App\Dto\StudentSelectDto;
use App\Enums\Reviews\Sources;
use App\Enums\Reviews\Status;
use App\Http\Resources\Reviews\ReviewCollection;
use App\Http\Resources\Reviews\ReviewResource;
use App\Models\Course;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use App\Services\Interfaces\ReviewServiceInterface;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection as Collect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReviewService implements ReviewServiceInterface
{
    /**
     * Gets all reviews with pagination and additional filters
     *
     * @param Request $request
     * @return array
     */
    public function getAllWithPaginate(Request $request): array
    {
        $limit = $request->has('limit') && $request->input('limit')
            ? $request->input('limit')
            : 20;

        $offset = $request->has('offset') && $request->input('offset')
            ? $request->input('offset')
            : 0;

        $results = Review::with('school', 'course')
            ->orderBy('reviews.created_at');

        if ($request->has('search') && $request->input('search')) {
            $results
                ->where(DB::raw('lcase(reviews.title)'), 'like', '%' . Str::lower($request->input('search')) . '%');
        }

        $date_from = null;
        $date_to = null;

        if ($request->has('date_from') && "null" !== $request->input('date_from') && $request->input('date_from')) {
            $date_from = Carbon::parse($request->date_from)
                ->format('Y-m-d');
        }

        if ($request->has('date_to') && "null" !== $request->input('date_to') && $request->input('date_to')) {
            $date_to = Carbon::parse($request->date_to)
                ->format('Y-m-d');
        }

        if (null !== $date_from && null !== $date_to) {
            $results
                ->where(function ($q) use ($date_from, $date_to) {
                    $q->whereBetween('reviews.created_at', [$date_from, $date_to]);
                });
        } else if (null !== $date_from && null === $date_to) {
            $results
                ->where(function ($q) use ($date_from) {
                    $q->whereDate('reviews.created_at', '>=', $date_from);
                });
        } else if (null !== $date_to && null === $date_from) {
            $results
                ->where(function ($q) use ($date_to) {
                    $q->whereDate('reviews.created_at', '<=', $date_to);
                });
        }

        if ($request->has('school') && $request->input('school')) {
            $results
                ->whereIn('reviews.school_id', [$request->school]);
        }

        if ($request->has('status') && $request->input('status')) {
            $results
                ->whereIn('reviews.status', [$request->status]);
        }

        $total = $results->count();
        $reviews = $results->limit($limit)->offset($offset)->get();

        return [
            'total' => $total,
            'reviews' => new ReviewCollection($reviews)
        ];
    }

    /**
     * @param Request $request
     * @return Model|Collection|Builder|string|array|Review|null
     */
    public function save(Request $request): Model|Collection|Builder|string|array|Review|null
    {
        $data = transformRequest($request);
        $review = $request->has('id') && $data['id'] ? Review::query()->findOrFail($request->id) : new Review();
        $review->fill($data);
        $review->save();

        return $review;
    }

    /**
     * @param int $id
     * @return ReviewResource
     */
    public function getById(int $id): ReviewResource
    {
        return new ReviewResource(Review::query()->with('school', 'course')->findOrFail($id));
    }

    /**
     * @return array
     */
    public function getStatusesList(): array
    {
        return (new Status())->getAllReviewStatuses();
    }

    /**
     * @return array
     */
    public function getSourcesList(): array
    {
        return (new Sources())->getAllReviewSources();
    }

    /**
     * @param Request $request
     */
    public function updateStatuses(Request $request): void
    {
        $status = $request->status
            ? Status::PUBLISHED
            : Status::REJECTED
        ;

        Review::whereIn('id', $request->input('ids'))->update(['status' => $status]);
    }

    /**
     * @return Collect
     */
    public function getUsersList(): Collect
    {
        return User::query()
            ->orderBy('email')
            ->where(['role_id' => User::ROLE_STUDENT, 'status' => User::CONFIRMED])
            ->get()
            ->map(fn(User $user): StudentSelectDto => StudentSelectDto::toDto($user));
    }

    /**
     * @param Request $request
     */
    public function destroyMultiple(Request $request): void
    {
        Review::whereIn('id', $request->input('ids'))->delete();
    }
}
