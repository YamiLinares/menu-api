<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Http\Requests\UpdateMenuItemRequest;
use App\Http\Resources\MenuItemResource;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MenuItemController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min(max((int) $request->integer('per_page', 12), 1), 100);

        return MenuItemResource::collection(MenuItem::query()->orderBy('category')->orderBy('name')->paginate($perPage));
    }

    public function store(StoreMenuItemRequest $request): JsonResponse
    {
        $item = MenuItem::create($request->validated());

        return (new MenuItemResource($item))->response()->setStatusCode(201);
    }

    public function show(MenuItem $menuItem): MenuItemResource
    {
        return new MenuItemResource($menuItem);
    }

    public function update(UpdateMenuItemRequest $request, MenuItem $menuItem): MenuItemResource
    {
        $menuItem->update($request->validated());

        return new MenuItemResource($menuItem->refresh());
    }

    public function destroy(MenuItem $menuItem): JsonResponse
    {
        $menuItem->delete();

        return response()->json(null, 204);
    }

    public function category(string $category): AnonymousResourceCollection|JsonResponse
    {
        if (! in_array($category, MenuItem::CATEGORIES, true)) {
            return response()->json(['message' => 'La categoría solicitada no es válida.', 'categories' => MenuItem::CATEGORIES], 422);
        }

        return MenuItemResource::collection(MenuItem::query()->where('category', $category)->orderBy('name')->paginate(100));
    }
}
