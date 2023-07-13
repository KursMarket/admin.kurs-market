<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Sale;
use App\Services\Interfaces\SaleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class SaleController extends Controller
{
    const PATH = 'sales.';

    /**
     * SaleController constructor.
     * @param SaleService $saleService
     */
    public function __construct(
        private SaleService $saleService
    ) {}

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $title = 'Управление скидками';
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Все скидки'
        ];
        $sales = Sale::orderByDesc('date_to')
            ->paginate(20)
        ;
        return view(self::PATH . 'index', compact('sales', 'title', 'breadcrumbs'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
        $title = 'Создать скидку';
        $breadcrumbs[] = [
            'url' => route('sales.index'),
            'title' => 'Все скидки'
        ];
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Добавить'
        ];
        return view(self::PATH . 'create', compact('title', 'breadcrumbs'));
    }

    /**
     * @param SaleRequest $request
     * @return RedirectResponse
     */
    public function store(SaleRequest $request): RedirectResponse
    {
        $this->saleService->save($request);
        return redirect()->route('sales.index')->with(['message' => 'Скидка сохранена']);
    }

    public function edit($id)
    {
        $title = 'Редактировать скидку';
        $breadcrumbs[] = [
            'url' => route('sales.index'),
            'title' => 'Все скидки'
        ];
        $breadcrumbs[] = [
            'url' => '',
            'title' => 'Редактировать'
        ];
        $sale = Sale::find($id);

        return view(self::PATH . 'edit', compact('sale', 'title', 'breadcrumbs'));
    }

    public function update(SaleRequest $request, $id)
    {
        $request->request->add(['id' => $id]);
        $this->saleService->save($request);

        return redirect()->route('sales.index')->with(['message' => 'Скидка обновлена']);
    }

    public function destroy($id)
    {
        Sale::find($id)->delete();
        return redirect()->back()->with(['message' => 'Скидка удалена']);
    }
}
