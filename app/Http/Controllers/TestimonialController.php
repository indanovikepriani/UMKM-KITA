<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of approved testimonials/reviews.
     */
    public function index()
    {
        // Redirect to ReviewController testimonials method
        return app(ReviewController::class)->testimonials();
    }

    /**
     * Show the form for creating a new testimonial/review.
     */
    public function create($orderId)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())
            ->where('status', 'completed')
            ->findOrFail($orderId);

        // Check if already reviewed for any product in this order
        $existingReview = Review::where('user_id', Auth::id())
            ->where('order_id', $orderId)
            ->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk pesanan ini!');
        }

        // For backward compatibility, we'll show a form to select product
        // In a real implementation, you might want to show all products from the order
        return view('testimonials.create', compact('order'));
    }

    /**
     * Store a newly created testimonial/review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        $order = Order::where('user_id', Auth::id())
            ->where('id', $request->order_id)
            ->where('status', 'completed')
            ->firstOrFail();

        // For backward compatibility, we'll assume the first product in the order
        // In a real implementation, you might want to let user select which product to review
        $firstItem = $order->items()->first();
        $firstProduct = $firstItem?->product ?? null;
        
        if (!$firstProduct) {
            return redirect()->back()->with('error', 'Tidak dapat menemukan produk dalam pesanan ini.');
        }

        // Check if already reviewed for this product in this order
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $firstProduct->id)
            ->where('order_id', $order->id)
            ->exists();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan review untuk produk ini dalam pesanan ini!');
        }

        // Create review (auto-approved for backward compatibility)
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $firstProduct->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Update product rating
        $this->updateProductRating($firstProduct->id);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Terima kasih atas review Anda!');
    }

    /**
     * Update product rating and review count.
     */
    protected function updateProductRating($productId)
    {
        $product = \App\Models\Product::find($productId);
        if (!$product) {
            return;
        }

        $reviews = Review::where('product_id', $productId)
            ->where('status', 'approved')
            ->get();

        if ($reviews->isEmpty()) {
            $product->average_rating = 0;
            $product->review_count = 0;
        } else {
            $product->average_rating = $reviews->avg('rating');
            $product->review_count = $reviews->count();
        }

        $product->save();
    }
}