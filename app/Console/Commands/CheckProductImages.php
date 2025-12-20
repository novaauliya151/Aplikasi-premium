<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CheckProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:check-products {--fix : Attempt to fix missing images by downloading placeholders}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report products with missing image files and optionally fix them by downloading placeholders.';

    public function handle()
    {
        $products = Product::all();

        $missingImageField = $products->filter(fn($p) => !$p->image);
        $missingFiles = $products->filter(fn($p) => $p->image && !Storage::disk('public')->exists($p->image));

        $this->info('Products scanned: ' . $products->count());
        $this->info('Products with empty image field: ' . $missingImageField->count());
        $this->info('Products with missing image files: ' . $missingFiles->count());

        if ($missingImageField->isEmpty() && $missingFiles->isEmpty()) {
            $this->info('All good. No action needed.');
            return 0;
        }

        if ($this->option('fix')) {
            $this->line('Attempting to fix missing images by downloading placeholders...');

            $toFix = $missingImageField->merge($missingFiles)->unique('id');
            $bar = $this->output->createProgressBar($toFix->count());
            $bar->start();

            foreach ($toFix as $product) {
                $slug = urlencode($product->slug);
                $url = "https://via.placeholder.com/600x600/10b981/ffffff?text={$slug}";

                $filename = 'products/' . Str::slug($product->slug) . '.png';

                try {
                    $resp = Http::get($url);
                    if ($resp->ok()) {
                        Storage::disk('public')->put($filename, $resp->body());
                        $product->image = $filename;
                        $product->save();
                    } else {
                        // Try to generate a local placeholder if remote failed
                        Log::warning('Placeholder download failed, generating local placeholder', ['product' => $product->id, 'status' => $resp->status()]);
                        $this->generatePlaceholder($filename);
                        $product->image = $filename;
                        $product->save();
                    }
                } catch (\Exception $e) {
                    Log::error('Exception while downloading placeholder, generating local placeholder', ['product' => $product->id, 'error' => $e->getMessage()]);
                    $this->generatePlaceholder($filename);
                    $product->image = $filename;
                    $product->save();
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine(2);
            $this->info('Fix attempt finished. Re-run command without --fix to verify.');
        } else {
            $this->line('Re-run with --fix to attempt automatic fixes.');
        }

        return 0;
    }

    /**
     * Generate a simple colored PNG placeholder and store it to the public disk.
     */
    protected function generatePlaceholder(string $filename)
    {
        // create a 600x600 PNG with green background
        $width = 600;
        $height = 600;
        $im = imagecreatetruecolor($width, $height);
        $bg = imagecolorallocate($im, 16, 185, 129); // #10b981
        imagefilledrectangle($im, 0, 0, $width, $height, $bg);

        // optional: add white text in center (fallback if imagettftext available)
        $textColor = imagecolorallocate($im, 255, 255, 255);
        $text = 'APK';
        if (function_exists('imagettftext')) {
            // use a reasonable font size; system may not have fonts, catch errors
            try {
                $font = __DIR__ . '/../../../../resources/fonts/arial.ttf';
                if (file_exists($font)) {
                    imagettftext($im, 48, 0, 200, 330, $textColor, $font, $text);
                }
            } catch (\Exception $e) {
                // ignore
            }
        }

        ob_start();
        imagepng($im);
        $data = ob_get_clean();
        imagedestroy($im);

        Storage::disk('public')->put($filename, $data);
    }
}
