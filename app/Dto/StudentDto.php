<?php


namespace App\Dto;


use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class StudentDto extends DataTransferObject
{
    public int $id;
    public ?string $email;
    public ?string $firstName;
    public ?string $lastName;

    public static function toAdminSelectionDto(User $user): self
    {
        return new static([
            'id' => $user->id,
            'email' => $user->email,
            'firstName' => $user->student->first_name,
            'lastName' => $user->student->last_name
        ]);
    }
}
