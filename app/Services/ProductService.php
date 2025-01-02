<?php

namespace App\Services;

use App\Contracts\ProductServiceInterface;
use App\Models\Product;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ProductService implements ProductServiceInterface
{
    public function generateCode(string $productName): string
    {
        $prefix = strtoupper(substr($productName, 0, 2));

        $date = now()->format('dmY');

        $latestProduct = DB::table('products')
            ->whereDate('created_at', now())
            ->latest()
            ->value('product_code');

        $sequence = 1;
        if ($latestProduct) {
            $latestSequence = substr($latestProduct, -3);
            $sequence = $latestSequence + 1;
        }

        $sequence = str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return $prefix . $date . $sequence;
    }

    public function sendNotification(
        string $title,
        string $body,
        string $icon,
        string $type,
        ?Product $product = null
    ): void {
        $recipient = User::role('admin')->get();
        $notification = Notification::make()
            ->title($title)
            ->icon($icon)
            ->body($body);

        if ($type === 'success') {
            $notification->success();
        } elseif ($type === 'warning') {
            $notification->warning();
        } elseif ($type === 'danger') {
            $notification->danger();
        }

        if ($product) {
            $notification->actions([
                Action::make('Lihat')
                    ->url(route('filament.admin.resources.products.view', $product->id)),
            ]);
        }

        $notification->sendToDatabase($recipient);
    }
}
