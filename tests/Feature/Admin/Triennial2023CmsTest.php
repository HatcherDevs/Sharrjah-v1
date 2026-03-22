<?php

namespace Tests\Feature\Admin;

use App\Models\Triennial2023;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "Triennial 2023" section.
 */
class Triennial2023CmsTest extends TestCase
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

    public function test_unauthenticated_user_cannot_view_triennial_list(): void
    {
        $this->get('/admin/triennial-2023/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_triennial_form(): void
    {
        $this->get('/admin/create/triennial-2023/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_triennial(): void
    {
        $this->post('/admin/triennial-2023/', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_triennial(): void
    {
        $event = Triennial2023::create($this->validData());
        $this->get("/admin/triennial-2023/{$event->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_triennial(): void
    {
        $event = Triennial2023::create($this->validData());
        $this->get("/admin/triennial-2023/{$event->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // List
    // =========================================================================

    public function test_admin_can_view_triennial_list(): void
    {
        Triennial2023::create($this->validData());

        $this->actingAs($this->admin)
            ->get('/admin/triennial-2023/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Create form
    // =========================================================================

    public function test_admin_can_view_create_triennial_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/triennial-2023/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store — all fields
    // =========================================================================

    public function test_admin_can_create_triennial_event_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/triennial-2023/', $this->validData())
            ->assertRedirect();

        $this->assertDatabaseHas('triennial2023s', ['title' => 'Opening Ceremony 2023']);
    }

    public function test_creating_triennial_event_generates_slug(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/triennial-2023/', $this->validData(['title' => 'Triennial Slug Event']));

        $this->assertDatabaseHas('triennial2023s', ['slug' => 'triennial-slug-event']);
    }

    // =========================================================================
    // Edit form
    // =========================================================================

    public function test_admin_can_view_edit_triennial_form(): void
    {
        $event = Triennial2023::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/triennial-2023/{$event->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Update — all fields
    // =========================================================================

    public function test_admin_can_update_triennial_event_with_all_fields(): void
    {
        $event = Triennial2023::create($this->validData(['title' => 'Old Event']));

        $this->actingAs($this->admin)
            ->post('/admin/triennial-2023/update', array_merge($this->validData(), [
                'id'    => $event->id,
                'title' => 'Updated Triennial Event',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('triennial2023s', [
            'id'    => $event->id,
            'title' => 'Updated Triennial Event',
        ]);
    }

    // =========================================================================
    // Delete
    // =========================================================================

    public function test_admin_can_delete_triennial_event(): void
    {
        $event = Triennial2023::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/triennial-2023/{$event->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('triennial2023s', ['id' => $event->id]);
    }

    public function test_deleting_nonexistent_triennial_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/triennial-2023/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** @return array<string, mixed> */
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title'          => 'Opening Ceremony 2023',
            'title_ar'       => 'حفل الافتتاح 2023',
            'excerpt'        => 'Opening event excerpt',
            'excerpt_ar'     => 'مستخلص حدث الافتتاح',
            'speaker'        => 'Guest Speaker',
            'speaker_ar'     => 'ضيف شرف',
            'series'         => 'Main Events',
            'series_ar'      => 'الفعاليات الرئيسية',
            'country'        => 'UAE',
            'country_ar'     => 'الإمارات',
            'description'    => 'Event description',
            'description_ar' => 'وصف الفعالية',
            'slug'           => 'opening-ceremony-2023',
            'publish_date'   => '2023-11-01',
            'content'        => '<p>Event content</p>',
            'content_ar'     => '<p>محتوى الفعالية</p>',
            'active'         => 1,
        ], $overrides);
    }
}