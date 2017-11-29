<?php

namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Intervention;

class Image extends Model
{
    protected $guarded = [];

    public static function fromFile(UploadedFile $file, array $attrubutes = [])
    {
        $image = new static;

        $featured_path = $file->store('featured', 'public');

        $thumbnail_path = $image->makeThumbnail($file);

        $image->fill([
            'title' => 'Some Title',
            'featured' => $featured_path,
            'thumbnail' => $thumbnail_path,
        ]);

        return $image;
    }

    protected static function makeThumbnail($file)
    {
        $thumbnail = Intervention::make($file)
            ->fit(200)
            ->stream();

        $thumbnail_path = 'thumbnails/' . $file->hashName();

        Storage::disk('public')->put($thumbnail_path, $thumbnail);

        return $thumbnail_path;
    }

    public function delete()
    {
        if ($path = $this->featured) {
            Storage::disk('public')->delete($path);
        }

        if ($path = $this->thumbnail) {
            Storage::disk('public')->delete($path);
        }

        parent::delete();
    }
}
