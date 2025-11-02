<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function whatsapp(Request $request)
    {
        // ✅ التحقق من البيانات
        $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:255',
        ]);

        // ✅ جلب السلة
        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Your cart is empty.');
        }

        // ✅ حساب الإجماليات
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['qty']);
        $deliveryFee = 3.00;
        $total = $subtotal + $deliveryFee;

        // ✅ إعداد نص الرسالة
        $message = "🛍 *New Order - Tech Care Store*%0A";
        $message .= "👤 *Customer:* {$request->name}%0A";
        $message .= "📞 *Phone:* {$request->phone}%0A";
        $message .= "🏠 *Address:* {$request->address}%0A%0A";
        $message .= "📦 *Order Details:*%0A";

        foreach ($cart as $item) {
            $line = "- {$item['name']} × {$item['qty']} = $" . number_format($item['price'] * $item['qty'], 2);
            $message .= "{$line}%0A";
        }

        $message .= "%0A🚚 *Delivery Fee:* $" . number_format($deliveryFee, 2);
        $message .= "%0A💰 *Total:* $" . number_format($total, 2) . "%0A%0A";
        $message .= "✅ *Please confirm your order.*";

        // ✅ قراءة رقم الواتساب من env
        $sellerNumber = config('services.whatsapp.phone');

        // ✅ تفريغ السلة بعد الطلب
        session()->forget('cart');

        // ✅ الانتقال إلى رابط واتساب
        $url = "https://wa.me/{$sellerNumber}?text={$message}";
        return redirect()->away($url);
    }
}
