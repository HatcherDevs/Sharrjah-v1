<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "Contributors" section.
 *
 * Contributors are Posts linked to the page with slug = 'contributors'.
 */
class ContributorsCmsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Page $contributorsPage;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();

        $this->contributorsPage = Page::factory()->create([
            'name'      => 'Contributors',
            'name_ar'   => 'المساهمون',
            'slug'      => 'contributors',
            'page_type' => 'list',
            'active'    => 1,
        ]);
    }

    // =========================================================================
    // Authentication guards
    // =========================================================================

    public function test_unauthenticated_user_cannot_view_contributors_list(): void
    {
        $this->get('/admin/posts/contributors')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_contributor_form(): void
    {
        $this->get('/admin/create/contributors')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_contributor(): void
    {
        $this->post('/admin/create/contributors', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_contributor(): void
    {
        $post = Post::factory()->create(['page_id' => $this->contributorsPage->id]);
        $this->get("/admin/contributors/{$post->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_contributor(): void
    {
        $post = Post::factory()->create(['page_id' => $this->contributorsPage->id]);
        $this->get("/admin/posts/{$post->id}/delete")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_order_form(): void
    {
        $this->get('/admin/contributors/order')->assertRedirect('/admin/login');
    }

    // =========================================================================
    // List
    // =========================================================================

    public function test_admin_can_view_contributors_list(): void
    {
        Post::factory()->count(3)->create(['page_id' => $this->contributorsPage->id]);

        $this->actingAs($this->admin)
            ->get('/admin/posts/contributors')
            ->assertStatus(200);
    }

    // =========================================================================
    // Create form
    // =========================================================================

    public function test_admin_can_view_create_contributor_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/contributors')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store
    // =========================================================================

    public function test_admin_can_create_contributor_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/create/contributors', [
                'page_id'        => $this->contributorsPage->id,
                'title'          => 'John Architect',
                'title_ar'       => 'جون المعماري',
                'description'    => 'A leading architect',
                'description_ar' => 'معماري بارز',
                'content'        => '<p>Full bio here</p>',
                'content_ar'     => '<p>السيرة الذاتية الكاملة</p>',
                'publish_date'   => '2024-01-15',
                'active'         => 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title'   => 'John Architect',
            'page_id' => $this->contributorsPage->id,
        ]);
    }

    public function test_creating_contributor_generates_slug_from_title(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/create/contributors', [
                'page_id'      => $this->contributorsPage->id,
                'title'        => 'Slug Test Contributor',
                'title_ar'     => 'مساهم اختبار',
                'publish_date' => '2024-01-01',
                'active'       => 1,
            ]);

        $this->assertDatabaseHas('posts', ['slug' => 'slug-test-contributor']);
    }

    // =========================================================================
    // Edit form
    // =========================================================================

    public function test_admin_can_view_edit_contributor_form(): void
    {
        $post = Post::factory()->create(['page_id' => $this->contributorsPage->id]);

        $this->actingAs($this->admin)
            ->get("/admin/contributors/{$post->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Update
    // =========================================================================

    public function test_admin_can_update_contributor_with_all_fields(): void
    {
        $post = Post::factory()->create([
            'page_id' => $this->contributorsPage->id,
            'title'   => 'Old Name',
        ]);

        $this->actingAs($this->admin)
            ->post('/admin/update/contributors', [
                'id'             => $post->id,
                'page_id'        => $this->contributorsPage->id,
                'title'          => 'Updated Name',
                'title_ar'       => 'اسم محدث',
                'description'    => 'Updated bio',
                'description_ar' => 'سيرة ذاتية محدثة',
                'content'        => '<p>Updated content</p>',
                'content_ar'     => '<p>محتوى محدث</p>',
                'publish_date'   => '2024-06-01',
                'active'         => 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => 'Updated Name',
        ]);
    }

    // =========================================================================
    // Delete
    // =========================================================================

    public function test_admin_can_delete_contributor(): void
    {
        $post = Post::factory()->create(['page_id' => $this->contributorsPage->id]);

        $this->actingAs($this->admin)
            ->get("/admin/posts/{$post->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_deleting_nonexistent_contributor_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Order form
    // =========================================================================

    public function test_admin_can_view_contributors_order_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/contributors/order')
            ->assertStatus(200);
    }
}