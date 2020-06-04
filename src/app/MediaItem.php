<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class MediaItem extends Model implements HasMedia
{
    use HasMediaTrait;

    const PENDING = 'pending';
    const READY = 'ready';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';

    protected $fillable = [
        'submitted_users_name',
        'original_creator',
        'credit',
        'title',
        'description',
        'original_date',
        'original_location',
        'status',
        'reviewed_by',
        'reviewed_at',
        'comment',
        'copyright',
        'phone_number',
        'authorization',
        'user_session_id',
        'user_email',
    ];

    public function scopeForSession($query, $sessionId)
    {
        return $query->where('user_session_id', $sessionId);
    }

    public function scopeApproved($query)
    {
        return $query->where('media_items.status', self::APPROVED);
    }

    public function scopePending($query)
    {
        return $query->where('media_items.status', self::PENDING);
    }

    public function scopeReady($query)
    {
        return $query->where('media_items.status', self::READY);
    }

    public function scopeRejected($query)
    {
        return $query->where('media_items.status', self::REJECTED);
    }

    public function scopeUnsubmitted($query)
    {
        return $query->whereNull('media_items.status');
    }

    public function scopeRange($query, $start, $end)
    {
        $endDate = Carbon::parse($end)->endOfDay();
        return $query->whereBetween('updated_at', [$start, $endDate]);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('grid')
            ->width(560)
            ->height(560);
    }
}
