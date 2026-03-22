<?php

namespace Tests\Feature\Admin;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "SAT Tours" section.
 */
class ToursCmsTest extends TestCase
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

    public function test_unauthenticated_user_cannot_view_tours_list(): void
    {
        $this->get('/admin/tours/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_tour_form(): void
    {
        $this->get('/admin/create/tours/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_tour(): void
    {
        $this->post('/admin/tours/', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_tour(): void
    {
        $tour = Tour::create($this->validData());
        $this->get("/admin/tours/{$tour->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_tour(): void
    {
        $tour = Tour::create($this->validData());
        $this->get("/admin/tours/{$tour->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // List
    // =========================================================================

    public function test_admin_can_view_tours_list(): void
    {
        Tour::create($this->validData());

        $this->actingAs($this->admin)
            ->get('/admin/tours/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Create form
    // =========================================================================

    public function test_admin_can_view_create_tour_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/tours/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store — all fields
    // =========================================================================

    public function test_admin_can_create_tour_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/tours/', $this->validData())
            ->assertRedirect();

        $this->assertDatabaseHas('tours', ['title' => 'Heritage Architecture Tour']);
    }

    public function test_creating_tour_generates_slug_from_title(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/tours/', $this->validData(['title' => 'Tour Slug Test']));

        $this->assertDatabaseHas('tours', ['slug' => 'tour-slug-test']);
    }

    // =========================================================================
    // Edit form
    // =========================================================================

    public function test_admin_can_view_edit_tour_form(): void
    {
        $tour = Tour::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/tours/{$tour->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Update — all fields
    // =========================================================================

    public function test_admin_can_update_tour_with_all_fields(): void
    {
        $tour = Tour::create($this->validData(['title' => 'Old Tour']));

        $this->actingAs($this->admin)
            ->post('/admin/tours/update', array_merge($this->validData(), [
                'id'    => $tour->id,
                'title' => 'Updated Tour Title',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('tours', [
            'id'    => $tour->id,
            'title' => 'Updated Tour Title',
        ]);
    }

    // =========================================================================
    // Delete
    // =========================================================================

    public function test_admin_can_delete_tour(): void
    {
        $tour = Tour::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/tours/{$tour->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('tours', ['id' => $tour->id]);
    }

    public function test_deleting_nonexistent_tour_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/tours/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** @return array<string, mixed> */
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title'          => 'Heritage Architecture Tour',
            'title_ar'       => 'جولة عمارة التراث',
            'excerpt'        => 'Tour excerpt',
            'excerpt_ar'     => 'مستخلص الجولة',
            'description'    => 'Tour description',
            'description_ar' => 'وصف الجولة',
            'slug'           => 'heritage-architecture-tour',
            'publish_date'   => '2024-04-01',
            'content'        => '<p>Tour details</p>',
            'content_ar'     => '<p>تفاصيل الجولة</p>',
            'active'         => 1,
        ], $overrides);
    }
}