<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Order;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Products
        $products = [
            [
                'name'        => 'Full Sleeve Tee - Make Me Fly Again',
                'seller'      => 'hidden_star_official',
                'category'    => 'T-Shirts',
                'price'       => 109.00,
                'qty'         => 45,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Premium oversized streetwear tee with bold graphic print.',
            ],
            [
                'name'        => 'Full Sleeve Tee - HIDDS Black',
                'seller'      => 'streetwear_co',
                'category'    => 'T-Shirts',
                'price'       => 109.00,
                'qty'         => 32,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Classic black oversized tee with Hidden Star logo.',
            ],
            [
                'name'        => 'Hidden Star Logo Cap',
                'seller'      => 'hidden_star_official',
                'category'    => 'Headwear',
                'price'       => 75.00,
                'qty'         => 60,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Structured cap with embroidered Hidden Star logo.',
            ],
            [
                'name'        => 'Nike Air Max 270 Collab',
                'seller'      => 'sneaker_vault',
                'category'    => 'Footwear',
                'price'       => 250.00,
                'qty'         => 15,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Limited edition Nike collab with Hidden Star branding.',
            ],
            [
                'name'        => 'New Balance 574 Street Edition',
                'seller'      => 'sneaker_vault',
                'category'    => 'Footwear',
                'price'       => 185.00,
                'qty'         => 20,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Classic NB silhouette with street-ready colorway.',
            ],
            [
                'name'        => 'Monster Fly Again Hoodie',
                'seller'      => 'hidden_star_official',
                'category'    => 'Hoodies',
                'price'       => 175.00,
                'qty'         => 28,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Heavyweight cotton hoodie with full chest graphic.',
            ],
            [
                'name'        => 'Hidden Star Thorn Logo Tee',
                'seller'      => 'hidden_star_official',
                'category'    => 'T-Shirts',
                'price'       => 95.00,
                'qty'         => 55,
                'image'       => null,
                'status'      => 'active',
                'description' => 'White oversized tee with iconic thorn-encircled logo.',
            ],
            [
                'name'        => 'Streetwear Cargo Shorts',
                'seller'      => 'urban_drops',
                'category'    => 'Bottoms',
                'price'       => 120.00,
                'qty'         => 40,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Relaxed fit cargo shorts ideal for street styling.',
            ],
            [
                'name'        => 'Hidden Star Balaclava',
                'seller'      => 'hidden_star_official',
                'category'    => 'Accessories',
                'price'       => 45.00,
                'qty'         => 80,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Signature face mask for the Hidden Star aesthetic.',
            ],
            [
                'name'        => 'Graphic Tee - Some Thing That Gives Energy',
                'seller'      => 'streetwear_co',
                'category'    => 'T-Shirts',
                'price'       => 109.00,
                'qty'         => 38,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Back-print oversized tee with energy-themed design.',
            ],
            [
                'name'        => 'Hidden Star Puffer Jacket',
                'seller'      => 'urban_drops',
                'category'    => 'Outerwear',
                'price'       => 320.00,
                'qty'         => 12,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Lightweight puffer with Hidden Star patch logo.',
            ],
            [
                'name'        => 'HIDDS Snapback Cap',
                'seller'      => 'hidden_star_official',
                'category'    => 'Headwear',
                'price'       => 65.00,
                'qty'         => 50,
                'image'       => null,
                'status'      => 'active',
                'description' => 'Snapback cap with retro HIDDS logo branding.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Seed Orders
        $orderData = [
            [
                'user'           => 'Rizky Pratama',
                'product'        => 'Full Sleeve Tee - Make Me Fly Again',
                'price'          => 109.00,
                'status'         => 'completed',
                'qty'            => 1,
                'payment_method' => 'Bank Transfer',
            ],
            [
                'user'           => 'Siti Rahayu',
                'product'        => 'Hidden Star Logo Cap',
                'price'          => 75.00,
                'status'         => 'processing',
                'qty'            => 2,
                'payment_method' => 'QRIS',
            ],
            [
                'user'           => 'Budi Santoso',
                'product'        => 'Nike Air Max 270 Collab',
                'price'          => 250.00,
                'status'         => 'pending',
                'qty'            => 1,
                'payment_method' => 'COD',
            ],
            [
                'user'           => 'Dewi Lestari',
                'product'        => 'Monster Fly Again Hoodie',
                'price'          => 175.00,
                'status'         => 'completed',
                'qty'            => 1,
                'payment_method' => 'Bank Transfer',
            ],
            [
                'user'           => 'Andi Wijaya',
                'product'        => 'New Balance 574 Street Edition',
                'price'          => 185.00,
                'status'         => 'pending',
                'qty'            => 1,
                'payment_method' => 'QRIS',
            ],
            [
                'user'           => 'Nadia Putri',
                'product'        => 'Hidden Star Thorn Logo Tee',
                'price'          => 95.00,
                'status'         => 'completed',
                'qty'            => 3,
                'payment_method' => 'Bank Transfer',
            ],
            [
                'user'           => 'Fajar Nugroho',
                'product'        => 'Streetwear Cargo Shorts',
                'price'          => 120.00,
                'status'         => 'cancelled',
                'qty'            => 1,
                'payment_method' => 'COD',
            ],
            [
                'user'           => 'Laras Wulandari',
                'product'        => 'Hidden Star Balaclava',
                'price'          => 45.00,
                'status'         => 'processing',
                'qty'            => 2,
                'payment_method' => 'QRIS',
            ],
            [
                'user'           => 'Hendra Kurniawan',
                'product'        => 'Full Sleeve Tee - HIDDS Black',
                'price'          => 109.00,
                'status'         => 'completed',
                'qty'            => 2,
                'payment_method' => 'Bank Transfer',
            ],
            [
                'user'           => 'Tina Maharani',
                'product'        => 'Hidden Star Puffer Jacket',
                'price'          => 320.00,
                'status'         => 'pending',
                'qty'            => 1,
                'payment_method' => 'Bank Transfer',
            ],
            [
                'user'           => 'Doni Prasetyo',
                'product'        => 'HIDDS Snapback Cap',
                'price'          => 65.00,
                'status'         => 'completed',
                'qty'            => 1,
                'payment_method' => 'QRIS',
            ],
            [
                'user'           => 'Maya Indah',
                'product'        => 'Graphic Tee - Some Thing That Gives Energy',
                'price'          => 109.00,
                'status'         => 'processing',
                'qty'            => 1,
                'payment_method' => 'COD',
            ],
        ];

        foreach ($orderData as $order) {
            Order::create($order);
        }
    }
}
