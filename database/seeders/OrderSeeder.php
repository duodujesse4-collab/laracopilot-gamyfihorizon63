<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $products = Product::all();
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'delivered', 'delivered', 'cancelled'];
        $paymentMethods = ['credit_card', 'paypal', 'stripe', 'bank_transfer'];

        for ($i = 0; $i < 30; $i++) {
            $user = $users->random();
            $status = $statuses[array_rand($statuses)];
            $itemCount = rand(1, 4);
            $orderProducts = $products->random($itemCount);
            $subtotal = 0;
            $orderItemsData = [];

            foreach ($orderProducts as $product) {
                $qty = rand(1, 3);
                $lineTotal = $product->price * $qty;
                $subtotal += $lineTotal;
                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $qty,
                    'subtotal' => $lineTotal,
                ];
            }

            $shipping = $subtotal > 100 ? 0 : 9.99;
            $tax = round($subtotal * 0.08, 2);
            $total = $subtotal + $shipping + $tax;

            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'status' => $status,
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                'payment_status' => 'paid',
                'shipping_name' => $user->name,
                'shipping_email' => $user->email,
                'shipping_phone' => '555-' . rand(100, 999) . '-' . rand(1000, 9999),
                'shipping_address' => rand(100, 9999) . ' Main Street',
                'shipping_city' => ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'][array_rand(['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix'])],
                'shipping_state' => 'CA',
                'shipping_zip' => (string) rand(10000, 99999),
                'shipping_country' => 'United States',
                'created_at' => now()->subDays(rand(0, 90)),
            ]);

            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }
        }
    }
}