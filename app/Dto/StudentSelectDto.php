<?php


namespace App\Dto;


use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class StudentSelectDto extends DataTransferObject
{
    public int $id;
    public string $text;

    public static function toDto(User $user): self
    {
        $student = $user->student;
        return new static([
            'id' => $user->id,
            'text' => $student->first_name . ( $student->last_name ? $student->last_name : '' ) . ($user->email ? " ({$user->email})" : '')
        ]);
    }
}
