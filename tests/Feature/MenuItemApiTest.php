<?php

namespace Tests\Feature;

use App\Models\MenuItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuItemApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_listing_returns_paginated_items_and_empty_collection(): void
    {
        $this->getJson('/api/menu-items')->assertOk()->assertJsonPath('data', [])->assertJsonStructure(['data', 'links', 'meta']);
        MenuItem::factory()->count(2)->create();
        $this->getJson('/api/menu-items?per_page=1')->assertOk()->assertJsonCount(1, 'data')->assertJsonStructure(['data' => [['id', 'name', 'price', 'is_available']], 'meta']);
    }

    public function test_show_returns_existing_item_and_a_clear_json_404(): void
    {
        $item = MenuItem::factory()->create();
        $this->getJson("/api/menu-items/{$item->id}")->assertOk()->assertJsonPath('data.id', $item->id);
        $this->getJson('/api/menu-items/99999')->assertNotFound()->assertJsonPath('message', 'El elemento del menú no existe.');
    }

    public function test_create_validates_fields_and_ignores_unapproved_attributes(): void
    {
        $payload = $this->validPayload() + ['is_admin' => true];
        $response = $this->postJson('/api/menu-items', $payload)->assertCreated()->assertJsonPath('data.price', '15.50');
        $this->assertDatabaseHas('menu_items', ['id' => $response->json('data.id'), 'name' => 'Salmón al limón']);
        $this->assertDatabaseMissing('menu_items', ['id' => $response->json('data.id'), 'is_admin' => true]);
        $this->postJson('/api/menu-items', [])->assertUnprocessable()->assertJsonPath('message', 'Los datos proporcionados no son válidos.')->assertJsonValidationErrors(['name', 'description', 'price', 'category', 'is_available']);
        $this->postJson('/api/menu-items', $this->validPayload(['price' => -1]))->assertUnprocessable()->assertJsonValidationErrors('price');
        $this->postJson('/api/menu-items', $this->validPayload(['category' => 'sopas']))->assertUnprocessable()->assertJsonValidationErrors('category');
        $this->postJson('/api/menu-items', $this->validPayload(['is_available' => 'maybe']))->assertUnprocessable()->assertJsonValidationErrors('is_available');
        $this->postJson('/api/menu-items', $this->validPayload(['price' => '1.999']))->assertUnprocessable()->assertJsonValidationErrors('price');
    }

    public function test_put_requires_all_fields_and_updates_existing_record(): void
    {
        $item = MenuItem::factory()->create();
        $this->putJson("/api/menu-items/{$item->id}", $this->validPayload(['name' => 'Risotto de hongos']))->assertOk()->assertJsonPath('data.name', 'Risotto de hongos');
        $this->putJson("/api/menu-items/{$item->id}", ['name' => 'Incompleto'])->assertUnprocessable()->assertJsonValidationErrors(['price', 'category']);
        $this->putJson('/api/menu-items/99999', $this->validPayload())->assertNotFound();
    }

    public function test_patch_changes_only_submitted_fields(): void
    {
        $item = MenuItem::factory()->create(['name' => 'Original', 'price' => '12.00', 'is_available' => true]);
        $this->patchJson("/api/menu-items/{$item->id}", ['price' => '18.25'])->assertOk()->assertJsonPath('data.price', '18.25')->assertJsonPath('data.name', 'Original');
        $this->patchJson("/api/menu-items/{$item->id}", ['is_available' => false])->assertOk()->assertJsonPath('data.is_available', false)->assertJsonPath('data.name', 'Original');
        $this->patchJson("/api/menu-items/{$item->id}", ['price' => -4])->assertUnprocessable()->assertJsonValidationErrors('price');
    }

    public function test_delete_removes_record_and_returns_204(): void
    {
        $item = MenuItem::factory()->create();
        $this->deleteJson("/api/menu-items/{$item->id}")->assertNoContent();
        $this->assertDatabaseMissing('menu_items', ['id' => $item->id]);
        $this->deleteJson('/api/menu-items/99999')->assertNotFound();
    }

    public function test_category_filter_returns_only_matching_items_or_empty_collection(): void
    {
        MenuItem::factory()->create(['category' => 'entradas']);
        MenuItem::factory()->create(['category' => 'postres']);
        $this->getJson('/api/menu-items/category/entradas')->assertOk()->assertJsonCount(1, 'data')->assertJsonPath('data.0.category', 'entradas');
        $this->getJson('/api/menu-items/category/bebidas')->assertOk()->assertJsonCount(0, 'data');
        $this->getJson('/api/menu-items/category/inexistente')->assertUnprocessable();
    }

    public function test_api_errors_remain_json_and_wrong_method_returns_405(): void
    {
        $this->get('/api/menu-items/99999', ['Accept' => 'text/html'])->assertNotFound()->assertHeader('content-type', 'application/json');
        $this->putJson('/api/menu-items', [])->assertStatus(405)->assertHeader('content-type', 'application/json');
    }

    private function validPayload(array $overrides = []): array
    {
        return array_replace([
            'name' => 'Salmón al limón',
            'description' => 'Salmón a la plancha con vegetales.',
            'price' => '15.50',
            'category' => 'platos-fuertes',
            'is_available' => true,
        ], $overrides);
    }
}
