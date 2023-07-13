<?php


namespace App\Services;


use App\Dto\CourseListDto;
use App\Dto\CourseSchoolResultForFilters;
use App\Dto\CourseSingleDto;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\School;
use App\Services\Interfaces\CourseService;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseServiceImpl implements CourseService
{
    /**
     * @override
     * @param Request $request
     * @return array
     */
    public function getAllWithPaginate(Request $request): array
    {
        $limit = $request->has('limit') && $request->input('limit')
            ? $request->input('limit')
            : 20
        ;

        $offset = $request->has('offset') && $request->input('offset')
            ? $request->input('offset')
            : 0
        ;

        $results = Course::with('school')
            ->orderBy('courses.title');

        if ($request->has('search') && $request->input('search')) {
            $results
                ->where(DB::raw('lcase(courses.title)'), 'like', '%'. Str::lower($request->input('search')) .'%')
            ;
        }

        $date_from = null;
        $date_to = null;

        if ($request->has('date_from') && "null" !== $request->input('date_from') && $request->input('date_from')) {
            $date_from = Carbon::parse($request->date_from)
                ->format('Y-m-d')
            ;
        }

        if ($request->has('date_to') && "null" !== $request->input('date_to') && $request->input('date_to')) {
            $date_to = Carbon::parse($request->date_to)
                ->format('Y-m-d')
            ;
        }

        if (null !== $date_from && null !== $date_to) {
            $results
                ->where(function ($q) use ($date_from, $date_to) {
                    $q->whereBetween('courses.created_at', [$date_from, $date_to]);
                })
            ;
        } else if (null !== $date_from && null === $date_to) {
            $results
                ->where(function ($q) use ($date_from) {
                    $q->whereDate('courses.created_at', '>=', $date_from);
                })
            ;
        } else if (null !== $date_to && null === $date_from) {
            $results
                ->where(function ($q) use ($date_to) {
                    $q->whereDate('courses.created_at', '<=', $date_to);
                })
            ;
        }

        if ($request->has('school') && $request->input('school')) {
            $results
                ->whereIn('courses.school_id', [$request->school])
            ;
        }

        if ($request->has('status') && $request->input('status')) {
            $results
                ->whereIn('courses.status', [$request->status])
            ;
        }

        if ($request->has('category') && $request->input('category')) {
            $results
                ->join('category_course as c2c', function (JoinClause $join) use ($request) {
                    $join->on('courses.id', '=', 'c2c.course_id')
                        ->where('c2c.category_id', '=', $request->category);
                })
            ;
        }

        if ($request->has('sub_category') && $request->input('sub_category')) {
            $results
                ->join('category_course as sc2c', function (JoinClause $join) use ($request) {
                    $join->on('courses.id', '=', 'sc2c.course_id')
                        ->where('sc2c.category_id', '=', $request->sub_category);
                })
            ;
        }

        $total = $results->count();

        return [
            'total' => $total,
            'courses' => $results
                ->limit($limit)
                ->offset($offset)
                ->get()
                ->map(fn(Course $course): CourseListDto => CourseListDto::toListDto($course))
        ];
    }

    /**
     * @override
     * @param Request $request
     * @return void
     */
    public function updateMultipleStatus(Request $request): void
    {
        $status = $request->input('status') === true
            ? Course::ACTIVE_STATUS
            : Course::HIDDEN_STATUS
        ;
        Course::whereIn('id', $request->ids)
            ->update(['status' => $status]);
    }

    /**
     * @override
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request): void
    {
        $courses = Course::whereIn('id', $request->ids);

        $courses->each(function ($course) {
                $course->clearMediaCollection('course-preview');
            })
        ;

        $courses->delete();
    }

    /**
     * @override
     * @param CourseRequest $request
     * @return Course
     */
    public function save(CourseRequest $request): Course
    {
        $data = transformRequest($request);

        DB::beginTransaction();
        try {
            $course = $request->has('id') && $request->id
                ? Course::find($request->id)
                : new Course()
            ;

            $course->title = $data['title'];
            $course->prefix = $data['prefix'];
            $course->school_id = $data['school'];
            $course->source_link = $data['source_link'];
            $course->show_in_rating = $request->has('show_in_rating') && true === $data['show_in_rating'];
            $course->study_duration = $data['study_duration'];
            $course->study_duration_key = $request->has('time') ? $data['time'] : null;
            $course->price = $data['price'];
            $course->sale = $request->has('sale') && $data['sale'] ? $data['sale_price'] : 0;
            $course->sale_key = $request->has('sale_status') && $data['sale_status'] ? $data['sale_status'] : null;
            $course->status = Course::ACTIVE_STATUS;
            if ($request->has('credit') && true === $data['credit']) {
                $course->credit_price = $data['credit_month_price'] ? $data['credit_month_price'] : null;
                $course->credit_month = $data['credit_month'] ? $data['credit_month'] : null;
            }

            $course->additional_description = $data['additional_description'];
            $course->feed_id = $data['feed_id'];
            $course->sort_order_in_schools = $data['sort_order_in_schools'];
            $course->sort_order_in_categories = $data['sort_order_in_categories'];
            $course->url = $data['url'];

            $course->save();

            DB::table('category_course')->where('course_id', $course->id)->delete();
            $results = [];
            if ($request->has('sub_category') && null !== $data['sub_category']) {
                $categories = explode(',', $data['sub_category']);
                if ($categories) {
                    foreach ($categories as $item) {
                        $results[] = [
                            'category_id' => $item,
                            'course_id' => $course->id,
                        ];
                    }
                }
            }

            if ($results) {
                DB::table('category_course')->insert($results);
            }

            DB::table('tag_course')->where('course_id', $course->id)->delete();

            $results = [];
            if ($request->has('selectedTags') && null !== $data['selectedTags']) {
                $selectedTags = explode(',', $data['selectedTags']);
                if ($selectedTags) {
                    foreach ($selectedTags as $item) {
                        if ($item) {
                            $results[] = [
                                'tag_id' => $item,
                                'course_id' => $course->id,
                            ];
                        }
                    }
                }
            }
            if ($results) {
                DB::table('tag_course')->insert($results);
            }

            if ($request->has('image') && $data['image'] instanceof UploadedFile) {
                $course->clearMediaCollection('course-preview');
                $course->addMediaFromRequest('image')->sanitizingFileName(function ($fileName) {
                    return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                })->toMediaCollection('course-preview');
            }


            DB::commit();

            return $course;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

    }

    /**
     * @param int $id
     * @return CourseSingleDto
     */
    public function findById(int $id): CourseSingleDto
    {
        $course = Course::find($id);
        return CourseSingleDto::toDto($course);
    }

    /**
     * @param int $courseId
     */
    public function destroyImage(int $courseId): void
    {
        $course = Course::find($courseId);
        $course->clearMediaCollection('course-preview');
    }

    public function getCoursesListForFiltering(): Collection
    {
        return Course::query()
            ->select(['id', 'title', 'school_id'])
            ->orderBy('title')
            ->get()
            ->map(fn(Course $course): CourseSchoolResultForFilters => CourseSchoolResultForFilters::toListDtoForFiltering($course));
    }
}
