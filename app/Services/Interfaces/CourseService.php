<?php


namespace App\Services\Interfaces;


use App\Dto\CourseSingleDto;
use App\Http\Requests\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface CourseService
{
    public function getAllWithPaginate(Request $request): array;

    public function updateMultipleStatus(Request $request): void;

    public function destroy(Request $request): void;

    public function save(CourseRequest $request): Course;

    public function findById(int $id): CourseSingleDto;

    public function destroyImage(int $courseId): void;
    public function getCoursesListForFiltering(): Collection;
}

