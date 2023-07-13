<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Models\Option;
use App\Services\Interfaces\SettingService;
use App\Services\Response\ResponseService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    const PATH = 'settings.';

    /**
     * SettingsController constructor.
     * @param SettingService $settingService
     */
    public function __construct(
        private SettingService $settingService
    ) {}

    /**
     * @return Application|Factory|View
     */
    public function banner(): Application|Factory|View
    {
        $title = 'Настройки главного баннера';

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Управление'
        ];
        return view(self::PATH . 'banner', compact('title', 'breadcrumbs'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveBanner(Request $request): JsonResponse
    {
        $this->settingService->saveBanner($request);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @return JsonResponse
     */
    public function getBanner(): JsonResponse
    {
        $title = $this->settingService->getOption(Option::MAIN_BANNER_H1_TITLE);
        $media = $title?->getFirstMedia('banner_options');
        $data = [];
        if ($media) {
            $data = [
                'name' => $media->file_name,
                'size' => $media->size,
                'url' => $media->getUrl()
            ];
        }

        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'title' => $title->option_value,
                'image' => $data
            ]
        );
    }

    public function getBannerImage(Request $request): ?string
    {
        $data = $request->all();
        $banner = Option::find($data['id']);

        if (!$banner) return null;

        return $banner->getFirstMediaUrl('banner_options');
    }

    /**
     * @return void
     */
    public function removeImage(): void
    {
        $this->settingService->removeImage('banner_options', Option::MAIN_BANNER_H1_TITLE);
    }

    /**
     * @return Application|Factory|View
     */
    public function advantagesIndex(): Application|Factory|View
    {
        $title = 'Настройки преимуществ';

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Управление'
        ];
        return view(self::PATH . 'advantages', compact('title', 'breadcrumbs'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveAdvantages(Request $request): JsonResponse
    {
        $this->settingService->saveAdvantages($request);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @return JsonResponse
     */
    public function getAdvantages(): JsonResponse
    {
        $advantages = $this->settingService->getAdvantages();
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            ['results' => $advantages]
        );
    }

    /**
     * @param Request $request
     * @param int|null $id
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function editAdvantage(Request $request, ?int $id): JsonResponse
    {
        if (!$id) {
            throw new BadRequestException('Не указан идентификатор!');
        }

        $this->settingService->editAdvantage($request, $id);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @param int|null $id
     * @return JsonResponse
     * @throws BadRequestException
     */
    public function deleteAdvantage(?int $id): JsonResponse
    {
        if (!$id) {
            throw new BadRequestException('Не указан идентификатор!');
        }
        $this->settingService->removeAdvantage($id);
        return ResponseService::sendJsonResponse(true);
    }

    /**
     * @return Application|Factory|View
     */
    public function quizModule(): Application|Factory|View
    {
        $title = 'QUIZ';

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Управление'
        ];
        return view(self::PATH . 'quiz', compact('title', 'breadcrumbs'));
    }

    /**
     * @return JsonResponse
     */
    public function getQuizModule(): JsonResponse
    {
        $option = $this
            ->settingService
            ->getQuiz()
        ;

        return ResponseService::sendJsonResponse(true, 200, null, ['result' => $option]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function saveQuizModule(Request $request): JsonResponse
    {
        $this->settingService->saveQuiz($request);
        return ResponseService::sendJsonResponse(true);
    }

    public function quizPromo(): Application|Factory|View
    {
        $title = 'Промокоды';

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Управление'
        ];
        return view(self::PATH . 'promo', compact('title', 'breadcrumbs'));
    }

    /**
     * @return JsonResponse
     */
    public function getPromoModule(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'result' => $this->settingService->getPromoModule()
            ]
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function savePromoModule(Request $request): JsonResponse
    {
        $this->settingService->savePromo($request);
        return ResponseService::sendJsonResponse(true);
    }

    public function collaborationModule(): Application|Factory|View
    {
        $title = 'Сотрудничество';

        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Управление'
        ];
        return view(self::PATH . 'collaboration', compact('title', 'breadcrumbs'));
    }

    public function saveCollaborationModule(Request $request): JsonResponse
    {
        $this->settingService->saveCollaboration($request);
        return ResponseService::sendJsonResponse(true);
    }

    public function getCollaborationModule(): JsonResponse
    {
        return ResponseService::sendJsonResponse(
            true,
            200,
            null,
            [
                'result' => $this->settingService->getCollaborationModule()
            ]
        );
    }
}
