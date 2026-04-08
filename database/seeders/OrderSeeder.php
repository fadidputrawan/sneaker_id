<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\User;

class OrderSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = User::all();
        $statuses = ['diproses', 'dikirim', 'selesai', 'dibatalkan'];

        if ($users->isEmpty()) {
            return;
        }

        foreach ($users as $index => $user) {
            Order::create([
                'user_id' => $user->id,
                'nama' => $user->name,
                'total' => 1000000 + ($index * 500000),
                'status' => $statuses[$index % count($statuses)],
                'created_at' => now()->subDays($index * 3),
                'updated_at' => now()->subDays($index * 3),
            ]);
        }
    }
}
