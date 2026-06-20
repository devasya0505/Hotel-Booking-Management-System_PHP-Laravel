<?php

namespace Database\Seeders;

use App\Models\Admin\Admin;
use App\Models\Apartment\Apartment;
use App\Models\Hotel\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed demo hotels, rooms, and an optional admin account.
     */
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Ocean View Resort',
                'image' => 'image_2.jpg',
                'description' => 'A peaceful seaside stay with modern rooms and quick access to local attractions.',
                'location' => 'Goa',
            ],
            [
                'name' => 'City Grand Hotel',
                'image' => 'image_3.jpg',
                'description' => 'A comfortable city hotel for business trips, family stays, and weekend travel.',
                'location' => 'Mumbai',
            ],
            [
                'name' => 'Hilltop Retreat',
                'image' => 'image_4.jpg',
                'description' => 'A quiet mountain escape with spacious rooms and scenic views.',
                'location' => 'Manali',
            ],
        ];

        foreach ($hotels as $hotelData) {
            Hotel::firstOrCreate(
                ['name' => $hotelData['name']],
                $hotelData
            );
        }

        $hotelIds = Hotel::pluck('id', 'name');

        $rooms = [
            [
                'name' => 'Deluxe Sea View Room',
                'image' => 'room-1.jpg',
                'max_persons' => 2,
                'size' => '350',
                'view' => 'Sea View',
                'num_beds' => 1,
                'price' => 120.00,
                'hotel_id' => $hotelIds['Ocean View Resort'] ?? Hotel::value('id'),
            ],
            [
                'name' => 'Family Suite',
                'image' => 'room-2.jpg',
                'max_persons' => 4,
                'size' => '520',
                'view' => 'Garden View',
                'num_beds' => 2,
                'price' => 180.00,
                'hotel_id' => $hotelIds['Ocean View Resort'] ?? Hotel::value('id'),
            ],
            [
                'name' => 'Executive City Room',
                'image' => 'room-3.jpg',
                'max_persons' => 2,
                'size' => '300',
                'view' => 'City View',
                'num_beds' => 1,
                'price' => 95.00,
                'hotel_id' => $hotelIds['City Grand Hotel'] ?? Hotel::value('id'),
            ],
            [
                'name' => 'Premium Business Suite',
                'image' => 'room-4.jpg',
                'max_persons' => 3,
                'size' => '460',
                'view' => 'Skyline View',
                'num_beds' => 2,
                'price' => 150.00,
                'hotel_id' => $hotelIds['City Grand Hotel'] ?? Hotel::value('id'),
            ],
            [
                'name' => 'Mountain View Room',
                'image' => 'room-5.jpg',
                'max_persons' => 2,
                'size' => '330',
                'view' => 'Mountain View',
                'num_beds' => 1,
                'price' => 110.00,
                'hotel_id' => $hotelIds['Hilltop Retreat'] ?? Hotel::value('id'),
            ],
            [
                'name' => 'Cottage Suite',
                'image' => 'room-6.jpg',
                'max_persons' => 4,
                'size' => '550',
                'view' => 'Valley View',
                'num_beds' => 2,
                'price' => 175.00,
                'hotel_id' => $hotelIds['Hilltop Retreat'] ?? Hotel::value('id'),
            ],
        ];

        foreach ($rooms as $roomData) {
            Apartment::firstOrCreate(
                ['name' => $roomData['name']],
                $roomData
            );
        }

        if (env('ADMIN_EMAIL') && env('ADMIN_PASSWORD')) {
            Admin::firstOrCreate(
                ['email' => env('ADMIN_EMAIL')],
                [
                    'name' => env('ADMIN_NAME', 'Admin'),
                    'password' => Hash::make(env('ADMIN_PASSWORD')),
                ]
            );
        }
    }
}
