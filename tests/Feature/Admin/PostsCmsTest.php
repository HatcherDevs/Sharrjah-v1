<?php

namespace Tests\Feature\Admin;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for Admin "Posts" sections:
 * Calendar, Opportunities, Projects, Releases, Coverage,
 * Partners, Supporters, Venues & Times.
 *
 * All use PostController which reads Page by slug.
 */
class PostsCmsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    /** @var array<string, Page> */
    private array $pages;

    /** Slugs required by PostController routes */
    private array $slugs = [
        'calendar',
        'opportunities',
        'projects',
        'releases',
        'coverage',
        'partners',
        'supporters',
        'venues-and-times',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();

        foreach ($this->slugs as $slug) {
            $this->pages[$slug] = Page::factory()->create([
                'slug'      => $slug,
                'page_type' => 'list',
                'active'    => 1,
            ]);
        }
    }

    // =========================================================================
    // Authentication guards
    // =========================================================================

    public function test_unauthenticated_user_cannot_view_calendar_list(): void
    {
        $this->get('/admin/posts/calendar')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_post_form(): void
    {
        $this->get('/admin/posts/create/calendar')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_post(): void
    {
        $this->post('/admin/posts/', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_post(): void
    {
        $post = Post::factory()->create(['page_id' => $this->pages['calendar']->id]);
        $this->get("/admin/posts/{$post->id}/edit")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_post(): void
    {
        $post = Post::factory()->create(['page_id' => $this->pages['calendar']->id]);
        $this->get("/admin/posts/{$post->id}/delete")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // List views for each section
    // =========================================================================

    public function test_admin_can_view_calendar_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/calendar')
            ->assertStatus(200);
    }

    public function test_admin_can_view_opportunities_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/opportunities')
            ->assertStatus(200);
    }

    public function test_admin_can_view_projects_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/projects')
            ->assertStatus(200);
    }

    public function test_admin_can_view_releases_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/releases')
            ->assertStatus(200);
    }

    public function test_admin_can_view_coverage_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/coverage')
            ->assertStatus(200);
    }

    public function test_admin_can_view_partners_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/partners')
            ->assertStatus(200);
    }

    public function test_admin_can_view_supporters_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/supporters')
            ->assertStatus(200);
    }

    public function test_admin_can_view_venues_and_times_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/venues-and-times')
            ->assertStatus(200);
    }

    // =========================================================================
    // Create forms
    // =========================================================================

    public function test_admin_can_view_create_calendar_event_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/create/calendar')
            ->assertStatus(200);
    }

    public function test_create_form_returns_404_for_unknown_slug(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/create/nonexistent-slug')
            ->assertStatus(404);
    }

    // =========================================================================
    // Store — all fields
    // =========================================================================

    public function test_admin_can_create_calendar_event_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/posts/', [
                'page_id'        => $this->pages['calendar']->id,
                'title'          => 'Architecture Workshop',
                'title_ar'       => 'ورشة عمل معمارية',
                'description'    => 'A great workshop',
                'description_ar' => 'ورشة عمل رائعة',
                'content'        => '<p>Details here</p>',
                'content_ar'     => '<p>التفاصيل هنا</p>',
                'publish_date'   => '2024-03-15',
                'active'         => 1,
                'is_external'    => 0,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title'   => 'Architecture Workshop',
            'page_id' => $this->pages['calendar']->id,
        ]);
    }

    public function test_admin_can_create_opportunity(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/posts/', [
                'page_id'        => $this->pages['opportunities']->id,
                'title'          => 'Open Call for Artists',
                'title_ar'       => 'نداء مفتوح للفنانين',
                'description'    => 'Submit your work',
                'description_ar' => 'قدم عملك',
                'content'        => '<p>Application details</p>',
                'content_ar'     => '<p>تفاصيل التقديم</p>',
                'publish_date'   => '2024-04-01',
                'active'         => 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'title'   => 'Open Call for Artists',
            'page_id' => $this->pages['opportunities']->id,
        ]);
    }

    public function test_creating_post_generates_slug_from_title(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/posts/', [
                'page_id'      => $this->pages['projects']->id,
                'title'        => 'My Test Project',
                'title_ar'     => 'مشروع اختباري',
                'publish_date' => '2024-01-01',
                'active'       => 1,
            ]);

        $this->assertDatabaseHas('posts', ['slug' => 'my-test-project']);
    }

    // =========================================================================
    // Edit form
    // =========================================================================

    public function test_admin_can_view_edit_post_form(): void
    {
        $post = Post::factory()->create(['page_id' => $this->pages['releases']->id]);

        $this->actingAs($this->admin)
            ->get("/admin/posts/{$post->id}/edit")
            ->assertStatus(200);
    }

    // =========================================================================
    // Update — all fields
    // =========================================================================

    public function test_admin_can_update_post_with_all_fields(): void
    {
        $post = Post::factory()->create([
            'page_id' => $this->pages['coverage']->id,
            'title'   => 'Old Title',
        ]);

        $this->actingAs($this->admin)
            ->post('/admin/posts/update', [
                'id'             => $post->id,
                'page_id'        => $this->pages['coverage']->id,
                'title'          => 'Updated Coverage Title',
                'title_ar'       => 'عنوان تغطية محدث',
                'description'    => 'Updated description',
                'description_ar' => 'وصف محدث',
                'content'        => '<p>Updated content</p>',
                'content_ar'     => '<p>محتوى محدث</p>',
                'publish_date'   => '2024-05-01',
                'active'         => 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('posts', [
            'id'    => $post->id,
            'title' => 'Updated Coverage Title',
        ]);
    }

    public function test_updating_nonexistent_post_returns_404(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/posts/update', [
                'id'    => 999999,
                'title' => 'Ghost Post',
            ])
            ->assertStatus(404);
    }

    // =========================================================================
    // Delete
    // =========================================================================

    public function test_admin_can_delete_calendar_event(): void
    {
        $post = Post::factory()->create(['page_id' => $this->pages['calendar']->id]);

        $this->actingAs($this->admin)
            ->get("/admin/posts/{$post->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_admin_can_delete_any_post_type(): void
    {
        foreach ($this->slugs as $slug) {
            $post = Post::factory()->create(['page_id' => $this->pages[$slug]->id]);

            $this->actingAs($this->admin)
                ->get("/admin/posts/{$post->id}/delete")
                ->assertRedirect();

            $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        }
    }

    public function test_deleting_nonexistent_post_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/posts/999999/delete')
            ->assertRedirect();
    }
}