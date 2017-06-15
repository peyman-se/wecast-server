<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Comment;
use App\Like;
use Illuminate\Http\Request;
use Auth;

class ChannelController extends Controller
{
    public function create()
    {
        return response()->json(Auth::user()->channels()->create(request()->all()));
    }

    public function delete($channelId)
    {
        $channel = Channel::findOrFail($channelId);
        if (Auth::user()->id == $channel->user()->id) {
            $channel->delete();
            return response('', 204);
        }
        abort(422);
    }

    public function update($channelId)
    {
        $channel = Channel::findOrFail($channelId);
        if (Auth::user()->id == $channel->user()->id) {
            $channel->update(request()->all());
            return response()->json($channel);
        }
        abort(422);
    }

    public function getMedia($channelId)
    {
        return response()->json(Channel::findOrFail($channelId)->media()->with('channel')->get());
    }

    public function popular()
    {
        $channels = Channel::withCount('subscribers')->orderBy('subscribers_count', 'desc')->get()->take(10);

        return response()->json($channels);
    }

    public function getChannel($channelId)
    {
        return response()->json(Channel::findOrFail($channelId));
    }

    public function countChannels()
    {
        return response()->json(['channel_counts' => Channel::count()]);
    }

    public function like($channelId)
    {
        $channel = Channel::findOrFail($channelId);
        $channel->likes()->create([
            'user_id' => Auth::id()
        ]);
        return response('', 204);
    }

    public function dislike($channelId)
    {
        $channel = Channel::findOrFail($channelId);
        $like = $channel->likes()->whereUserId(Auth::id())->first();
        if (!$like) {
            abort(404);
        }

        $like->delete();
        return response('', 204);
    }

    public function comment($channelId)
    {
        $channel = Channel::findOrFail($channelId);
        $comment = $channel->comments()->create([
            'user_id' => Auth::id(),
            'body' => request('body')
        ]);

        return response()->json(Comment::find($comment->id));
    }

//    public function updateTags($formId)
//    {
//        //validate
//
//        $form = Form::findOrFail($formId);
//        $tags = request()->intersectKeys(Tag::pluck('name')->all());
//        foreach ($tags as $key => $value) {
//            if ($value) {
//                $form->tags()
//                    ->syncWithoutDetaching(Tag::whereName($key)->first()->id);
//            } else {
//                $form->tags()->detach(Tag::whereName($key)->first()->id);
//            }
//        }
//        return response()->json($form->tags);
//    }
//
//    public function searchByTag()
//    {
//        //validate
//
//        $tags = explode(',', request('tags'));
//        $query = Form::query();
//        $query
//            ->join('taggables', 'taggables.taggables_id', '=', 'forms.id')
//            ->where('taggables.taggables_type', 'App\Form')
//            ->whereIn('taggables.tag_id', $tags);
//
//        $forms = $query->get()->groupBy('id');
//
//        $sorted = $forms->filter(function ($value, $key) use ($tags) {
//            return $value->count() == count($tags);
//        }); //returnes onlu those forms which have all tags
//
////        $sorted = $forms->sortByDesc(function ($value, $key) {
////            return $value->count();
////        }); // returns those forms that have one or all tags
//
//        $sorted = $sorted->map(function ($values) {
//            return $values->first();
//        });
//
//        return response()->json($sorted->values());
//    }
}
