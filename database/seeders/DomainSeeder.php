<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstWhere('email', 'test@example.com');

        if (! $user) {
            return;
        }

        $domains = [
            ['name' => 'Laravel', 'color' => '#ef4444'],
            ['name' => 'PHP OOP', 'color' => '#3b82f6'],
            ['name' => 'MySQL', 'color' => '#10b981'],
            ['name' => 'API REST', 'color' => '#8b5cf6'],
        ];

        foreach ($domains as $domain) {
            Domain::updateOrCreate(
                ['user_id' => $user->id, 'name' => $domain['name']],
                ['color' => $domain['color']]
            );
        }
    }
}
