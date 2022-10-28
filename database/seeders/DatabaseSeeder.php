<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        EquipmentType::insert([
            [
                'name' => 'TP-Link TL-WR74',
                'mask' => 'NNNNNNNNNN',
            ],
            [
                'name' => 'TP-Link TL-WR75',
                'mask' => 'XXAAAAAXAA',
            ],
            [
                'name' => 'TP-Link TL-WR76',
                'mask' => 'XXAAAAAXAA',
            ],
            [
                'name' => 'TP-Link TL-WR77',
                'mask' => 'XXAAAAAXAA',
            ],
            [
                'name' => 'TP-Link TL-WR78',
                'mask' => 'XXAAAAAXAA',
            ],
            [
                'name' => 'TP-Link TL-WR79',
                'mask' => 'XXAAAAAXAA',
            ],
            [
                'name' => 'TP-Link TL-WR80',
                'mask' => 'XXAAAAAXAA',
            ],
        ]);

        Equipment::insert([
            [
                'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
                'serial_number' => 'XXAAAAAXAA',
                'desc' => fake()->paragraph(),
            ],
            [
                'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
                'serial_number' => 'DDDDDDDDDF',
                'desc' => fake()->paragraph(),
            ],
            [
                'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
                'serial_number' => 'DDDDDDDDDN',
                'desc' => fake()->paragraph(),
            ],
            [
                'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
                'serial_number' => 'DDDDDDDDDT',
                'desc' => fake()->paragraph(),
            ],
            [
                'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
                'serial_number' => 'DDDDDDDDDS',
                'desc' => fake()->paragraph(),
            ],
            [
                'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
                'serial_number' => 'DDDDDDDDDX',
                'desc' => fake()->paragraph(),
            ],
            [
                'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
                'serial_number' => 'DDDDDDDDDB',
                'desc' => fake()->paragraph(),
            ],
            [
                'equipment_type_id' => EquipmentType::inRandomOrder()->first()->id,
                'serial_number' => 'DDDDDDDDDA',
                'desc' => fake()->paragraph(),
            ],
        ]);
    }
}
