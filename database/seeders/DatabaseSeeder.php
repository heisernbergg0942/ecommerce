<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user (idempotent — safe on repeated runs)
        User::firstOrCreate(
            ['email' => 'admin@angkorshop.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '+855 12 345 678',
                'address' => 'Phnom Penh, Cambodia',
            ]
        );

        // Create test user
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role' => 'user',
                'phone' => '+855 98 765 432',
                'address' => 'Siem Reap, Cambodia',
            ]
        );

        // Create categories
        $categories = [
            ['name' => 'Engine Parts', 'slug' => 'engine-parts', 'description' => 'High-quality engine components for all vehicle types', 'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=300&h=300&fit=crop'],
            ['name' => 'Brake Systems', 'slug' => 'brake-systems', 'description' => 'Reliable brake pads, rotors, and complete brake kits', 'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=300&h=300&fit=crop'],
            ['name' => 'Suspension', 'slug' => 'suspension', 'description' => 'Shocks, struts, and suspension components', 'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=300&h=300&fit=crop'],
            ['name' => 'Exterior Accessories', 'slug' => 'exterior-accessories', 'description' => 'Body kits, spoilers, and exterior upgrades', 'image' => 'https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=300&h=300&fit=crop'],
            ['name' => 'Interior Accessories', 'slug' => 'interior-accessories', 'description' => 'Seat covers, mats, and interior enhancements', 'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=300&h=300&fit=crop'],
            ['name' => 'Electrical', 'slug' => 'electrical', 'description' => 'Batteries, alternators, and electrical components', 'image' => 'https://images.unsplash.com/photo-1620714223084-8fcacc6dfd8d?w=300&h=300&fit=crop'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Create products
        $products = [
            // Engine Parts
            ['category_id' => 1, 'name' => 'Performance Air Filter', 'slug' => 'performance-air-filter', 'description' => 'High-flow reusable air filter for increased horsepower and acceleration. Fits most standard intake systems.', 'price' => 45.99, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=400&h=400&fit=crop', 'featured' => true],
            ['category_id' => 1, 'name' => 'Synthetic Motor Oil 5W-30', 'slug' => 'synthetic-motor-oil-5w30', 'description' => 'Full synthetic motor oil for superior engine protection. 5-quart bottle with advanced formula.', 'price' => 32.99, 'stock' => 100, 'image' => 'https://picsum.photos/seed/motoroil/400/400', 'featured' => true],
            ['category_id' => 1, 'name' => 'Spark Plug Set (4-Pack)', 'slug' => 'spark-plug-set-4pack', 'description' => 'Iridium spark plugs for improved fuel efficiency and smoother engine performance.', 'price' => 28.99, 'stock' => 75, 'image' => 'https://picsum.photos/seed/sparkplug/400/400', 'featured' => false],
                        ['category_id' => 1, 'name' => 'Timing Belt Kit', 'slug' => 'timing-belt-kit', 'description' => 'Complete timing belt kit with tensioner and water pump. OEM quality replacement.', 'price' => 129.99, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1487754180451-c456f719a1fc?w=400&h=400&fit=crop', 'featured' => true],

                        // Brake Systems
                        ['category_id' => 2, 'name' => 'Ceramic Brake Pad Set', 'slug' => 'ceramic-brake-pad-set', 'description' => 'Premium ceramic brake pads for quiet, dust-free braking. Front axle set included.', 'price' => 54.99, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=400&h=400&fit=crop', 'featured' => true],
            ['category_id' => 2, 'name' => 'Drilled & Slotted Rotors', 'slug' => 'drilled-slotted-rotors', 'description' => 'Performance drilled and slotted brake rotors for improved heat dissipation and stopping power.', 'price' => 89.99, 'stock' => 25, 'image' => 'https://picsum.photos/seed/rotors/400/400', 'featured' => false],
            ['category_id' => 2, 'name' => 'Brake Fluid DOT 4', 'slug' => 'brake-fluid-dot4', 'description' => 'High-performance DOT 4 brake fluid. 12oz bottle with superior boiling point.', 'price' => 12.99, 'stock' => 200, 'image' => 'https://picsum.photos/seed/brakefluid/400/400', 'featured' => false],

                        // Suspension
                        ['category_id' => 3, 'name' => 'Gas Shock Absorber', 'slug' => 'gas-shock-absorber', 'description' => 'Premium gas-charged shock absorber for improved ride comfort and handling.', 'price' => 67.99, 'stock' => 35, 'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=400&h=400&fit=crop', 'featured' => true],
                        ['category_id' => 3, 'name' => 'Coil Spring Set', 'slug' => 'coil-spring-set', 'description' => 'Heavy-duty coil springs for enhanced load capacity. Pair included.', 'price' => 95.99, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1537984822441-cff330075342?w=400&h=400&fit=crop', 'featured' => false],
                        ['category_id' => 3, 'name' => 'Sway Bar End Links', 'slug' => 'sway-bar-end-links', 'description' => 'Heavy-duty sway bar end links with polyurethane bushings. Universal fit.', 'price' => 34.99, 'stock' => 45, 'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?w=400&h=400&fit=crop', 'featured' => false],

                        // Exterior Accessories
                        ['category_id' => 4, 'name' => 'LED Headlight Kit', 'slug' => 'led-headlight-kit', 'description' => 'Ultra-bright LED headlight conversion kit. 6000K white light, plug-and-play installation.', 'price' => 79.99, 'stock' => 30, 'image' => 'https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=400&h=400&fit=crop', 'featured' => true],
            ['category_id' => 4, 'name' => 'Car Cover All-Weather', 'slug' => 'car-cover-all-weather', 'description' => 'Premium all-weather car cover with UV protection and water resistance. Universal sedan fit.', 'price' => 49.99, 'stock' => 40, 'image' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=400&h=400&fit=crop', 'featured' => false],
                        ['category_id' => 4, 'name' => 'Chrome Door Handle Covers', 'slug' => 'chrome-door-handle-covers', 'description' => 'Stainless steel chrome door handle covers. Easy snap-on installation.', 'price' => 24.99, 'stock' => 60, 'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=400&h=400&fit=crop', 'featured' => false],

                        // Interior Accessories
                        ['category_id' => 5, 'name' => 'Leather Seat Covers', 'slug' => 'leather-seat-covers', 'description' => 'Premium PU leather seat covers with memory foam padding. Universal fit for most vehicles.', 'price' => 149.99, 'stock' => 15, 'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=400&h=400&fit=crop', 'featured' => true],
            ['category_id' => 5, 'name' => 'Floor Mats All-Weather', 'slug' => 'floor-mats-all-weather', 'description' => 'Heavy-duty rubber floor mats with deep channels for maximum protection.', 'price' => 59.99, 'stock' => 50, 'image' => 'https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?w=400&h=400&fit=crop', 'featured' => false],
                        ['category_id' => 5, 'name' => 'Steering Wheel Cover', 'slug' => 'steering-wheel-cover', 'description' => 'Premium microfiber leather steering wheel cover with anti-slip grip.', 'price' => 19.99, 'stock' => 80, 'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=400&h=400&fit=crop', 'featured' => false],

                        // Electrical
                        ['category_id' => 6, 'name' => 'AGM Car Battery', 'slug' => 'agm-car-battery', 'description' => 'Absorbent Glass Mat battery with 800 CCA. Maintenance-free with 3-year warranty.', 'price' => 189.99, 'stock' => 20, 'image' => 'https://images.unsplash.com/photo-1620714223084-8fcacc6dfd8d?w=400&h=400&fit=crop', 'featured' => true],
            ['category_id' => 6, 'name' => 'Alternator Assembly', 'slug' => 'alternator-assembly', 'description' => 'OEM-quality alternator assembly. Direct fit replacement with 150A output.', 'price' => 164.99, 'stock' => 15, 'image' => 'https://picsum.photos/seed/alternator/400/400', 'featured' => false],
                        ['category_id' => 6, 'name' => 'USB Car Charger', 'slug' => 'usb-car-charger', 'description' => 'Fast-charging dual USB car charger with 48W total output. Compact design.', 'price' => 15.99, 'stock' => 150, 'image' => 'https://images.unsplash.com/photo-1620714223084-8fcacc6dfd8d?w=400&h=400&fit=crop', 'featured' => false],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['slug' => $product['slug']], $product);
        }
    }
}
