<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CookingShow extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'cooking_shows', $primaryKey = 'cs_id';

    // Define which fields can be mass assigned
    protected $fillable = [
        'user_id',
        'host',
        'host_lastname',
        'host_surename',
        'address',
        'address_2',
        'city_town',
        'province',
        'postal_code',
        'result',
        'type',
        'date',
        'time',
        'duration',
        'notes',
        'host_email',
        'contact_no',
        'lifechanger',
        'presenter',
        'contest_id',
        'partner_id',
        'status',
    ];

    // Set default values for attributes
    protected $attributes = [
        'result' => 'Booked',
        'type' => 'Regular',
    ];

    // Ensure dates are properly cast
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'date' => 'date',
        'time' => 'datetime',
    ];

    // Make sure created_at is never null when accessed
    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : Carbon::now();
    }

    // Make sure updated_at is never null when accessed
    public function getUpdatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value) : Carbon::now();
    }

    // Return formatted date for display
    public function getFormattedDateAttribute()
    {
        return $this->date ? Carbon::parse($this->date)->format('M j, Y') : null;
    }

    // Return formatted time for display
    public function getFormattedTimeAttribute()
    {
        return $this->time ? Carbon::parse($this->time)->format('g:i A') : null;
    }

    // Return full date and time
    public function getFullDateTimeAttribute()
    {
        if ($this->date && $this->time) {
            return Carbon::parse($this->date->format('Y-m-d') . ' ' . $this->time->format('H:i:s'))->format('M j, Y g:i A');
        }
        return null;
    }

    // Get the days remaining until the show
    public function getDaysRemainingAttribute()
    {
        if (!$this->date) return null;
        $showDate = Carbon::parse($this->date);
        $now = Carbon::now();
        return $now->diffInDays($showDate, false);
    }

    // Check if the show is upcoming
    public function getIsUpcomingAttribute()
    {
        if (!$this->date) return false;
        return Carbon::parse($this->date)->isFuture();
    }

    // Check if the show is past
    public function getIsPastAttribute()
    {
        if (!$this->date) return false;
        return Carbon::parse($this->date)->isPast();
    }

    // Check if the show is happening today
    public function getIsTodayAttribute()
    {
        if (!$this->date) return false;
        return Carbon::parse($this->date)->isToday();
    }

    // Generate a unique identifier for the show
    public function getShowReferenceAttribute()
    {
        $host = Str::substr(strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $this->host)), 0, 3);
        $date = Carbon::parse($this->date)->format('ymd');
        $id = str_pad($this->cs_id, 5, '0', STR_PAD_LEFT);
        return "{$host}{$date}-{$id}";
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order_agreements()
    {
        return $this->hasMany(OrderAgreement::class, 'cs_id', 'cs_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class, 'cs_id', 'cs_id');
    }

    public function contest()
    {
        return $this->belongsTo(Contest::class);
    }

    public function partner_user()
    {
        return $this->belongsTo(User::class, 'partner_id', 'user_id');
    }

    // Helper methods
    public function full_address()
    {
        $line_1 = $this->address . ' ';
        $line_2 = $this->address_2 ? $this->address_2 . ', ' : '';
        $city = $this->city_town ? $this->city_town . ', ' : '';
        $province = $this->province;
        $postal = $this->postal_code ? ' ' . $this->postal_code : '';

        $full_address = $line_1 . $line_2 . $city . $province . $postal;

        return $full_address;
    }

    public function host_fullname()
    {
        $lastname = $this->host_lastname ? ' ' . $this->host_lastname : '';
        $surename = $this->host_surename ? $this->host_surename . ', ' : '';
        return $surename . $this->host . $lastname;
    }

    public function current_result()
    {
        $badgeClasses = [
            'Closed' => 'badge-success',
            'For Follow Up' => 'badge-warning',
            'Booked' => 'badge-info',
            'Rescheduled' => 'badge-info',
            'Cancelled' => 'badge-error',
            'Canceled' => 'badge-error',
        ];

        $badgeClass = $badgeClasses[$this->result] ?? 'badge-ghost';

        $result = '
        <div class="shadow-lg whitespace-nowrap badge ' . $badgeClass . '">
            <div>
                <span>' . $this->result . '</span>
            </div>
        </div>';

        return $result;
    }

    // Scope methods for common queries
    public function scopeBooked($query)
    {
        return $query->where('result', 'Booked');
    }

    public function scopeClosed($query)
    {
        return $query->where('result', 'Closed');
    }

    public function scopeCanceled($query)
    {
        return $query->whereIn('result', ['Canceled', 'Cancelled']);
    }

    public function scopeFollowUp($query)
    {
        return $query->where('result', 'For Follow Up');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', Carbon::today()->toDateString());
    }

    public function scopePast($query)
    {
        return $query->where('date', '<', Carbon::today()->toDateString());
    }

    public function scopeThisWeek($query)
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();
        return $query->whereBetween('date', [$startOfWeek, $endOfWeek]);
    }

    public function scopeThisMonth($query)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        return $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
    }

    // Business logic methods
    public function markAsClosed()
    {
        $this->result = 'Closed';
        $this->save();
        return $this;
    }

    public function markAsFollowUp()
    {
        $this->result = 'For Follow Up';
        $this->save();
        return $this;
    }

    public function markAsCancelled()
    {
        $this->result = 'Canceled';
        $this->save();
        return $this;
    }

    public function reschedule($newDate, $newTime)
    {
        $this->date = $newDate;
        $this->time = $newTime;
        $this->result = 'Rescheduled';
        $this->save();
        return $this;
    }

    public function calculateEfficiency()
    {
        if ($this->attendance > 0) {
            $salesPerAttendee = $this->products_sold / $this->attendance;
            return round($salesPerAttendee * 100) / 100;
        }
        return 0;
    }
}
