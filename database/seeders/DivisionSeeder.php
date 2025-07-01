<?php
namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            [
                'name' => 'Human Resources',
                'description' => 'Divisi yang menangani sumber daya manusia dan kepegawaian',
            ],
            [
                'name' => 'Finance',
                'description' => 'Divisi yang menangani keuangan dan akuntansi',
            ],
            [
                'name' => 'IT',
                'description' => 'Divisi teknologi informasi dan sistem',
            ],
            [
                'name' => 'Operations',
                'description' => 'Divisi operasional dan produksi',
            ],
            [
                'name' => 'Marketing',
                'description' => 'Divisi pemasaran dan promosi',
            ],
            [
                'name' => 'Legal',
                'description' => 'Divisi hukum dan kepatuhan',
            ],
        ];

        foreach ($divisions as $division) {
            Division::firstOrCreate(
                ['name' => $division['name']],
                $division
            );
        }
    }
}
