<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'priority', 'due_date', 'is_done' , 'description'];

    protected $attributes = [
        'is_done' => false, // pastikan tanpa tanda kutip
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
