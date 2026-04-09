<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    private function desktopViewData(): array
    {
        return [
            'pageTitle' => 'Desktop Menus',
            'createRoute' => route('admin.menus.create'),
            'exportRoute' => route('admin.menus.export'),
            'importRoute' => route('admin.menus.import'),
            'editRouteName' => 'admin.menus.edit',
            'deleteRouteName' => 'admin.menus.delete',
            'storeRoute' => route('admin.menus.store'),
            'indexRoute' => route('admin.menus.index'),
            'updateRouteName' => 'admin.menus.update',
        ];
    }

    private function mobileViewData(): array
    {
        return [
            'pageTitle' => 'Mobile Menus',
            'createRoute' => route('admin.menus.mobile.create'),
            'exportRoute' => route('admin.menus.mobile.export'),
            'importRoute' => route('admin.menus.mobile.import'),
            'editRouteName' => 'admin.menus.mobile.edit',
            'deleteRouteName' => 'admin.menus.mobile.delete',
            'storeRoute' => route('admin.menus.mobile.store'),
            'indexRoute' => route('admin.menus.mobile.index'),
            'updateRouteName' => 'admin.menus.mobile.update',
        ];
    }

    public function index()
    {
        $menus = Menu::where(function ($query) {
            $query->where('menu_type', 'desktop')->orWhereNull('menu_type');
        })->orderBy('order')->get();

        return view('admin.menus.index', array_merge(compact('menus'), $this->desktopViewData()));
    }

    public function create()
    {
        return view('admin.menus.create', $this->desktopViewData());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:menus,name',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'href' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        $data['menu_type'] = 'desktop';
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['href'] = $data['href'] ?? '#';
        $data['order'] = $data['order'] ?? 0;

        $menu = Menu::create($data);

        return redirect()->to('admin/menus/'.$menu->id.'/edit')->with('success', 'Menu created successfully.');
    }

    public function edit($menu)
    {
        $menu = Menu::findOrFail((int) $menu);

        $menu->load(['items' => function ($query) {
            $query->orderBy('order');
        }]);

        $rootItems = $menu->items->whereNull('parent_id')->values();
        $parentOptions = $menu->items;

        return view('admin.menus.edit', array_merge(compact('menu', 'rootItems', 'parentOptions'), $this->desktopViewData()));
    }

    public function update(Request $request, $menu)
    {
        $menu = Menu::findOrFail((int) $menu);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:menus,name,'.$menu->id,
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'href' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        $data['menu_type'] = 'desktop';
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['href'] = $data['href'] ?? '#';
        $data['order'] = $data['order'] ?? 0;

        $menu->update($data);

        return redirect()->to('admin/menus/'.$menu->id.'/edit')->with('success', 'Menu updated successfully.');
    }

    public function delete($menu)
    {
        $menu = Menu::findOrFail((int) $menu);

        $menu->delete();

        return redirect()->to('admin/menus')->with('success', 'Menu deleted successfully.');
    }

    public function mobileIndex()
    {
        $menus = Menu::where('menu_type', 'mobile')->orderBy('order')->get();

        return view('admin.menus.index', array_merge(compact('menus'), $this->mobileViewData()));
    }

    public function mobileCreate()
    {
        return view('admin.menus.create', $this->mobileViewData());
    }

    public function mobileStore(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:menus,name',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'href' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        $data['menu_type'] = 'mobile';
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['href'] = $data['href'] ?? '#';
        $data['order'] = $data['order'] ?? 0;

        $menu = Menu::create($data);

        return redirect()->route('admin.menus.mobile.edit', ['menu' => $menu->id])->with('success', 'Mobile menu created successfully.');
    }

    public function mobileEdit($menu)
    {
        $menu = Menu::where('menu_type', 'mobile')->findOrFail((int) $menu);

        $menu->load(['items' => function ($query) {
            $query->orderBy('order');
        }]);

        $rootItems = $menu->items->whereNull('parent_id')->values();
        $parentOptions = $menu->items;

        return view('admin.menus.edit', array_merge(compact('menu', 'rootItems', 'parentOptions'), $this->mobileViewData()));
    }

    public function mobileUpdate(Request $request, $menu)
    {
        $menu = Menu::where('menu_type', 'mobile')->findOrFail((int) $menu);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:menus,name,'.$menu->id,
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'href' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
        ]);

        $data['menu_type'] = 'mobile';
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['href'] = $data['href'] ?? '#';
        $data['order'] = $data['order'] ?? 0;

        $menu->update($data);

        return redirect()->route('admin.menus.mobile.edit', ['menu' => $menu->id])->with('success', 'Mobile menu updated successfully.');
    }

    public function mobileDelete($menu)
    {
        $menu = Menu::where('menu_type', 'mobile')->findOrFail((int) $menu);

        $menu->delete();

        return redirect()->route('admin.menus.mobile.index')->with('success', 'Mobile menu deleted successfully.');
    }

    public function exportDesktopMenus()
    {
        return $this->exportMenusByType('desktop');
    }

    public function exportMobileMenus()
    {
        return $this->exportMenusByType('mobile');
    }

    public function importDesktopMenus(Request $request)
    {
        return $this->importMenusByType($request, 'desktop');
    }

    public function importMobileMenus(Request $request)
    {
        return $this->importMenusByType($request, 'mobile');
    }

    public function createItem(Request $request, $menu)
    {
        $menu = Menu::findOrFail((int) $menu);

        $parentOptions = $menu->items()->orderBy('order')->get();

        $defaultParentId = (int) $request->query('parent_id', 0);
        if ($defaultParentId > 0 && ! $parentOptions->firstWhere('id', $defaultParentId)) {
            $defaultParentId = 0;
        }

        return view('admin.menus.create-item', compact('menu', 'parentOptions', 'defaultParentId'));
    }

    public function storeItem(Request $request, $menu)
    {
        $menu = Menu::findOrFail((int) $menu);

        $request->merge([
            'parent_id' => $request->filled('parent_id') ? (int) $request->input('parent_id') : null,
        ]);

        $data = $request->validate([
            'parent_id' => 'nullable|integer|exists:menu_items,id',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'href' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'has_sub_items' => 'nullable|boolean',
        ]);

        $data['menu_id'] = $menu->id;
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['has_sub_items'] = $request->has('has_sub_items') ? 1 : 0;
        $data['href'] = $data['href'] ?? '#';
        $data['order'] = $data['order'] ?? 0;

        if (! empty($data['parent_id'])) {
            $parent = MenuItem::where('menu_id', $menu->id)->where('id', $data['parent_id'])->first();
            if (! $parent) {
                return redirect()->back()->withErrors(['parent_id' => 'Invalid parent item'])->withInput();
            }
        }

        MenuItem::create($data);

        return redirect()->to('admin/menus/'.$menu->id.'/edit')->with('success', 'Menu item created successfully.');
    }

    public function bulkStoreItems(Request $request, $menu)
    {
        $menu = Menu::findOrFail((int) $menu);

        $data = $request->validate([
            'bulk_lines' => 'required|string',
            'parent_id' => 'nullable|integer|exists:menu_items,id',
            'default_order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean',
            'has_sub_items' => 'nullable|boolean',
        ]);

        $parentId = $request->filled('parent_id') ? (int) $request->input('parent_id') : null;

        if (! is_null($parentId)) {
            $parentExists = MenuItem::where('menu_id', $menu->id)->where('id', $parentId)->exists();
            if (! $parentExists) {
                return redirect()->back()->withErrors(['parent_id' => 'Invalid parent item'])->withInput();
            }
        }

        $lines = preg_split('/\r\n|\r|\n/', trim($data['bulk_lines']));
        $defaultOrder = isset($data['default_order']) ? (int) $data['default_order'] : 0;
        $active = $request->has('active') ? 1 : 0;
        $hasSubItems = $request->has('has_sub_items') ? 1 : 0;

        $rows = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = array_map('trim', explode('|', $line));
            $titleEn = $parts[0] ?? '';
            $titleAr = $parts[1] ?? '';
            $href = $parts[2] ?? '#';
            $order = isset($parts[3]) && is_numeric($parts[3]) ? (int) $parts[3] : $defaultOrder;

            if ($titleEn === '' || $titleAr === '') {
                return redirect()->back()->withErrors([
                    'bulk_lines' => 'Each line must contain at least: Title EN | Title AR',
                ])->withInput();
            }

            $rows[] = [
                'menu_id' => $menu->id,
                'parent_id' => $parentId,
                'title_en' => $titleEn,
                'title_ar' => $titleAr,
                'href' => $href === '' ? '#' : $href,
                'active' => $active,
                'order' => $order,
                'has_sub_items' => $hasSubItems,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (empty($rows)) {
            return redirect()->back()->withErrors(['bulk_lines' => 'No valid lines found to insert.'])->withInput();
        }

        DB::transaction(function () use ($rows) {
            MenuItem::insert($rows);
        });

        return redirect()->to('admin/menus/'.$menu->id.'/edit')->with('success', count($rows).' menu items created successfully.');
    }

    public function editItem($menu, $item)
    {
        $menu = Menu::findOrFail((int) $menu);
        $item = MenuItem::findOrFail((int) $item);

        if ($item->menu_id !== $menu->id) {
            abort(404);
        }

        $parentOptions = $menu->items()->where('id', '!=', $item->id)->orderBy('order')->get();

        return view('admin.menus.edit-item', compact('menu', 'item', 'parentOptions'));
    }

    public function updateItem(Request $request, $menu, $item)
    {
        $menu = Menu::findOrFail((int) $menu);
        $item = MenuItem::findOrFail((int) $item);

        if ($item->menu_id !== $menu->id) {
            abort(404);
        }

        $request->merge([
            'parent_id' => $request->filled('parent_id') ? (int) $request->input('parent_id') : null,
        ]);

        $data = $request->validate([
            'parent_id' => 'nullable|integer|exists:menu_items,id',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'href' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
            'order' => 'nullable|integer|min:0',
            'has_sub_items' => 'nullable|boolean',
        ]);

        if (! empty($data['parent_id'])) {
            $parent = MenuItem::where('menu_id', $menu->id)
                ->where('id', $data['parent_id'])
                ->where('id', '!=', $item->id)
                ->first();
            if (! $parent) {
                return redirect()->back()->withErrors(['parent_id' => 'Invalid parent item'])->withInput();
            }
        }

        $data['active'] = $request->has('active') ? 1 : 0;
        $data['has_sub_items'] = $request->has('has_sub_items') ? 1 : 0;
        $data['href'] = $data['href'] ?? '#';
        $data['order'] = $data['order'] ?? 0;

        $item->update($data);

        return redirect()->to('admin/menus/'.$menu->id.'/edit')->with('success', 'Menu item updated successfully.');
    }

    public function deleteItem($menu, $item)
    {
        $menu = Menu::findOrFail((int) $menu);
        $item = MenuItem::findOrFail((int) $item);

        if ($item->menu_id !== $menu->id) {
            abort(404);
        }

        $item->delete();

        return redirect()->to('admin/menus/'.$menu->id.'/edit')->with('success', 'Menu item deleted successfully.');
    }

    public function bulkDeleteItems(Request $request, $menu)
    {
        $menu = Menu::findOrFail((int) $menu);

        $data = $request->validate([
            'item_ids' => 'required|array|min:1',
            'item_ids.*' => 'integer|exists:menu_items,id',
        ]);

        $deletedCount = MenuItem::where('menu_id', $menu->id)
            ->whereIn('id', $data['item_ids'])
            ->delete();

        return redirect()->to('admin/menus/'.$menu->id.'/edit')->with('success', $deletedCount.' menu items deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $data = $request->validate([
            'order' => 'required|array|min:1',
            'order.*' => 'integer|exists:menus,id',
        ]);

        foreach ($data['order'] as $index => $id) {
            Menu::where('id', (int) $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    public function updateItemOrder(Request $request, $menu)
    {
        $data = $request->validate([
            'order' => 'required|array|min:1',
            'order.*' => 'integer|exists:menu_items,id',
        ]);

        $menuObj = Menu::findOrFail((int) $menu);

        foreach ($data['order'] as $index => $id) {
            MenuItem::where('id', (int) $id)->where('menu_id', $menuObj->id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function exportMenusByType(string $menuType)
    {
        $menusQuery = Menu::query()->with(['items' => function ($query) {
            $query->orderBy('order')->orderBy('id');
        }])->orderBy('order')->orderBy('id');

        if ($menuType === 'mobile') {
            $menusQuery->where('menu_type', 'mobile');
        } else {
            $menusQuery->where(function ($query) {
                $query->where('menu_type', 'desktop')->orWhereNull('menu_type');
            });
        }

        $menus = $menusQuery->get();

        $payload = [
            'version' => 1,
            'menu_type' => $menuType,
            'exported_at' => now()->toDateTimeString(),
            'menus' => $menus->map(function (Menu $menu) {
                return [
                    'name' => $menu->name,
                    'title_en' => $menu->title_en,
                    'title_ar' => $menu->title_ar,
                    'href' => $menu->href,
                    'order' => (int) $menu->order,
                    'active' => (bool) $menu->active,
                    'items' => $menu->items->map(function (MenuItem $item) {
                        return [
                            'temp_id' => (int) $item->id,
                            'parent_temp_id' => $item->parent_id ? (int) $item->parent_id : null,
                            'title_en' => $item->title_en,
                            'title_ar' => $item->title_ar,
                            'href' => $item->href,
                            'order' => (int) $item->order,
                            'active' => (bool) $item->active,
                            'has_sub_items' => (bool) $item->has_sub_items,
                        ];
                    })->values()->all(),
                ];
            })->values()->all(),
        ];

        $json = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $filename = 'menus-'.$menuType.'-'.now()->format('Ymd-His').'.json';

        return response()->streamDownload(function () use ($json) {
            echo $json;
        }, $filename, [
            'Content-Type' => 'application/json; charset=UTF-8',
        ]);
    }

    private function importMenusByType(Request $request, string $expectedType)
    {
        $request->validate([
            'import_file' => 'required|file|max:5120',
            'replace_existing' => 'nullable|boolean',
        ]);

        $content = (string) file_get_contents($request->file('import_file')->getRealPath());
        $payload = json_decode($content, true);

        if (! is_array($payload)) {
            return redirect()->back()->withErrors(['import_file' => 'Invalid JSON file.'])->withInput();
        }

        if (($payload['menu_type'] ?? null) !== $expectedType) {
            return redirect()->back()->withErrors([
                'import_file' => 'This import file is for '.$payload['menu_type'].' menus, not '.$expectedType.'.',
            ])->withInput();
        }

        if (! isset($payload['menus']) || ! is_array($payload['menus'])) {
            return redirect()->back()->withErrors(['import_file' => 'Invalid import format: menus list is missing.'])->withInput();
        }

        $replaceExisting = $request->boolean('replace_existing');

        try {
            DB::transaction(function () use ($payload, $expectedType, $replaceExisting) {
                if ($replaceExisting) {
                    if ($expectedType === 'mobile') {
                        Menu::where('menu_type', 'mobile')->delete();
                    } else {
                        Menu::where(function ($query) {
                            $query->where('menu_type', 'desktop')->orWhereNull('menu_type');
                        })->delete();
                    }
                }

                foreach ($payload['menus'] as $menuData) {
                    if (! is_array($menuData)) {
                        continue;
                    }

                    $name = trim((string) ($menuData['name'] ?? ''));
                    $titleEn = trim((string) ($menuData['title_en'] ?? ''));
                    $titleAr = trim((string) ($menuData['title_ar'] ?? ''));

                    if ($name === '' || $titleEn === '' || $titleAr === '') {
                        continue;
                    }

                    $menuAttributes = [
                        'title_en' => $titleEn,
                        'title_ar' => $titleAr,
                        'href' => isset($menuData['href']) && trim((string) $menuData['href']) !== ''
                            ? (string) $menuData['href']
                            : '#',
                        'order' => isset($menuData['order']) ? max(0, (int) $menuData['order']) : 0,
                        'active' => ! empty($menuData['active']) ? 1 : 0,
                        'menu_type' => $expectedType,
                    ];

                    $menu = $this->findMenuByTypeAndName($name, $expectedType);

                    if ($menu) {
                        $menu->update($menuAttributes);
                        $menu->items()->delete();
                    } else {
                        $nameToUse = $name;
                        $nameConflict = Menu::query()->where('name', $name)->exists();

                        if ($nameConflict) {
                            $nameToUse = $this->generateSplitMenuName($name, $expectedType);
                        }

                        $menu = Menu::create(array_merge(['name' => $nameToUse], $menuAttributes));
                    }

                    $itemsData = isset($menuData['items']) && is_array($menuData['items'])
                        ? $menuData['items']
                        : [];

                    $idMap = [];
                    $pendingParentMap = [];

                    foreach ($itemsData as $itemData) {
                        if (! is_array($itemData)) {
                            continue;
                        }

                        $itemTitleEn = trim((string) ($itemData['title_en'] ?? ''));
                        $itemTitleAr = trim((string) ($itemData['title_ar'] ?? ''));

                        if ($itemTitleEn === '' || $itemTitleAr === '') {
                            continue;
                        }

                        $createdItem = MenuItem::create([
                            'menu_id' => $menu->id,
                            'parent_id' => null,
                            'title_en' => $itemTitleEn,
                            'title_ar' => $itemTitleAr,
                            'href' => isset($itemData['href']) && trim((string) $itemData['href']) !== ''
                                ? (string) $itemData['href']
                                : '#',
                            'active' => ! empty($itemData['active']) ? 1 : 0,
                            'order' => isset($itemData['order']) ? max(0, (int) $itemData['order']) : 0,
                            'has_sub_items' => ! empty($itemData['has_sub_items']) ? 1 : 0,
                        ]);

                        $tempId = isset($itemData['temp_id']) ? (int) $itemData['temp_id'] : null;
                        $parentTempId = isset($itemData['parent_temp_id']) && $itemData['parent_temp_id'] !== null
                            ? (int) $itemData['parent_temp_id']
                            : null;

                        if ($tempId) {
                            $idMap[$tempId] = $createdItem->id;
                        }

                        $pendingParentMap[$createdItem->id] = $parentTempId;
                    }

                    foreach ($pendingParentMap as $newItemId => $parentTempId) {
                        if (! $parentTempId || ! isset($idMap[$parentTempId])) {
                            continue;
                        }

                        MenuItem::where('id', $newItemId)->where('menu_id', $menu->id)->update([
                            'parent_id' => $idMap[$parentTempId],
                        ]);
                    }
                }
            });
        } catch (\Throwable $exception) {
            return redirect()->back()->withErrors([
                'import_file' => $exception->getMessage(),
            ])->withInput();
        }

        $redirectRoute = $expectedType === 'mobile' ? 'admin.menus.mobile.index' : 'admin.menus.index';

        return redirect()->route($redirectRoute)->with('success', 'Menus imported successfully.');
    }

    private function findMenuByTypeAndName(string $name, string $menuType): ?Menu
    {
        $query = Menu::query()->where('name', $name);

        if ($menuType === 'mobile') {
            $query->where('menu_type', 'mobile');
        } else {
            $query->where(function ($builder) {
                $builder->where('menu_type', 'desktop')->orWhereNull('menu_type');
            });
        }

        return $query->first();
    }

    private function generateSplitMenuName(string $baseName, string $menuType): string
    {
        $candidate = $baseName.'-'.$menuType;
        $counter = 2;

        while (Menu::query()->where('name', $candidate)->exists()) {
            $candidate = $baseName.'-'.$menuType.'-'.$counter;
            $counter++;
        }

        return $candidate;
    }
}
