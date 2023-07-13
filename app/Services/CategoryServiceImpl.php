<?php


namespace App\Services;


use App\Dto\CategoryDto;
use App\Exceptions\CategoryHasChildrenException;
use App\Exceptions\CategorySaveException;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\Interfaces\CategoryService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryServiceImpl implements CategoryService
{

    /**
     * Create a new or edit existing category
     *
     * @override
     * @param CategoryRequest $request
     * @return Category
     * @throws CategorySaveException
     */
    public function save(CategoryRequest $request): Category
    {
        try {
            DB::beginTransaction();

            $category = null !== $request->input('id')
                ? Category::find($request->input('id'))
                : new Category()
            ;
            $data = $request->all();
            if (!$data['show_in_catalog']) {
                $data['show_in_catalog'] = false;
            }

            if (!$data['show_in_rating']) {
                $data['show_in_rating'] = false;
            }

            $category->fill($data);
            $category->save();

            DB::table('category_related')
                ->where('category_id', $category->id)
                ->delete()
            ;

            if ($request->has('related') && $request->input('related')) {
                $data = [];
                foreach ($request->input('related') as $item) {
                    $data[] = [
                        'category_id'           => $category->id,
                        'related_category_id'   => $item
                    ];
                }
                DB::table('category_related')
                    ->insert($data)
                ;
            }

            DB::commit();

            return $category;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new CategorySaveException($e->getMessage(), "Ошибка сохранения");
        }
    }

    /**
     * @override
     * @param int|null $parent
     * @return mixed
     */
    public function get(?int $parent = null): mixed
    {
        return Category::select(['id', 'title', 'url'])
            ->where('parent_id', $parent)
            ->get()
            ->map(fn(Category $category): CategoryDto => CategoryDto::toDto($category, $this))
        ;
    }

    /**
     * @override
     * @param int $id
     * @return void
     * @throws CategoryHasChildrenException
     */
    public function delete(int $id): void
    {
        $childCategoriesCount = Category::where('parent_id', $id)->count();
        if ($childCategoriesCount !== 0) {
            throw new CategoryHasChildrenException("Нельзя удалить категорию, в которой присутствуют дочерние категории.");
        }

        Category::where('id', $id)->delete();
    }

    /**
     * @override
     * @param int $parentId
     * @return array|Collection
     */
    public function getChildren(int $parentId): array|Collection
    {
        return Category::select(['id', 'title', 'url'])
            ->where('parent_id', $parentId)
            ->orderBy('sort_order')
            ->get()
            ->map(fn(Category $category): CategoryDto => CategoryDto::toSelectDto($category));
    }

    public function removeRelated(int $categoryId, int $relatedId): void
    {
        DB::table('category_related')
            ->where([
                'category_id' => $categoryId,
                'related_category_id' => $relatedId
            ])->delete();
    }
}
