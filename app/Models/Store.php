<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Store extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'address',
        'area',
        'phone',
        'whatsapp',
        'operating_hours',
        'min_order',
        'delivery_radius',
        'estimated_time',
        'is_active',
        'is_featured',
        'user_id',
    ];

    protected $casts = [
        'operating_hours' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($store) {
            if (empty($store->slug)) {
                $slug = Str::slug($store->name);
                $originalSlug = $slug;
                $counter = 1;
                while (static::withoutGlobalScopes()->where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
                $store->slug = $slug;
            }
        });
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Check if store is currently open
    public function isOpen()
    {
        if (!$this->is_active || !$this->operating_hours) return false;

        $dayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        $today = $dayNames[now()->dayOfWeek];
        $hours = $this->operating_hours[$today] ?? null;

        if (!$hours || $hours === 'closed') return false;

        $parts = explode('-', $hours);
        if (count($parts) !== 2) return false;

        $now = now()->format('H:i');
        return $now >= $parts[0] && $now <= $parts[1];
    }

    // Get today's operating hours
    public function getTodayHoursAttribute()
    {
        if (!$this->operating_hours) return 'Tidak tersedia';
        $dayNames = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
        $today = $dayNames[now()->dayOfWeek];
        return $this->operating_hours[$today] ?? 'Tutup';
    }

    // Get average rating from store's products reviews
    public function getAverageRatingAttribute()
    {
        return Review::whereHas('product', function ($q) {
            $q->where('store_id', $this->id);
        })->where('status', 'approved')->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return Review::whereHas('product', function ($q) {
            $q->where('store_id', $this->id);
        })->where('status', 'approved')->count();
    }
}
