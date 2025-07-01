<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Surat Keputusan',
                'description' => 'Surat keputusan resmi dan kebijakan',
            ],
            [
                'name' => 'Surat Edaran',
                'description' => 'Surat edaran dan pemberitahuan',
            ],
            [
                'name' => 'Laporan',
                'description' => 'Laporan keuangan, operasional, dan lainnya',
            ],
            [
                'name' => 'Kontrak',
                'description' => 'Kontrak kerja, kerjasama, dan perjanjian',
            ],
            [
                'name' => 'Standard Operating Procedure',
                'description' => 'Prosedur operasional standar',
            ],
            [
                'name' => 'Manual',
                'description' => 'Manual penggunaan dan panduan',
            ],
            [
                'name' => 'Proposal',
                'description' => 'Proposal project dan pengajuan',
            ],
            [
                'name' => 'Invoice',
                'description' => 'Faktur dan dokumen keuangan',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
