<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{

    public function edit(Request $request, $community, $id = null)
    {
        return view('post.create', [
            'user' => $request->user(),
            'community' => Community::where("name", $community)->first(),
            'userCommunities' => $request->user()->communities()->get(),
            'action' => $id ? 'post.update' : 'post.create',
            'post' => $id ? Post::whereId($id)->first() : null,
        ]);
    }

    public function create(PostCreateRequest $request, $community)
    {
        $post = new Post;
        return $this->saveAndViewPost($request, $community, $post);
    }

    public function update(PostCreateRequest $request, $community, $id)
    {
        $post = Post::whereId($id)->first();
        return $this->saveAndViewPost($request, $community, $post);
    }

    public function delete(Request $request, $community, $id)
    {
        Post::whereId($id)->delete();
        return Redirect::route('dashboard');
    }

    public function view(Request $request, $community, $id)
    {
        return view('post.view', [
            'user' => $request->user(),
            'community' => Community::where("name", $community)->first(),
            'post' => Post::whereId($id)->first(),
        ]);
    }


    private function saveAndViewPost($request, $community, $post)
    {
        $validated = $request->validated();

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
        $post->community_id = Community::where("name", $community)->first()->id;

        $post->save();
        return Redirect::route('post.view', ['community' => $community, 'id' => $post->id]);
    }
}
