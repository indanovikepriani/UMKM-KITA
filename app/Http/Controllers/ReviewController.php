<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     */
    public function create(Order $order, Product $product)
    {
        // Check if the authenticated user is the customer who placed this order
        $user = Auth::user();
        
        if (!$user || $order->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memberikan review pada pesanan ini.');
        }

        // Check if order is completed and paid
        if ($order->status !== 'completed' || $order->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan review untuk pesanan yang telah selesai dan dibayar.');
        }

        // Check if user has already reviewed this product in this order
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('order_id', $order->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda telah memberikan review untuk produk ini pada pesanan ini.');
        }

        return view('customer.reviews.create', compact('order', 'product'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Order $order, Product $product)
    {
        // Check if the authenticated user is the customer who placed this order
        $user = Auth::user();
        
        if (!$user || $order->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk memberikan review pada pesanan ini.');
        }

        // Check if order is completed and paid
        if ($order->status !== 'completed' || $order->payment_status !== 'paid') {
            return redirect()->back()->with('error', 'Anda hanya dapat memberikan review untuk pesanan yang telah selesai dan dibayar.');
        }

        // Check if user has already reviewed this product in this order
        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('order_id', $order->id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda telah memberikan review untuk produk ini pada pesanan ini.');
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create review
        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved', // Auto-approve reviews
            'approved_at' => now(),
        ]);

        // Update product rating and review count
        $this->updateProductRating($product->id);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Terima kasih! Review Anda telah berhasil dikirim.');
    }

    /**
     * Store a review without order (general review from testimonials page).
     */
    public function storeDirect(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('testimonials.index')
                ->withErrors($validator)
                ->withInput();
        }

        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->whereNull('order_id')
            ->exists();

        if ($existingReview) {
            return redirect()->route('testimonials.index')
                ->with('error', 'Anda sudah memberikan review untuk produk ini.');
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'order_id' => null,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        $this->updateProductRating($request->product_id);

        return redirect()->route('testimonials.index')
            ->with('success', 'Terima kasih! Review Anda berhasil dipublikasikan.');
    }

    /**
     * Display a listing of approved reviews for testimonials page.
     */
    public function testimonials()
    {
        $reviews = Review::approved()
            ->with(['user', 'product'])
            ->latest()
            ->paginate(12);

        $products = Product::where('is_available', true)->where('stock', '>', 0)->orderBy('name')->get();

        return view('testimonials', compact('reviews', 'products'));
    }

    /**
     * Update product rating and review count.
     */
    protected function updateProductRating($productId)
    {
        $product = Product::find($productId);
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

    /**
     * Admin: Display a listing of reviews for management.
     */
    public function adminIndex(Request $request)
    {
        $query = Review::with(['user', 'product', 'order']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by user name, product name, or comment
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('product', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })
                ->orWhere('comment', 'like', "%{$search}%");
            });
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->latest()->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Admin: Show the form for editing the specified review.
     */
    public function adminEdit(Review $review)
    {
        $review->load('user', 'product.category', 'order');
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Admin: Update the specified review in storage.
     */
    public function adminUpdate(Request $request, Review $review)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,approved,rejected',
            'admin_reply' => 'nullable|string|max:500',
            'rejection_reason' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $oldStatus = $review->status;
        $newStatus = $request->status;

        // Single batched update
        $updateData = [
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => $newStatus,
            'admin_reply' => $request->admin_reply,
            'admin_reply_at' => $request->filled('admin_reply') ? now() : null,
        ];

        if ($oldStatus !== 'approved' && $newStatus === 'approved') {
            $updateData['approved_at'] = now();
        } elseif ($oldStatus === 'approved' && $newStatus !== 'approved') {
            $updateData['approved_at'] = null;
        }

        if ($oldStatus !== 'rejected' && $newStatus === 'rejected') {
            $updateData['rejected_at'] = now();
            $updateData['rejection_reason'] = $request->rejection_reason ?? '';
        } elseif ($oldStatus === 'rejected' && $newStatus !== 'rejected') {
            $updateData['rejected_at'] = null;
            $updateData['rejection_reason'] = null;
        }

        $review->update($updateData);

        // Always update product rating after any status change
        if ($oldStatus !== $newStatus) {
            $this->updateProductRating($review->product_id);
        }

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review berhasil diperbarui.');
    }

    /**
     * Admin: Remove the specified review from storage.
     */
    public function adminDestroy(Review $review)
    {
        $productId = $review->product_id;
        $review->delete();

        // Update product rating after deletion
        $this->updateProductRating($productId);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review berhasil dihapus.');
    }
}