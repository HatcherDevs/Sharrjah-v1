<?php

namespace Tests\Feature\Admin;

use App\Models\Podcast;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "Architecture+ Podcasts" section.
 */
class PodcastsCmsTest extends TestCase
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

    public function test_unauthenticated_user_cannot_view_podcasts_list(): void
    {
        $this->get('/admin/podcasts/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_podcast_form(): void
    {
        $this->get('/admin/create/podcasts/')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_podcast(): void
    {
        $this->post('/admin/podcasts/', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_podcast(): void
    {
        $podcast = Podcast::create($this->validData());
        $this->get("/admin/podcasts/{$podcast->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_podcast(): void
    {
        $podcast = Podcast::create($this->validData());
        $this->get("/admin/podcasts/{$podcast->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // List
    // =========================================================================

    public function test_admin_can_view_podcasts_list(): void
    {
        Podcast::create($this->validData());

        $this->actingAs($this->admin)
            ->get('/admin/podcasts/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Create form
    // =========================================================================

    public function test_admin_can_view_create_podcast_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/create/podcasts/')
            ->assertStatus(200);
    }

    // =========================================================================
    // Store — all fields
    // =========================================================================

    public function test_admin_can_create_podcast_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/podcasts/', $this->validData())
            ->assertRedirect();

        $this->assertDatabaseHas('podcasts', ['title' => 'Episode 1: Future of Architecture']);
    }

    public function test_creating_podcast_generates_slug_from_title(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/podcasts/', $this->validData(['title' => 'Podcast Slug Test Episode']));

        $this->assertDatabaseHas('podcasts', ['slug' => 'podcast-slug-test-episode']);
    }

    // =========================================================================
    // Edit form
    // =========================================================================

    public function test_admin_can_view_edit_podcast_form(): void
    {
        $podcast = Podcast::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/podcasts/{$podcast->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Update — all fields
    // =========================================================================

    public function test_admin_can_update_podcast_with_all_fields(): void
    {
        $podcast = Podcast::create($this->validData(['title' => 'Old Episode']));

        $this->actingAs($this->admin)
            ->post('/admin/podcasts/update', array_merge($this->validData(), [
                'id'      => $podcast->id,
                'title'   => 'Updated Episode Title',
                'active'  => 1,
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('podcasts', [
            'id'    => $podcast->id,
            'title' => 'Updated Episode Title',
        ]);
    }

    // =========================================================================
    // Delete
    // =========================================================================

    public function test_admin_can_delete_podcast(): void
    {
        $podcast = Podcast::create($this->validData());

        $this->actingAs($this->admin)
            ->get("/admin/podcasts/{$podcast->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('podcasts', ['id' => $podcast->id]);
    }

    public function test_deleting_nonexistent_podcast_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/podcasts/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** @return array<string, mixed> */
    private function validData(array $overrides = []): array
    {
        return array_merge([
            'title'          => 'Episode 1: Future of Architecture',
            'title_ar'       => 'الحلقة 1: مستقبل العمارة',
            'excerpt'        => 'A brief excerpt about this episode',
            'excerpt_ar'     => 'مقتطف مختصر عن هذه الحلقة',
            'speaker'        => 'Dr. Jane Smith',
            'speaker_ar'     => 'د. جين سميث',
            'series'         => 'Season 1',
            'series_ar'      => 'الموسم 1',
            'country'        => 'UAE',
            'country_ar'     => 'الإمارات',
            'description'    => 'Episode description',
            'description_ar' => 'وصف الحلقة',
            'slug'           => 'episode-1-future-of-architecture',
            'publish_date'   => '2024-02-01',
            'content'        => '<p>Full episode notes</p>',
            'content_ar'     => '<p>ملاحظات الحلقة كاملة</p>',
            'active'         => 1,
        ], $overrides);
    }
}