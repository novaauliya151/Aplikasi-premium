<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run()
{
    \App\Models\Product::insert([
        [
            'name' => 'WhatsApp Premium Mod',
            'slug' => 'whatsapp-premium-mod',
            'description' => 'WhatsApp dengan fitur premium lengkap! Anti banned, tema custom unlimited, dan banyak fitur menarik lainnya.',
            'price' => 50000,
            'features' => "Anti banned permanen\nTema custom unlimited\nDownload status tanpa ketahuan\nHide blue tick & last seen\nDual account support\nAuto reply message\nSchedule message",
            'packages' => "Basic - Rp 50.000 (1 device, lifetime)\nPremium - Rp 85.000 (3 devices, lifetime + support prioritas)",
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Instagram Pro Plus',
            'slug' => 'instagram-pro-plus',
            'description' => 'Instagram dengan fitur download foto & video, zoom profile picture, dan tanpa iklan!',
            'price' => 45000,
            'features' => "Download foto & video HD\nZoom profile picture\nTanpa iklan\nHide story view\nCopy caption & bio\nRepost dengan watermark\nDark mode custom",
            'packages' => "Solo - Rp 45.000 (1 device, lifetime)\nDuo - Rp 75.000 (2 devices, lifetime)",
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Spotify Premium APK',
            'slug' => 'spotify-premium-apk',
            'description' => 'Dengarkan musik tanpa batas! Skip unlimited, tanpa iklan, dan kualitas audio maksimal.',
            'price' => 35000,
            'features' => "Skip unlimited\nTanpa iklan\nKualitas audio Very High\nDownload offline\nLyrics support\nCrossfade & equalizer\nConnect ke speaker",
            'packages' => "Monthly - Rp 35.000 (1 device, 30 hari)\nYearly - Rp 150.000 (1 device, 365 hari + bonus 30 hari)",
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Netflix Premium',
            'slug' => 'netflix-premium',
            'description' => 'Akses Netflix Premium dengan kualitas 4K UHD! Nonton sepuasnya tanpa gangguan iklan.',
            'price' => 60000,
            'features' => "Kualitas 4K UHD\nTanpa iklan\nDownload untuk offline\nMulti device support\nAll content available\nDolby Atmos audio\nSubtitle Indonesia",
            'packages' => "1 Bulan - Rp 60.000 (1 profile)\n3 Bulan - Rp 150.000 (1 profile)\n6 Bulan - Rp 280.000 (2 profiles)",
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'TikTok Pro Mod',
            'slug' => 'tiktok-pro-mod',
            'description' => 'TikTok tanpa watermark! Download video HD, tanpa iklan, dan fitur premium lainnya.',
            'price' => 40000,
            'features' => "Download tanpa watermark\nTanpa iklan\nAuto like & comment\nSchedule post\nVideo HD quality\nAnalytics dashboard\nMulti account login",
            'packages' => "Standard - Rp 40.000 (1 device, lifetime)\nPro - Rp 70.000 (3 devices, lifetime + custom filters)",
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'Canva Pro Unlocked',
            'slug' => 'canva-pro-unlocked',
            'description' => 'Akses semua template premium Canva! Background remover, resize unlimited, dan jutaan assets.',
            'price' => 55000,
            'features' => "All premium templates\nBackground remover\nResize unlimited\nBrand kit\n100GB cloud storage\nMagic resize\nAnimation maker\nTeam collaboration",
            'packages' => "Personal - Rp 55.000 (1 akun, 3 bulan)\nTeam - Rp 120.000 (1 akun, 6 bulan + 5 team members)",
            'created_at' => now(),
            'updated_at' => now()
        ],
    ]);

    // Download placeholder images for seeded products when image is empty
    $products = Product::all();
    foreach ($products as $product) {
        if (!$product->image) {
            try {
                $slug = urlencode($product->slug);
                $url = "https://via.placeholder.com/600x600/10b981/ffffff?text={$slug}";
                $resp = Http::get($url);
                if ($resp->ok()) {
                    $filename = 'products/' . $product->slug . '.png';
                    Storage::disk('public')->put($filename, $resp->body());
                    $product->image = $filename;
                    $product->save();
                }
            } catch (\Exception $e) {
                // ignore network or storage errors during seeding
            }
        }
    }
}

}
