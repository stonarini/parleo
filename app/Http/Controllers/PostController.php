<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{

    public function edit(Request $request, Community $community, Post $post = null)
    {
        App::setLocale('es');
        return view('post.create', [
            'user' => $request->user(),
            'community' => $community,
            'userCommunities' => $request->user()->communities()->get(),
            'action' => $post ? 'post.update' : 'post.create',
            'post' => $post ?? null,
        ]);
    }

    public function save(PostCreateRequest $request, Community $community, Post $post = null)
    {
		$post = $post ?? new Post();
        $post->title = $request->title;
        if ($request->hasFile("image")) {
            $file = $request->image;
            $file->storeAs('public', hash('sha256', $post->id) . '.' . $file->guessClientExtension(), 'local');
            $post->image = '/img/p/' . $post->id;
        } else {
            $post->content = $request->text;
        }
        $post->date = new DateTime('now');
        $post->access = $request->access;
        $post->commentable = $request->boolean('commentable');

        $post->user_id = $request->user()->id;
        $post->community_id = $community->id;

        $post->save();
        return Redirect::route('post.view', ['community' => $community, 'post' => $post]);
    }


    public function delete(Request $request, $community, Post $post)
    {
        $request->user()->cannot('update', $post) ?? Response::deny('You do not own this post.');
        $post->delete();
        return Redirect::route('dashboard');
    }

    public function view(Request $request, Community $community, Post $post)
    {
        return view('post.view', [
            'user' => $request->user(),
            'community' => $community,
            'post' => $post,
        ]);
    }
}
