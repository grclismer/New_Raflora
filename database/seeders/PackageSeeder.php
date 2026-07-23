<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            [
                'title' => 'Standard Wedding',
                'description' => 'Complete wedding floral styling for ceremony and reception.',
                'price' => 35000.00,
                'included_items' => [
                    'Bridal Bouquet',
                    '5 Boutonnieres',
                    'Ceremony Arch',
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Grand Debut',
                'description' => 'Elegant floral setup for debutant stage and guest tables.',
                'price' => 28000.00,
                'included_items' => [
                    'Debutante Bouquet',
                    'Stage Backdrop',
                    '18 Roses Setup',
                ],
                'is_active' => true,
            ],
            [
                'title' => 'Minimalist Event',
                'description' => 'Clean corporate and minimalist floral arrangements.',
                'price' => 18000.00,
                'included_items' => [
                    'Stage Flowers',
                    'Registration Desk',
                    '8 Table Pieces',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($packages as $pkg) {
            Package::updateOrCreate(
                ['title' => $pkg['title']],
                $pkg
            );
        }
    }
}
