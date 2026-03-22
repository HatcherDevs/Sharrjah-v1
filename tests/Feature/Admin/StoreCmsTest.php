<?php

namespace Tests\Feature\Admin;

use App\Models\CollectionCategory;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "SAT Design Store" section.
 * Covers: Store items (collections) + Collection Categories.
 */
class StoreCmsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // =========================================================================
    // Authentication guards — Store
    // =========================================================================

    public function test_unauthenticated_user_cannot_view_stores_list(): void
    {
        $this->get('/admin/stores/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_store_form(): void
    {
        $this->get('/admin/create/stores/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_item(): void
    {
        $this->post('/admin/stores/', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_store(): void
    {
        $category = CollectionCategory::create(['name' => 'Cat', 'name_ar' => 'فئة', 'order_number' => 1]);
        $store = Store::create($this->validStoreData($category->id));
        $this->get("/admin/stores/{$store->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_store(): void
    {
        $category = CollectionCategory::create(['name' => 'Cat', 'name_ar' => 'فئة', 'order_number' => 1]);
        $store = Store::create($this->validStoreData($category->id));
        $this->get("/admin/stores/{$store->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // Authentication guards — Store Categories
    // =========================================================================

    public function test_unauthenticated_user_cannot_view_categories_list(): void
    {
        $this->get('/admin/stores-category/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_category_form(): void
    {
        $this->get('/admin/stores-category/create/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_category(): void
    {
        $this->post('/admin/stores-category/store-data', ['name' => 'Hacker'])->assertRedirect('/admin/login');
    }

    // =========================================================================
    // Store items — List
    // =========================================================================

    public function test_admin_can_view_stores_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/stores/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store items — Create form
    // =========================================================================

    public function test_admin_can_view_create_store_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/stores/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store items — Store — all fields
    // =========================================================================

    public function test_admin_can_create_store_item_with_all_fields(): void
    {
        $category = CollectionCategory::create(['name' => 'Prints', 'name_ar' => 'مطبوعات', 'order_number' => 1]);

        $this->actingAs($this->admin)
            ->post('/admin/stores/', $this->validStoreData($category->id))
            ->assertRedirect();

        $this->assertDatabaseHas('stores', ['title' => 'Sharjah Architecture Print']);
    }

    public function test_creating_store_item_generates_slug(): void
    {
        $category = CollectionCategory::create(['name' => 'Books', 'name_ar' => 'كتب', 'order_number' => 2]);

        $this->actingAs($this->admin)
            ->post('/admin/stores/', $this->validStoreData($category->id, ['title' => 'Store Slug Test Item']));

        $this->assertDatabaseHas('stores', ['slug' => 'store-slug-test-item']);
    }

    // =========================================================================
    // Store items — Edit form
    // =========================================================================

    public function test_admin_can_view_edit_store_form(): void
    {
        $category = CollectionCategory::create(['name' => 'Cat', 'name_ar' => 'فئة', 'order_number' => 1]);
        $store = Store::create($this->validStoreData($category->id));

        $this->actingAs($this->admin)
            ->get("/admin/stores/{$store->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Store items — Update
    // =========================================================================

    public function test_admin_can_update_store_item_with_all_fields(): void
    {
        $category = CollectionCategory::create(['name' => 'Cat', 'name_ar' => 'فئة', 'order_number' => 1]);
        $store = Store::create($this->validStoreData($category->id, ['title' => 'Old Store Item']));

        $this->actingAs($this->admin)
            ->post('/admin/stores/update', array_merge($this->validStoreData($category->id), [
                'id'    => $store->id,
                'title' => 'Updated Store Item',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('stores', [
            'id'    => $store->id,
            'title' => 'Updated Store Item',
        ]);
    }

    // =========================================================================
    // Store items — Delete
    // =========================================================================

    public function test_admin_can_delete_store_item(): void
    {
        $category = CollectionCategory::create(['name' => 'Cat', 'name_ar' => 'فئة', 'order_number' => 1]);
        $store = Store::create($this->validStoreData($category->id));

        $this->actingAs($this->admin)
            ->get("/admin/stores/{$store->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('stores', ['id' => $store->id]);
    }

    // =========================================================================
    // Collection Categories — List, Create, Store, Edit, Update, Delete
    // =========================================================================

    public function test_admin_can_view_categories_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/stores-category/')
            ->assertStatus(200);
    }

    public function test_admin_can_view_create_category_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/stores-category/create/')
            ->assertStatus(200);
    }

    public function test_admin_can_create_category_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/stores-category/store-data', [
                'name'         => 'Posters',
                'name_ar'      => 'ملصقات',
                'order_number' => 3,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('collection_categories', ['name' => 'Posters']);
    }

    public function test_admin_can_view_edit_category_form(): void
    {
        $category = CollectionCategory::create(['name' => 'Test Cat', 'name_ar' => 'فئة تجريبية', 'order_number' => 1]);

        $this->actingAs($this->admin)
            ->get("/admin/stores-category/{$category->id}/edit")
            ->assertStatus(200);
    }

    public function test_admin_can_update_category(): void
    {
        $category = CollectionCategory::create(['name' => 'Old Cat', 'name_ar' => 'فئة قديمة', 'order_number' => 1]);

        // Use a different order_number to avoid the unique constraint on that column
        $this->actingAs($this->admin)
            ->post('/admin/stores-category/update', [
                'id'           => $category->id,
                'name'         => 'Updated Category',
                'name_ar'      => 'فئة محدثة',
                'order_number' => 99,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('collection_categories', [
            'id'   => $category->id,
            'name' => 'Updated Category',
        ]);
    }

    public function test_admin_can_delete_category(): void
    {
        $category = CollectionCategory::create(['name' => 'To Delete', 'name_ar' => 'للحذف', 'order_number' => 1]);

        $this->actingAs($this->admin)
            ->get("/admin/stores-category/{$category->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('collection_categories', ['id' => $category->id]);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** @return array<string, mixed> */
    private function validStoreData(int $collectionId, array $overrides = []): array
    {
        return array_merge([
            'title'          => 'Sharjah Architecture Print',
            'title_ar'       => 'طباعة عمارة الشارقة',
            'excerpt'        => 'Limited edition print',
            'excerpt_ar'     => 'طباعة محدودة',
            'artist'         => 'Jane Doe',
            'artist_ar'      => 'جين دو',
            'country'        => 'UAE',
            'country_ar'     => 'الإمارات',
            'description'    => 'Item description',
            'description_ar' => 'وصف العنصر',
            'slug'           => 'sharjah-architecture-print',
            'publish_date'   => '2024-05-01',
            'content'        => '<p>Item content</p>',
            'content_ar'     => '<p>محتوى العنصر</p>',
            'active'         => 1,
            'collection_id'  => $collectionId,
        ], $overrides);
    }
}