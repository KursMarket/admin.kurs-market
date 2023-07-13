<?php


namespace App\Dto;


use App\Models\School;
use Spatie\DataTransferObject\DataTransferObject;

final class SchoolEditDto extends DataTransferObject
{
    public int $id;
    public string $name;
    public ?string $short_title;
    public ?string $phone;
    public ?string $partner_suffix;
    public ?string $partner_postfix;
    public ?string $description;
    public ?string $email;
    public ?string $site_link;
    public ?string $site_link_text;
    public bool $confirm_status;
    public ?string $confirm_status_message;
    public ?string $meta_point;
    public ?int $review_count;
    public ?int $rating;
    public ?string $meta_h1;
    public ?string $meta_title;
    public ?string $meta_description;
    public string $url;
    public ?string $image;
    public ?int $sort_order;

    public static function toDto(School $school): self
    {
        $schoolMedia = $school->user->getFirstMedia('school-preview');
        return new static([
            'id' => $school->user_id,
            'name' => $school->name,
            'short_title' => $school->short_title,
            'phone' => $school->phone,
            'email' => $school->user->email,
            'partner_suffix' => $school->partner_suffix,
            'partner_postfix' => $school->partner_postfix,
            'description' => $school->description,
            'site_link' => $school->site_link,
            'site_link_text' => $school->site_link_text,
            'confirm_status' => (bool)$school->confirm_status,
            'confirm_status_message' => $school->confirm_status_message,
            'meta_point' => $school->meta_point,
            'review_count' => $school->review_count,
            'rating' => $school->rating,
            'meta_h1' => $school->meta_h1,
            'meta_title' => $school->meta_title,
            'meta_description' => $school->meta_description,
            'url' => $school->url,
            'sort_order' => $school->sort_order,
            'image' => $schoolMedia ? $schoolMedia->getUrl() : null
        ]);
    }
}
