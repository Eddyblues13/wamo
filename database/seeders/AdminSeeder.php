<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = 'admin@wamo.com';
        $password = 'password';

        Admin::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Wamo Admin',
                'password' => $password,
                'role' => 'super',
            ],
        );

        $this->command?->info('Admin account ready:');
        $this->command?->line("  URL:      /admin/login");
        $this->command?->line("  Email:    {$email}");
        $this->command?->line("  Password: {$password}");
    }
}
