<?php


namespace App\Services;


use App\Exceptions\NotFoundException;
use App\Models\Option;
use App\Models\School;
use App\Models\User;
use App\Services\Interfaces\SettingService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingServiceImpl implements SettingService
{
    /**
     * @param Request $request
     */
    public function saveBanner(Request $request): void
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $bannerTitle = Option::where('option_name', Option::MAIN_BANNER_H1_TITLE)->first();

            if (!$bannerTitle) {
                $bannerTitle = new Option();
            }

            $bannerTitle->option_name = Option::MAIN_BANNER_H1_TITLE;
            $bannerTitle->option_value = $data['title'];
            $bannerTitle->setConversionPrefix("banner");
            if ($request->has('file') && $request->file('file') instanceof UploadedFile) {
                $bannerTitle->clearMediaCollection($bannerTitle->getConversionPrefix());
                $bannerTitle->addMediaFromRequest('file')
                    ->sanitizingFileName(function ($fileName) {
                        return strtolower(str_replace(['#', '/', '\\', ' '], '-', $fileName));
                    })->toMediaCollection($bannerTitle->getConversionPrefix());
            }

            $bannerTitle->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Save option: {$e->getMessage()}");
        }
    }

    /**
     * @param string $name
     * @return Option|null
     */
    public function getOption(string $name): ?Option
    {
        return Option::where('option_name', $name)
            ->first()
            ;
    }

    /**
     * @param string $conversion
     * @param string $optionKey
     */
    public function removeImage(string $conversion, string $optionKey)
    {
        $option = Option::where('option_name', $optionKey)->first();
        if ($option) {
            $option->clearMediaCollection($conversion);
        }
    }

    /**
     * @param Request $request
     */
    public function saveAdvantages(Request $request): void
    {
        $data = $request->all();
        $id = 1;
        $advantagesBlock = [];
        if (null === $data['id']) {
            $advantages = $this->getOption(Option::ADVANTAGES_BLOCK);

            if ($advantages) {
                $advantagesBlock = unserialize($advantages->option_value);

                if ($advantagesBlock) {
                    $id = count($advantagesBlock)+1;
                }
            }
        }

        $data['id'] = $id;
        $prepareData = array_merge($advantagesBlock, [$data]);

        $sortOrder = array_column($prepareData, 'sort_order');

        array_multisort($sortOrder, SORT_ASC, $prepareData);

        Option::updateOrInsert([
            'option_name' => Option::ADVANTAGES_BLOCK
        ], [
            'option_value' => serialize($prepareData)
        ]);
    }

    /**
     * @return array|null
     */
    public function getAdvantages(): ?array
    {
        $options = $this->getOption(Option::ADVANTAGES_BLOCK);

        if (!$options) return [];

        return unserialize($options->option_value);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return void
     * @throws NotFoundException
     */
    public function editAdvantage(Request $request, int $id): void
    {
        $options = $this->getOption(Option::ADVANTAGES_BLOCK);

        if (!$options) {
            throw new NotFoundException('Не найдено опций!');
        }

        $advantagesUnserialized = unserialize($options->option_value);

        foreach ($advantagesUnserialized as &$item) {
            if ((int)$item['id'] === (int)$id) {
                $item['title'] = $request->title;
                $item['description'] = $request->description;
                $item['sort_order'] = $request->sort_order;
            }
        }

        $options->option_value = serialize($advantagesUnserialized);
        $options->save();
    }

    /**
     * @param int $id
     * @throws NotFoundException
     */
    public function removeAdvantage(int $id): void
    {
        $option = $this->getOption(Option::ADVANTAGES_BLOCK);
        if (!$option) {
            throw new NotFoundException('Не найдено опций!');
        }
        $options = unserialize($option->option_value);

        $newOptions = array_filter($options, fn(array $data) => (int)$data['id'] !== (int)$id);

        $option->option_value = serialize($newOptions);
        $option->save();
    }

    /**
     * @return array|null
     */
    public function getQuiz(): ?array
    {
        $option = $this->getOption(Option::QUIZ_MODULE);

        if (!$option) return [];

        return unserialize($option->option_value);
    }

    /**
     * @param Request $request
     */
    public function saveQuiz(Request $request): void
    {
        Option::updateOrInsert([
            'option_name' => Option::QUIZ_MODULE
        ], [
            'option_value' => serialize($request->all())
        ]);
    }

    /**
     * @return array
     */
    public function getPromoModule(): array
    {
        $option = $this->getOption(Option::PROMO_MODULE);

        if (!$option) return [];

        return unserialize($option->option_value);

    }

    /**
     * @param Request $request
     */
    public function savePromo(Request $request): void
    {
        Option::updateOrInsert([
            'option_name' => Option::PROMO_MODULE
        ], [
            'option_value' => serialize($request->all())
        ]);
    }

    /**
     * @param Request $request
     */
    public function saveCollaboration(Request $request): void
    {
        Option::updateOrInsert([
            'option_name' => Option::COLLABORATION_MODULE
        ], [
            'option_value' => serialize($request->all())
        ]);
    }

    /**
     * @return array
     */
    public function getCollaborationModule(): array
    {
        $option = $this->getOption(Option::COLLABORATION_MODULE);

        if (!$option) return [];

        return unserialize($option->option_value);
    }
}
