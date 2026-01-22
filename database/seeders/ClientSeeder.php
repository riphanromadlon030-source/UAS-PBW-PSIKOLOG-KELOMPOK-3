<?php

namespace Database\Seeders;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Budi Hartono',
                'email' => 'budi.hartono@example.com',
                'phone' => '081234567890',
                'birth_date' => '1990-01-15',
                'gender' => 'male',
                'address' => 'Jakarta Selatan',
                'occupation' => 'Manager IT',
                'emergency_contact' => 'Siti Hartono',
                'emergency_phone' => '081234567891',
                'medical_history' => 'Alergi debu',
                'notes' => 'Klien regular',
                'status' => 'active',
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 'siti.rahma@example.com',
                'phone' => '082345678901',
                'birth_date' => '1992-03-20',
                'gender' => 'female',
                'address' => 'Yogyakarta',
                'occupation' => 'HR Specialist',
                'emergency_contact' => 'Ahmad Rahma',
                'emergency_phone' => '082345678902',
                'medical_history' => null,
                'notes' => null,
                'status' => 'active',
            ],
            [
                'name' => 'Ahmad Hidayat',
                'email' => 'ahmad.hidayat@example.com',
                'phone' => '083456789012',
                'birth_date' => '1988-05-10',
                'gender' => 'male',
                'address' => 'Surabaya',
                'occupation' => 'Doctor',
                'emergency_contact' => 'Rina Hidayat',
                'emergency_phone' => '083456789013',
                'medical_history' => null,
                'notes' => 'Referral dari RS Pusat',
                'status' => 'active',
            ],
            [
                'name' => 'Ratna Kumala',
                'email' => 'ratna@example.com',
                'phone' => '084567890123',
                'birth_date' => '1995-07-22',
                'gender' => 'female',
                'address' => 'Bandung',
                'occupation' => 'Teacher',
                'emergency_contact' => 'Ibu Kumala',
                'emergency_phone' => '084567890124',
                'medical_history' => null,
                'notes' => null,
                'status' => 'active',
            ],
        ];

        foreach ($clients as $client) {
            Client::create($client);
        }
    }
}
