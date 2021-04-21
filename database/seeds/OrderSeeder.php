<?php

use App\Order;
use App\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email','mike@thomas.com')->first();
        $order = new Order();
        $order->subject = 'Hello';
        $order->message = 'Hello world';
        $order->file_link = "file";
        $order->user()->associate($user);
        $order->save();
    }
}
