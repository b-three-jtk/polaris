<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use App\Models\Reviewer;
use App\Models\Reference;
use App\Models\Submitter;
use App\Models\Submission;
use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */ 
    public function run(): void
    {
        Organization::create([
            'organization_code' => 'POL1234',
            'organization_name' => 'Politeknik Negeri Bandung',
            'company_description' => 'Politeknik Negeri Bandung adalah sebuah perguruan tinggi vokasi negeri yang terletak di Jl. Gegerkalong Hilir, Desa Ciwaruga, Kecamatan Parongpong, Kabupaten Bandung Barat. Mulanya POLBAN bernama Politeknik Institut Teknologi Bandung karena berada dalam naungan ITB.',
            'address' => 'Jl. Gegerkalong Hilir, Ciwaruga, Kec. Parongpong, Kabupaten Bandung Barat, Jawa Barat 40559',
            'website' => 'https://www.polban.ac.id/',
            'business_field' => 'Pendidikan',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $user = User::create([
            'name' => 'Miya Soraya',
            'email' => 'miya@smartek.com',
            'phone_number' => '0987654321',
            'role' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('password123!')
        ]);

        $user->markEmailAsVerified();

        $admin = User::create([
            'name' => 'Mamang Admin',
            'email' => 'mamang@polaris.com',
            'phone_number' => '0987654321',
            'role' => 2,
            'email_verified_at' => now(),
            'password' => Hash::make('password123!')
        ]);

        $admin->markEmailAsVerified();

        $reviewer = User::create([
            'name' => 'Asep bin Budi',
            'email' => 'asepbinbudi@polaris.com',
            'phone_number' => '0987654321',
            'role' => 3,
            'email_verified_at' => now(),
            'password' => Hash::make('password123!')
        ]);

        $reviewer->markEmailAsVerified();

        Submitter::create([
            'user_id' => $user->user_id,
            'position_in_organization' => 'Pegawai',
            'organization_code' => 'POL1234'
        ]);
        
        Admin::create([
            'nip' => '1234567890',
            'user_id' => $admin->user_id
        ]);

        Reviewer::create([
            'nip_reviewer' => '1234567890',
            'user_id' => $reviewer->user_id,
            'isActive' => true,
            'review_total' => 0
        ]);

        Organization::factory(10)->create();
        // User::factory(10)->create();
        // Submitter::factory(10)->create();
        // Submission::factory(30)->create();
        // Reference::factory(5)->create();
        // // Review::factory(5)->create();
        // Reviewer::factory(10)->create();
    }
}
