<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    /** @use HasFactory<\Database\Factories\PollFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'multiple_choices',
        'slug',
        'description',
        'voter_identifier',
    ];

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
