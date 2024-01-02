<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Tag;
use App\Models\Taggable;

use Livewire\Livewire;

use App\Http\Livewire\Tags;

class TagTest extends TestCase
{
    // This will reset the database after each test
    use RefreshDatabase;


    public function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_can_open_modal_and_add_a_valid_tag(): void
    {
        Livewire::test(Tags::class)
            ->assertSet('showAddTagModal', false)
            ->call('addTag')
            ->assertSet('showAddTagModal', true)
            ->set('name', 'foo')
            ->call('confirmAddTag');
            //->call('confirmAddTag', ['name' => 'foo']);   // Wenn das genutzt wird, set und call oben auskommentiere

        $this->assertDatabaseHas(Tag::class, ['name' => 'foo']);
    }

    public function test_can_open_modal_but_cannot_add_a_empty_tag(): void
    {
        Livewire::test(Tags::class)
            ->assertSet('showAddTagModal', false)
            ->call('addTag')
            ->assertSet('showAddTagModal', true)
            ->call('confirmAddTag')
            ->assertHasErrors('name');
            //->call('confirmAddTag', ['name' => 'foo']);   // Wenn das genutzt wird, set und call oben auskommentiere

        $this->assertDatabaseMissing(Tag::class, ['name' => 'foo']);
    }

    public function test_can_add_tag_a_user(): void
    {
        Livewire::test(Tags::class)
            ->assertSet('showAddUserModal', false)
            ->call('addUserToTag', '1')
            ->assertSet('showAddUserModal', true)
            ->set('selectedUserId', '1')
            ->call('confirmAddUser');

        $this->assertDatabaseHas(Taggable::class, ['tag_id' => '1', 'taggable_id' => '1', 'taggable_type' => 'App\Models\User']);
    }

    public function test_pagination(): void
    {
        Livewire::test(Tags::class)
            ->assertSee('paginator-page-1-page1')
            ->assertSee('paginator-page-1-page2')
            ->assertDontSee('paginator-page-1-page3')
            //->assertSee('paginator-elements-element1')
            ->call('gotoPage', 2, 'page');
    }

    public function test_confirmAddTag2(): void
    {
        // Daten die gespeichert werden sollen
        $tagData = [
            'name' => 'Glühbirne',
        ];

        Tag::create($tagData);

        // prüft ob Tag hinzugefügt wurde
        $this->assertDatabaseHas('tags', [
            'name' => 'Glühbirne',
        ]);

        // Wenn true mitgegeben wird, wird die Nachricht angezeigt.
        $this->assertTrue(true, 'Tag wurde der Datenbank hinzugefügt.');
    }
}
