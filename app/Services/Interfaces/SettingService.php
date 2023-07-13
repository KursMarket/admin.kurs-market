<?php


namespace App\Services\Interfaces;


use App\Models\Option;
use Illuminate\Http\Request;

interface SettingService
{
    public function saveBanner(Request $request): void;

    public function getOption(string $name): ?Option;

    public function removeImage(string $conversion, string $optionKey);

    public function saveAdvantages(Request $request): void;

    public function getAdvantages(): ?array;

    public function editAdvantage(Request $request, int $id): void;

    public function removeAdvantage(int $id): void;

    public function getQuiz(): ?array;

    public function saveQuiz(Request $request): void;

    public function getPromoModule(): array;

    public function savePromo(Request $request): void;

    public function saveCollaboration(Request $request): void;

    public function getCollaborationModule(): array;
}
