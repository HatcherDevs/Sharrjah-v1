<?php

namespace Tests\Feature\Admin;

use App\Models\ResearchBuilding;
use App\Models\ResearchType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests for the Admin "Research" section.
 * Covers: Map (Buildings + Types).
 */
class ResearchCmsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    // =========================================================================
    // Authentication guards — Buildings
    // =========================================================================

    public function test_unauthenticated_user_cannot_view_buildings_list(): void
    {
        $this->get('/admin/research/buildings')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_building_form(): void
    {
        $this->get('/admin/research/buildings/create')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_building(): void
    {
        $this->post('/admin/research/buildings', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_edit_building(): void
    {
        $type = ResearchType::create($this->validTypeData());
        $building = ResearchBuilding::create($this->validBuildingData($type->id));
        $this->get("/admin/research/buildings/edit/{$building->id}")->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_delete_building(): void
    {
        $type = ResearchType::create($this->validTypeData());
        $building = ResearchBuilding::create($this->validBuildingData($type->id));
        $this->get("/admin/research/buildings/delete/{$building->id}")->assertRedirect('/admin/login');
    }

    // =========================================================================
    // Authentication guards — Research Types
    // =========================================================================

    public function test_unauthenticated_user_cannot_view_types_list(): void
    {
        $this->get('/admin/research/types')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_view_create_type_form(): void
    {
        $this->get('/admin/research/types/create')->assertRedirect('/admin/login');
    }

    public function test_unauthenticated_user_cannot_store_type(): void
    {
        $this->post('/admin/research/types', ['title' => 'Hacker'])->assertRedirect('/admin/login');
    }

    // =========================================================================
    // Research Types — List
    // =========================================================================

    public function test_admin_can_view_research_types_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/research/types')
            ->assertStatus(200);
    }

    // =========================================================================
    // Research Types — Create form
    // =========================================================================

    public function test_admin_can_view_create_type_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/research/types/create')
            ->assertStatus(200);
    }

    // =========================================================================
    // Research Types — Store — all fields
    // =========================================================================

    public function test_admin_can_create_research_type_with_all_fields(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/research/types', $this->validTypeData())
            ->assertRedirect();

        $this->assertDatabaseHas('research_types', ['title' => 'Modernist Buildings']);
    }

    public function test_creating_research_type_generates_slug(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/research/types', $this->validTypeData(['title' => 'Type Slug Test']));

        $this->assertDatabaseHas('research_types', ['slug' => 'type-slug-test']);
    }

    // =========================================================================
    // Research Types — Edit form
    // =========================================================================

    public function test_admin_can_view_edit_type_form(): void
    {
        $type = ResearchType::create($this->validTypeData());

        $this->actingAs($this->admin)
            ->get("/admin/research/types/edit/{$type->id}")
            ->assertStatus(200);
    }

    // =========================================================================
    // Research Types — Update
    // =========================================================================

    public function test_admin_can_update_research_type(): void
    {
        $type = ResearchType::create($this->validTypeData(['title' => 'Old Type']));

        $this->actingAs($this->admin)
            ->post('/admin/research/types/update', array_merge($this->validTypeData(), [
                'id'    => $type->id,
                'title' => 'Updated Type',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('research_types', [
            'id'    => $type->id,
            'title' => 'Updated Type',
        ]);
    }

    // =========================================================================
    // Research Types — Delete
    // =========================================================================

    public function test_admin_can_delete_research_type(): void
    {
        $type = ResearchType::create($this->validTypeData());

        $this->actingAs($this->admin)
            ->get("/admin/research/types/delete/{$type->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('research_types', ['id' => $type->id]);
    }

    // =========================================================================
    // Buildings — List
    // =========================================================================

    public function test_admin_can_view_buildings_list(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/research/buildings')
            ->assertStatus(200);
    }

    // =========================================================================
    // Buildings — Create form
    // =========================================================================

    public function test_admin_can_view_create_building_form(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/research/buildings/create')
            ->assertStatus(200);
    }

    // =========================================================================
    // Buildings — Store — all fields
    // =========================================================================

    public function test_admin_can_create_building_with_all_fields(): void
    {
        $type = ResearchType::create($this->validTypeData());

        $this->actingAs($this->admin)
            ->post('/admin/research/buildings', $this->validBuildingData($type->id))
            ->assertRedirect();

        $this->assertDatabaseHas('research_buildings', ['title' => 'Old Sharjah Bank']);
    }

    public function test_creating_building_generates_slug(): void
    {
        $type = ResearchType::create($this->validTypeData());

        $this->actingAs($this->admin)
            ->post('/admin/research/buildings', $this->validBuildingData($type->id, ['title' => 'Building Slug Test']));

        $this->assertDatabaseHas('research_buildings', ['slug' => 'building-slug-test']);
    }

    // =========================================================================
    // Buildings — Edit form
    // =========================================================================

    public function test_admin_can_view_edit_building_form(): void
    {
        $type = ResearchType::create($this->validTypeData());
        $building = ResearchBuilding::create($this->validBuildingData($type->id));

        $this->actingAs($this->admin)
            ->get("/admin/research/buildings/edit/{$building->id}")
            ->assertStatus(200);
    }

    // =========================================================================
    // Buildings — Update — all fields
    // =========================================================================

    public function test_admin_can_update_building_with_all_fields(): void
    {
        $type = ResearchType::create($this->validTypeData());
        $building = ResearchBuilding::create($this->validBuildingData($type->id, ['title' => 'Old Building']));

        $this->actingAs($this->admin)
            ->post('/admin/research/buildings/update', array_merge($this->validBuildingData($type->id), [
                'id'    => $building->id,
                'title' => 'Updated Building',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('research_buildings', [
            'id'    => $building->id,
            'title' => 'Updated Building',
        ]);
    }

    // =========================================================================
    // Buildings — Delete
    // =========================================================================

    public function test_admin_can_delete_building(): void
    {
        $type = ResearchType::create($this->validTypeData());
        $building = ResearchBuilding::create($this->validBuildingData($type->id));

        $this->actingAs($this->admin)
            ->get("/admin/research/buildings/delete/{$building->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('research_buildings', ['id' => $building->id]);
    }

    public function test_deleting_nonexistent_building_redirects_gracefully(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/research/buildings/delete/999999')
            ->assertRedirect();
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /** @return array<string, mixed> */
    private function validTypeData(array $overrides = []): array
    {
        return array_merge([
            'title'         => 'Modernist Buildings',
            'title_ar'      => 'مباني حداثية',
            'content'       => '<p>Type description</p>',
            'content_ar'    => '<p>وصف النوع</p>',
            'slug'          => 'modernist-buildings',
            'color'         => '#FF5733',
            'pre-1960'      => 'Before 1960',
            '1960-1980'     => '1960-1980 Period',
            '1981-2000'     => '1981-2000 Period',
            '2001-2020'     => '2001-2020 Period',
            'post-2020'     => 'Post 2020',
        ], $overrides);
    }

    /** @return array<string, mixed> */
    private function validBuildingData(int $typeId, array $overrides = []): array
    {
        return array_merge([
            'title'              => 'Old Sharjah Bank',
            'title_ar'           => 'بنك الشارقة القديم',
            'slug'               => 'old-sharjah-bank',
            'content'            => '<p>Building history</p>',
            'content_ar'         => '<p>تاريخ المبنى</p>',
            'year'               => 1975,
            'research_type_id'   => $typeId,
            'lat'                => 25.3462,
            'lng'                => 55.4272,
        ], $overrides);
    }
}