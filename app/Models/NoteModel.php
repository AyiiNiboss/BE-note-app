<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NoteModel extends Model
{
    use HasFactory;
    protected $table = 'notes';
    protected $primarykey = 'id';
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'color',
        'font_color',
        'is_pinned',
    ];
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Check if the name is being updated
            if ($model->isDirty('title')) {
                $baseSlug = Str::slug($model->title);
                $slug = $baseSlug;
                $count = 1;

                // Ensure the slug is unique
                while (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                    $slug = $baseSlug . '-' . $count;
                    $count++;
                }

                $model->slug = $slug;
            }
        });
    }

    public function userRelasi()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
