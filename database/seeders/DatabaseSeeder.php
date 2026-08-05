<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
  public function run(): void
      {
          \App\Models\User::create([
              'nome' => 'Edson Belem',
              'email' => 'devebsjunior@gmail.com',
              'password' => '123456',
              'ativo' => true,
          ]);
      }
}
