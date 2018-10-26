<?php

namespace App\Http\Controllers;

use App\Post;
use App\Topic;
use App\Like;
use Illuminate\Http\Request;
use App\Transformers\LikeTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class PostLikeController extends Controller
{
    public function index()
    {
    	$likes = Like::latestFirst()->paginate(10);
    	$likesCollection = $likes->getCollection();
    	
    	return fractal()
    		->collection($likesCollection)
    		->parseIncludes(['user'])
    		->transformWith(new LikeTransformer)
    		->paginateWith(new IlluminatePaginatorAdapter($likes))
    		->toArray();
    }
    
    public function store(Request $request, Topic $topic, Post $post)
    {
        $this->authorize('like', $post);
        
    	$like = new Like;
    	
    	if($request->user()->hasLikedPost($post))
        {
        	return response(null, 409);
        }

    	
    	$like->user()->associate($request->user());
    
    	$post->likes()->save($like);
    
    	return response(null, 204);
    }
    
    public function destroy(Request $request, Topic $topic, Post $post, Like $like)
    {
        $this->authorize('like', $post);
        
        if($request->user()->hasLikedPost($post))
        {
            $like->delete();
    	
    	    return response(null, 204);
        }
        else{
            return response(null, 409);
        }
        
    	
    }
}
