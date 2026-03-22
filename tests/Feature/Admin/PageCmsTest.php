<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageCmsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
    }

    // =========================================================================
    // Authentication guards
    // =========================================================================

    public function test_unauthenticated_user_cannot_access_pages_list(): void
    {
        $this->get('/admin/web-pages')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_access_create_page(): void
    {
        $this->get('/admin/create/web-pages')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_post_create_page(): void
    {
        $this->post('/admin/pages', ['name' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_page(): void
    {
        $page = Page::factory()->create();

        $this->get("/admin/pages/{$page->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // Admin – list
    // =========================================================================

    public function test_admin_can_view_pages_list(): void
    {
        Page::factory()->count(3)->create();

        $this->actingAs($this->admin)
            ->get('/admin/web-pages')
            ->assertStatus(200);
    }

    // =========================================================================
    // Admin – create
    // =========================================================================

    public function test_admin_can_view_create_page_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/web-pages')
            ->assertStatus(200);
    }

    public function test_admin_can_create_a_new_page(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/pages', [
                'name' => 'Test Page',
                'name_ar' => 'صفحة تجريبية',
                'page_type' => 'content',
                'active' => 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('pages', ['name' => 'Test Page']);
    }

    public function test_creating_page_generates_slug_from_name(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/pages', [
                'name' => 'My New Page',
                'name_ar' => 'صفحة جديدة',
                'page_type' => 'content',
                'active' => 1,
            ]);

        $this->assertDatabaseHas('pages', ['slug' => 'my-new-page']);
    }

    // =========================================================================
    // Admin – edit / update
    // =========================================================================

    public function test_admin_can_view_edit_page_form(): void
    {
        $page = Page::factory()->create();

        $this->actingAs($this->admin)
            ->get("/admin/web-pages/{$page->id}/edit")
            ->assertStatus(200);
    }

    public function test_admin_can_update_a_page(): void
    {
        $page = Page::factory()->create(['name' => 'Old Name']);

        $this->actingAs($this->admin)
            ->post('/admin/pages/update', [
                'id' => $page->id,
                'name' => 'Updated Name',
                'name_ar' => $page->name_ar,
                'page_type' => $page->page_type,
                'active' => 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'name' => 'Updated Name',
        ]);
    }

    public function test_updating_nonexistent_page_returns_404(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/pages/update', [
                'id' => 999999,
                'name' => 'Ghost Page',
                'page_type' => 'content',
            ])
            ->assertStatus(404);
    }

    // =========================================================================
    // Admin – delete
    // =========================================================================

    public function test_admin_can_delete_a_page(): void
    {
        $page = Page::factory()->create();

        $this->actingAs($this->admin)
            ->get("/admin/pages/{$page->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }

    public function test_deleting_nonexistent_page_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/pages/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Frontend – public page rendering
    // =========================================================================

    public function test_frontend_renders_active_page(): void
    {
        $page = Page::factory()->create([
            'slug' => 'test-frontend-page',
            'page_type' => 'content',
            'active' => 1,
        ]);

        $this->get("/pages/{$page->slug}")->assertStatus(200);
    }

    public function test_frontend_returns_404_for_nonexistent_page(): void
    {
        $this->get('/pages/this-page-does-not-exist')->assertStatus(404);
    }

    public function test_frontend_renders_main_page_with_children_menu(): void
    {
        $parent = Page::factory()->create([
            'slug' => 'about',
            'page_type' => 'main',
            'active' => 1,
        ]);

        $child = Page::factory()->create([
            'slug' => 'mission',
            'page_type' => 'content',
            'active' => 1,
        ]);

        $parent->children()->attach($child->id);

        $this->get('/pages/about')->assertStatus(200);
    }

    // =========================================================================
    // Inactive / soft-delete edge cases
    // =========================================================================

    public function test_inactive_page_content_is_not_shown_in_parent_menu(): void
    {
        $parent = Page::factory()->create([
            'slug' => 'programmes',
            'page_type' => 'main',
            'active' => 1,
        ]);

        $inactive = Page::factory()->create([
            'name' => 'Hidden Child',
            'slug' => 'hidden-child',
            'page_type' => 'content',
            'active' => 0,
        ]);

        $parent->children()->attach($inactive->id);

        $this->get('/pages/programmes')
            ->assertStatus(200)
            ->assertDontSee('Hidden Child');
    }
}