<?php

namespace Tests\Feature\Admin;

use App\Models\PressKit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "Press Kits" section.
 *
 * PressKits have username/password-based access control.
 */
class PresskitsCmsTest extends TestCase
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

    public function test_unauthenticated_user_cannot_view_presskits_list(): void
    {
        $this->get('/admin/presskits/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_presskit_form(): void
    {
        $this->get('/admin/create/presskits/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_presskit(): void
    {
        $this->post('/admin/presskits/', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_presskit(): void
    {
        $kit = PressKit::create($this->validData());
        $this->get("/admin/presskits/{$kit->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_presskit(): void
    {
        $kit = PressKit::create($this->validData());
        $this->get("/admin/presskits/{$kit->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // List
    // =========================================================================

    public function test_admin_can_view_presskits_list(): void
    {
        PressKit::create($this->validData());

        $this->actingAs($this->admin)
            ->get('/admin/presskits/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Create form
    // =========================================================================

    public function test_admin_can_view_create_presskit_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/presskits/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store — all fields
    // =========================================================================

    public function test_admin_can_create_presskit_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/presskits/', $this->validData())
            ->assertRedirect();

        $this->assertDatabaseHas('press_kits', ['title' => 'SAT 2024 Press Kit']);
    }

    public function test_creating_presskit_with_duplicate_username_redirects_with_error(): void
    {
        PressKit::create($this->validData());

        // Attempt to create another with the same username
        $this->actingAs($this->admin)
            ->post('/admin/presskits/', $this->validData())
            ->assertRedirect();

        // Should only have one in DB since the controller blocks duplicates
        $this->assertDatabaseCount('press_kits', 1);
    }

    // =========================================================================
    // Edit form
    // =========================================================================

    public function test_admin_can_view_edit_presskit_form(): void
    {
        $kit = PressKit::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/presskits/{$kit->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Update — all fields
    // =========================================================================

    public function test_admin_can_update_presskit_with_all_fields(): void
    {
        $kit = PressKit::create($this->validData(['title' => 'Old Kit']));

        $this->actingAs($this->admin)
            ->post('/admin/presskits/update', array_merge($this->validData(), [
                'id'    => $kit->id,
                'title' => 'Updated Press Kit',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('press_kits', [
            'id'    => $kit->id,
            'title' => 'Updated Press Kit',
        ]);
    }

    // =========================================================================
    // Delete
    // =========================================================================

    public function test_admin_can_delete_presskit(): void
    {
        $kit = PressKit::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/presskits/{$kit->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('press_kits', ['id' => $kit->id]);
    }

    public function test_deleting_nonexistent_presskit_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/presskits/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** @return array<string, mixed> */
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title'          => 'SAT 2024 Press Kit',
            'title_ar'       => 'ملف الصحافة 2024',
            'description'    => 'Official press kit',
            'description_ar' => 'ملف الصحافة الرسمي',
            'username'       => 'press2024',
            'password'       => 'securepass',
            'slug'           => 'sat-2024-press-kit',
            'publish_date'   => '2024-01-01',
        ], $overrides);
    }
}