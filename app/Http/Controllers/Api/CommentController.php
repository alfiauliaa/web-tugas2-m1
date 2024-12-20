<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index()
    {
        //get all posts
        $comment = Comment::latest()->paginate(5);
        //return collection of posts as a resource
        return new CommentResource(true, 'List Data Posts', $comment);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'komentar' => 'required',

        ]);
        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $comment = Comment::create([
            'nama' => $request->nama,
            'komentar' => $request->komentar,
        ]);
        //return response
        return new CommentResource(true, 'Data Post Berhasil Ditambahkan!', $comment);
    }

    public function update(Request $request, $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'komentar' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $post = Comment::find($id);


        $post->update([
            'nama'     => $request->nama,
            'komentar'   => $request->komentar,
        ]);


        //return response
        return new CommentResource(true, 'Data Post Berhasil Diubah!', $post);
    }

    public function destroy($id)
    {

        //find post by ID
        $comment = Comment::find($id);

        //delete image


        //delete post
        $comment->delete();

        //return response
        return new CommentResource(true, 'Data Post Berhasil Dihapus!', null);
    }
}
