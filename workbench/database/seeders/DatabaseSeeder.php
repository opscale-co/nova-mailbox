<?php

namespace Workbench\Database\Seeders;

use Illuminate\Database\Seeder;
use Opscale\NovaDynamicResources\Models\Field;
use Opscale\NovaDynamicResources\Models\Template;
use Workbench\App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@laravel.com',
        ]);

        // Create Nova user
        User::factory()->create([
            'name' => 'Laravel Nova',
            'email' => 'nova@laravel.com',
        ]);

        // Create additional test users
        User::factory()->count(8)->create();

        // Create Secret Code extraction template
        $template = Template::create([
            'label' => 'Secret Codes',
            'singular_label' => 'Secret Code',
            'uri_key' => 'secret-codes',
            'title' => 'secret_code',
        ]);

        Field::create([
            'template_id' => $template->id,
            'type' => 'title',
            'label' => 'Secret Code',
            'name' => 'secret_code',
            'required' => true,
        ]);
    }
}
