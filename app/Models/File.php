<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $parent_type
 * @property int $parent_id
 * @property int $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */


class File extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (File $image){
            Storage::delete($image->name);
        });
    }

    public static function upload(Model $parent, UploadedFile $image, string $type = null): self
    {
        $fileParent = Auth::check() ? Auth::user() : $parent;
        $folder = Str::plural(strtolower(class_basename($fileParent))) . '/' . $fileParent->getKey();
        if (! app()->isProduction()) {
            $folder = 'testing/' . $folder;
        }
        $name = $image->store($folder);

        return static::create([
            'name' => $name,
            'parent_id' => $parent->id,
            'parent_type' => $parent->getMorphClass(),
            'type' => $type
        ]);
    }

    /**
     * @param UploadedFile $image
     * @return bool
     */
     public function replaceWith(UploadedFile $image): bool
     {
         Storage::delete($this->name);

         return $this->update([
             'name' => $image->store('images')
         ]);
     }

    public function parent(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->name) . "?v={$this->updated_at->timestamp}";
    }

    public function toArray(): array
    {
        return $this->only(['id', 'url']);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

}
