<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Fungsi untuk menampilkan semua postingan
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'message' => 'Berhasil mengambil semua postingan',
            'data' => $posts
        ]);
    }

}
