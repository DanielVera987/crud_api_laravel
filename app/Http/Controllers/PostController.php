<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $validationUser = User::find($user->id);

        if($validationUser)
        {
            $posts = Post::where('user_id', $user->id)->get();
            if($posts)
            {
                return response()->json([
                    'data' => [
                        'id' => $user->id,
                        'type' => 'Posts',
                        'posts' => $posts
                    ]
                ], 200);
            }
        }

        return response()->json([
            'error' => [
                'status' => '400',
                'code' => 'No se pudo obtener los posts'
            ]
        ], 400);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'contenido' =>  'required|string|max:255'
        ]);

        if($validate->fails()){
            return response()->json([
                'error' => [
                    'status' => 400,
                    'code' => $validate->errors(),
                    'details' => 'Error al procesar los datos'
                ]
            ], 400);
        }

        $data = $request->all();

        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->titulo = $data['titulo'];
        $post->contenido = $data['contenido'];
        $post->save();

        if(is_numeric($post->id))
        {
            return response()->json([
                'data' => [
                    'type' => 'post',
                    'id' => $post->id,
                    'attribute' => [
                        'post' => $post
                    ]
                ]
            ], 200);
        }

        return response()->json([
            'error' => [
                'status' => 500,
                'details' => 'Error al procesar los datos'
            ]
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validate =  Validator::make($request->all(),[
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string|max:255'
        ]);

        if($validate->fails())
        {
            return response()->json([
                'error' => [
                    'status' => '400',
                    'details' => 'Error al procesar los datos'
                ]
            ], 400);
        }

        $data = $request->all();
        
        $post->titulo = $data['titulo'];
        $post->contenido = $data['contenido'];
        $update = $post->save();

        if($update)
        {
            return response()->json([
                'data' => [
                    'type' => 'post',
                    'id' => $post->id,
                    'attribute' => $post
                ]
            ], 200);
        }

        return response()->json([
            'error' => [
                'status' => '400',
                'details' => 'Error al procesar los datos'
            ]
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return $post;
    }
}
