<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommunityResource;
use App\Models\Community;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CommunityResource::collection(Community::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner' => 'required|string'
        ]);

        $community = Community::create($validated);
        return new CommunityResource($community);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function show(Community $community)
    {
        if (!$community) {
            throw new ModelNotFoundException();
        }
        return new CommunityResource($community);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Community $community)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'banner' => 'string'
        ]);

        $community->update($validated);
        return new CommunityResource($community);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Community  $community
     * @return \Illuminate\Http\Response
     */
    public function destroy(Community $community)
    {
        $community->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
