<?php


namespace App\Dto;


use App\Models\School;
use Spatie\DataTransferObject\DataTransferObject;

final class SchoolDto extends DataTransferObject
{
    public int $id;
    public string $name;
    public int $courseCount;
    public ?string $dateRegister;
    public bool $status;

    public static function fromModel(School $school): self
    {
        return new static([
            'id' => $school->user_id,
            'name' => $school->name,
            'courseCount' => 4,
            'dateRegister' => generateHumanDate($school->user->created_at),
            'status' => (bool)$school->confirm_status,
        ]);
    }
}
