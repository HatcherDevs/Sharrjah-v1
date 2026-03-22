<?php

namespace Tests\Feature\Admin;

use App\Models\Space;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "Al Manakh Spaces" section.
 */
class SpacesCmsTest extends TestCase
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

    public function test_unauthenticated_user_cannot_view_spaces_list(): void
    {
        $this->get('/admin/spaces/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_space_form(): void
    {
        $this->get('/admin/create/spaces/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_space(): void
    {
        $this->post('/admin/spaces/', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_space(): void
    {
        $space = Space::create($this->validData());
        $this->get("/admin/spaces/{$space->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_space(): void
    {
        $space = Space::create($this->validData());
        $this->get("/admin/spaces/{$space->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // List
    // =========================================================================

    public function test_admin_can_view_spaces_list(): void
    {
        Space::create($this->validData());

        $this->actingAs($this->admin)
            ->get('/admin/spaces/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Create form
    // =========================================================================

    public function test_admin_can_view_create_space_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/spaces/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store — all fields
    // =========================================================================

    public function test_admin_can_create_space_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/spaces/', $this->validData())
            ->assertRedirect();

        $this->assertDatabaseHas('spaces', ['title' => 'Al Manakh Gallery']);
    }

    public function test_creating_space_generates_slug_from_title(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/spaces/', $this->validData(['title' => 'Space Slug Test']));

        $this->assertDatabaseHas('spaces', ['slug' => 'space-slug-test']);
    }

    // =========================================================================
    // Edit form
    // =========================================================================

    public function test_admin_can_view_edit_space_form(): void
    {
        $space = Space::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/spaces/{$space->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Update — all fields
    // =========================================================================

    public function test_admin_can_update_space_with_all_fields(): void
    {
        $space = Space::create($this->validData(['title' => 'Old Space']));

        $this->actingAs($this->admin)
            ->post('/admin/spaces/update', array_merge($this->validData(), [
                'id'    => $space->id,
                'title' => 'Updated Space Title',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('spaces', [
            'id'    => $space->id,
            'title' => 'Updated Space Title',
        ]);
    }

    // =========================================================================
    // Delete
    // =========================================================================

    public function test_admin_can_delete_space(): void
    {
        $space = Space::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/spaces/{$space->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('spaces', ['id' => $space->id]);
    }

    public function test_deleting_nonexistent_space_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/spaces/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** @return array<string, mixed> */
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title'          => 'Al Manakh Gallery',
            'title_ar'       => 'غاليري المنخ',
            'excerpt'        => 'A creative space',
            'excerpt_ar'     => 'مساحة إبداعية',
            'speaker'        => 'Curator Name',
            'speaker_ar'     => 'اسم القيّم',
            'series'         => 'Series A',
            'series_ar'      => 'سلسلة أ',
            'country'        => 'UAE',
            'country_ar'     => 'الإمارات',
            'description'    => 'Space description',
            'description_ar' => 'وصف المساحة',
            'slug'           => 'al-manakh-gallery',
            'publish_date'   => '2024-03-01',
            'content'        => '<p>Space details</p>',
            'content_ar'     => '<p>تفاصيل المساحة</p>',
            'active'         => 1,
        ], $overrides);
    }
}