<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeApiController extends BaseController
{
   public function home(){
    $posts = Post::all();

    return $this->sendResponse($posts, 'Data Fetched successfully.');

   }
}
