<?php

namespace Tests\Feature\Admin;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "Publications" section.
 */
class PublicationsCmsTest extends TestCase
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

    public function test_unauthenticated_user_cannot_view_publications_list(): void
    {
        $this->get('/admin/publications/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_publication_form(): void
    {
        $this->get('/admin/create/publications/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_publication(): void
    {
        $this->post('/admin/publications/', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_publication(): void
    {
        $pub = Publication::create($this->validData());
        $this->get("/admin/publications/{$pub->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_publication(): void
    {
        $pub = Publication::create($this->validData());
        $this->get("/admin/publications/{$pub->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // List
    // =========================================================================

    public function test_admin_can_view_publications_list(): void
    {
        Publication::create($this->validData());

        $this->actingAs($this->admin)
            ->get('/admin/publications/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Create form
    // =========================================================================

    public function test_admin_can_view_create_publication_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/publications/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store — all fields
    // =========================================================================

    public function test_admin_can_create_publication_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/publications/', $this->validData())
            ->assertRedirect();

        $this->assertDatabaseHas('publications', ['title' => 'SAT Annual Report']);
    }

    public function test_creating_publication_generates_slug_from_title(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/publications/', $this->validData(['title' => 'Slug Generation Test']));

        $this->assertDatabaseHas('publications', ['slug' => 'slug-generation-test']);
    }

    // =========================================================================
    // Edit form
    // =========================================================================

    public function test_admin_can_view_edit_publication_form(): void
    {
        $pub = Publication::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/publications/{$pub->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Update — all fields
    // =========================================================================

    public function test_admin_can_update_publication_with_all_fields(): void
    {
        $pub = Publication::create($this->validData(['title' => 'Old Publication']));

        $this->actingAs($this->admin)
            ->post('/admin/publications/update', array_merge($this->validData(), [
                'id'    => $pub->id,
                'title' => 'Updated Publication Title',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('publications', [
            'id'    => $pub->id,
            'title' => 'Updated Publication Title',
        ]);
    }

    // =========================================================================
    // Delete
    // =========================================================================

    public function test_admin_can_delete_publication(): void
    {
        $pub = Publication::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/publications/{$pub->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('publications', ['id' => $pub->id]);
    }

    public function test_deleting_nonexistent_publication_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/publications/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** @return array<string, mixed> */
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title'          => 'SAT Annual Report',
            'title_ar'       => 'تقرير سنوي',
            'excerpt'        => 'A brief excerpt',
            'excerpt_ar'     => 'مقطع مختصر',
            'author'         => 'John Doe',
            'author_ar'      => 'جون دو',
            'publication'    => 'SAT Press',
            'publication_ar' => 'مطبوعات سات',
            'description'    => 'Full description',
            'description_ar' => 'وصف كامل',
            'slug'           => 'sat-annual-report',
            'publish_date'   => '2024-01-01',
            'content'        => '<p>Content here</p>',
            'content_ar'     => '<p>المحتوى هنا</p>',
            'active'         => 1,
        ], $overrides);
    }
}