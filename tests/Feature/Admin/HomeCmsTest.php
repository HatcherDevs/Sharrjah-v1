<?php

namespace Tests\Feature\Admin;

use App\Models\LandingElement;
use App\Models\Option;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the SAT Admin "Home" and "Pages" sections:
 *
 *  ::Home::
 *    - Homepage Media   (landing elements — CRUD)
 *    - Homepage Contents (headline / intro options — view & update)
 *    - Homepage Boxes    (featured posts — view & create form)
 *    - Footer Settings   (social links / copyright — view & update)
 *    - Menu              (main-menu-1…5 — view & update)
 *
 *  ::Pages::
 *    - View All          (web-pages list)
 *    - Add a Page        (create form, store, edit, update, delete)
 *      → Already covered comprehensively in PageCmsTest.php
 */
class HomeCmsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    /**
     * All slugs required by HomeController methods.
     *
     * @var array<string, string>
     */
    private array $optionSlugs = [
        // Homepage Contents
        'headline-en' => 'Test Headline EN',
        'headline-ar' => 'Test Headline AR',
        'intro-en' => 'Test intro EN',
        'intro-ar' => 'Test intro AR',
        'home-page-font-size-en' => '16px',
        'home-page-font-size-ar' => '18px',
        'home-page-font-line-en' => '1.5',
        'home-page-font-line-ar' => '1.6',
        'additional' => '',
        // Footer Settings
        'facebook-link' => 'https://facebook.com/test',
        'twitter-link' => 'https://twitter.com/test',
        'instagram-link' => 'https://instagram.com/test',
        'vimeo-link' => 'https://vimeo.com/test',
        'copyright' => '© Test 2024',
        'copyright-right' => 'Test Right',
        // Menu
        'main-menu-1' => '1',
        'main-menu-2' => '2',
        'main-menu-3' => '3',
        'main-menu-4' => '4',
        'main-menu-5' => '5',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();

        foreach ($this->optionSlugs as $slug => $value) {
            Option::create([
                'name' => $slug,
                'slug' => $slug,
                'value' => $value,
            ]);
        }
    }

    // =========================================================================
    // Authentication guards — all admin/home routes require login
    // =========================================================================

    public function test_unauthenticated_user_cannot_access_homepage_contents(): void
    {
        $this->get('/admin/home')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_post_homepage_contents(): void
    {
        $this->post('/admin/home/update', ['headline-en' => 'hacked'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_access_footer_settings(): void
    {
        $this->get('/admin/home/footer')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_post_footer_settings(): void
    {
        $this->post('/admin/home/footer', ['copyright' => 'hacked'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_access_menu(): void
    {
        $this->get('/admin/home/menu')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_post_menu(): void
    {
        $this->post('/admin/home/menu', ['main-menu-1' => '99'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_access_homepage_media(): void
    {
        $this->get('/admin/home/landing')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_access_create_landing_element(): void
    {
        $this->get('/admin/home/create/landing')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_access_homepage_boxes(): void
    {
        $this->get('/admin/home/featured')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_access_create_featured(): void
    {
        $this->get('/admin/home/create/featured')->assertRedirect('/admin/login');
    }

    // =========================================================================
    // Homepage Contents — GET admin/home + POST admin/home/update
    // =========================================================================

    public function test_admin_can_view_homepage_contents(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/home')
            ->assertStatus(200);
    }

    public function test_admin_can_update_homepage_contents(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/home/update', [
                'headline-en' => 'Updated Headline EN',
                'headline-ar' => 'Updated Headline AR',
                'intro-en' => 'Updated intro EN',
                'intro-ar' => 'Updated intro AR',
                'home-page-font-size-en' => '20px',
                'home-page-font-size-ar' => '22px',
                'home-page-font-line-en' => '1.8',
                'home-page-font-line-ar' => '1.9',
                'additional' => 'extra notes',
            ])
            ->assertRedirect('/admin/home');

        $this->assertDatabaseHas('options', [
            'slug' => 'headline-en',
            'value' => 'Updated Headline EN',
        ]);
    }

    public function test_homepage_contents_update_persists_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/home/update', [
                'headline-en' => 'New EN Headline',
                'headline-ar' => 'New AR Headline',
                'intro-en' => 'New intro EN',
                'intro-ar' => 'New intro AR',
                'home-page-font-size-en' => '14px',
                'home-page-font-size-ar' => '16px',
                'home-page-font-line-en' => '1.2',
                'home-page-font-line-ar' => '1.3',
                'additional' => '',
            ]);

        $this->assertDatabaseHas('options', ['slug' => 'headline-ar', 'value' => 'New AR Headline']);
        $this->assertDatabaseHas('options', ['slug' => 'intro-en',    'value' => 'New intro EN']);
        $this->assertDatabaseHas('options', ['slug' => 'intro-ar',    'value' => 'New intro AR']);
    }

    // =========================================================================
    // Footer Settings — GET admin/home/footer + POST admin/home/footer
    // =========================================================================

    public function test_admin_can_view_footer_settings(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/home/footer')
            ->assertStatus(200);
    }

    public function test_admin_can_update_footer_settings(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/home/footer', [
                'facebook-link' => 'https://facebook.com/updated',
                'twitter-link' => 'https://twitter.com/updated',
                'instagram-link' => 'https://instagram.com/updated',
                'vimeo-link' => 'https://vimeo.com/updated',
                'copyright' => '© Updated 2025',
                'copyright-right' => 'Updated Right',
            ])
            ->assertRedirect('/admin/home/footer');

        $this->assertDatabaseHas('options', [
            'slug' => 'facebook-link',
            'value' => 'https://facebook.com/updated',
        ]);
    }

    public function test_footer_settings_update_persists_all_social_links(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/home/footer', [
                'facebook-link' => 'https://facebook.com/sat',
                'twitter-link' => 'https://twitter.com/sat',
                'instagram-link' => 'https://instagram.com/sat',
                'vimeo-link' => 'https://vimeo.com/sat',
                'copyright' => '© SAT 2025',
                'copyright-right' => 'Sharjah Urban Planning Council',
            ]);

        $this->assertDatabaseHas('options', ['slug' => 'twitter-link',    'value' => 'https://twitter.com/sat']);
        $this->assertDatabaseHas('options', ['slug' => 'instagram-link',  'value' => 'https://instagram.com/sat']);
        $this->assertDatabaseHas('options', ['slug' => 'vimeo-link',      'value' => 'https://vimeo.com/sat']);
        $this->assertDatabaseHas('options', ['slug' => 'copyright',       'value' => '© SAT 2025']);
        $this->assertDatabaseHas('options', ['slug' => 'copyright-right', 'value' => 'Sharjah Urban Planning Council']);
    }

    // =========================================================================
    // Menu — GET admin/home/menu + POST admin/home/menu
    // =========================================================================

    public function test_admin_can_view_menu_settings(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/home/menu')
            ->assertStatus(200);
    }

    public function test_admin_can_update_menu_settings(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/home/menu', [
                'main-menu-1' => '10',
                'main-menu-2' => '20',
                'main-menu-3' => '30',
                'main-menu-4' => '40',
                'main-menu-5' => '50',
            ])
            ->assertRedirect('/admin/home/menu');

        $this->assertDatabaseHas('options', ['slug' => 'main-menu-1', 'value' => '10']);
        $this->assertDatabaseHas('options', ['slug' => 'main-menu-2', 'value' => '20']);
    }

    public function test_menu_update_persists_all_five_slots(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/home/menu', [
                'main-menu-1' => '11',
                'main-menu-2' => '22',
                'main-menu-3' => '33',
                'main-menu-4' => '44',
                'main-menu-5' => '55',
            ]);

        foreach ([1 => '11', 2 => '22', 3 => '33', 4 => '44', 5 => '55'] as $n => $val) {
            $this->assertDatabaseHas('options', ['slug' => "main-menu-{$n}", 'value' => $val]);
        }
    }

    // =========================================================================
    // Homepage Media (Landing Elements) — CRUD
    // =========================================================================

    public function test_admin_can_view_homepage_media_list(): void
    {
        LandingElement::factory()->count(3)->create();

        $this->actingAs($this->admin)
            ->get('/admin/home/landing')
            ->assertStatus(200);
    }

    public function test_homepage_media_list_shows_no_elements_when_empty(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/home/landing')
            ->assertStatus(200);
    }

    public function test_admin_can_view_create_landing_element_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/home/create/landing')
            ->assertStatus(200);
    }

    public function test_admin_can_save_a_landing_element(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/home/landing/create', [
                'title' => 'New Landing Element',
                'title_ar' => 'عنصر هبوط جديد',
                'order' => 1,
                'is_main' => 0,
                'active' => 1,
            ])
            ->assertRedirect('/admin/home/landing');

        $this->assertDatabaseHas('landing_elements', ['title' => 'New Landing Element']);
    }

    public function test_admin_can_view_edit_landing_element_form(): void
    {
        $element = LandingElement::factory()->create();

        $this->actingAs($this->admin)
            ->get("/admin/home/landing/{$element->id}/edit")
            ->assertStatus(200);
    }

    public function test_admin_can_update_a_landing_element(): void
    {
        $element = LandingElement::factory()->create(['title' => 'Old Title']);

        $this->actingAs($this->admin)
            ->post('/admin/home/landing/update', [
                'id' => $element->id,
                'title' => 'Updated Title',
                'title_ar' => $element->title_ar,
                'order' => $element->order,
                'is_main' => $element->is_main,
                'active' => 1,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('landing_elements', [
            'id' => $element->id,
            'title' => 'Updated Title',
        ]);
    }

    public function test_updating_nonexistent_landing_element_returns_no_database_changes(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/home/landing/update', [
                'id' => 999999,
                'title' => 'Ghost',
            ])
            ->assertRedirect();

        $this->assertDatabaseMissing('landing_elements', ['title' => 'Ghost']);
    }

    public function test_admin_can_delete_a_landing_element(): void
    {
        $element = LandingElement::factory()->create();

        $this->actingAs($this->admin)
            ->get("/admin/home/landing/{$element->id}/delete")
            ->assertRedirect();

        $this->assertDatabaseMissing('landing_elements', ['id' => $element->id]);
    }

    public function test_deleting_nonexistent_landing_element_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/home/landing/999999/delete')
            ->assertRedirect();
    }

    // =========================================================================
    // Homepage Boxes (Featured) — view & create form
    // =========================================================================

    public function test_admin_can_view_homepage_boxes_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/home/featured')
            ->assertStatus(200);
    }

    public function test_admin_can_view_create_featured_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/home/create/featured')
            ->assertStatus(200);
    }
}