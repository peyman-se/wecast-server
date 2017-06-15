<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Comment;
use App\Media;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;
use Image;
use Auth;

class MediaController extends Controller
{
    public function store($channelId)
    {
        $channel = Channel::findOrFail($channelId);
        $channel->media()->create(request()->all());
        return response()->json(Channel::find($channel->id));
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
        $user = Auth::user();
        $media = Media::whereHas('channel', function ($query) use ($user) {
            $query->join('channel_user', function ($join) use ($user) {
                $join->on('channels.id', '=', 'channel_user.channel_id')
                    ->where('channel_user.user_id', $user->id);
            });
        })->with('channel')->withCount('likes', 'comments')->take(20)->get(); //we can use pagination in next step...
        return response()->json($media);
    }

    public function like($mediaId)
    {
        $media = Media::findOrFail($mediaId);
        $media->likes()->create([
            'user_id' => Auth::id()
        ]);
        return response('', 204);
    }

    public function dislike($mediaId)
    {
        $media = Media::findOrFail($mediaId);
        $like = $media->likes()->whereUserId(Auth::id())->first();
        
        if (!$like) {
            abort(404);
        }

        $like->delete();
        return response('', 204);
    }

    public function createComment($mediaId)
    {
        $media = Media::findOrFail($mediaId);
        $comment = $media->comments()->create([
            'user_id' => Auth::id(),
            'body' => request('body')
        ]);

        return response()->json(Comment::find($comment->id));
    }

    public function getComments($mediaId)
    {
        return response()->json(Media::findOrFail($mediaId)->comments);
    }
}
