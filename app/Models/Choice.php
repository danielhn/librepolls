<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Choice extends Model
{
    /** @use HasFactory<\Database\Factories\ChoiceFactory> */
    use HasFactory;
    protected $fillable = ['text'];

    public function poll(): BelongsTo
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes(): BelongsToMany
    {
        return $this->belongsToMany(Vote::class);
    }
}
