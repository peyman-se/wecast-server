<?php

namespace App\Http\Controllers;

use App\Media;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use Image;

class MediaController extends Controller
{
    public function store($channelId)
    {
        //code...
    }

    public function uploadMedia()
    {
        $uuid = Uuid::uuid4()->toString();

        $file = request()->file('media');

        $extension = $file->extension();

        $filename = "$uuid.$extension";

        $file->storeAs('public/media/', $filename);

        $url = Storage::url("public/media/$filename");

        return $url;
    }

    public function uploadCover()
    {
        $uuid = Uuid::uuid4()->toString();

        $img = Image::make(request()->file('image'));
        if ($img->height() >= $img->width()) {
            $img->resize(400, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        } else {
            $img->resize(null, 400, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $img->save(storage_path('app/public/covers/' . $uuid . '.jpg'));
        $url = url('storage/' . $uuid . '.jpg');
        return $url;
    }

    public function getLatestSubscribedMedia()
    {
        $user = User::find(1);
        $media = Media::whereHas('channel', function ($query) use ($user) {
            $query->join('channel_user', function ($join) use ($user) {
                $join->on('channels.id', '=', 'channel_user.channel_id')
                    ->where('channel_user.user_id', $user->id);
            });
        })->with('channel')->take(20)->get(); //we can use pagination in next step...
        return response()->json($media);
    }
}
