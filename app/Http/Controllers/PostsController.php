<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Parsedown;

class PostsController extends Controller
{
    /**
     * Posts Detail
     * @param string $slug
     * @return JsonResponse
     */
    public function detail(string $slug):JsonResponse
    {
        $slug = urldecode($slug);
        $slug = strtolower($slug);
        $posts = $this->getPosts();
        $title = str_replace('-', ' ', $slug);
        if (in_array($slug, $posts)) {
            $content = file_get_contents(base_path('posts/'.$slug.'.md'));
            $parsedown = new Parsedown();
            return new JsonResponse([
                'title'=>ucfirst($title),
                'slug'=>$slug,
                'content'=>$parsedown->parse($content)
            ]);
        }
        return new JsonResponse(['error' => 'Post not found'], 404);
    }

    /**
     * Posts Lists
     * @return JsonResponse
     */
    public function list()
    {
        $posts = $this->getPosts();
        return new JsonResponse($posts);
    }

    /**
     * Get posts
     * @return array
     */
    protected function getPosts():array
    {
        $list = scandir(base_path('posts'));
        $posts = [];
        foreach ($list as $value) {
            if ($value == '.' || $value == '..') {
                continue;
            }
            if (substr_count($value, '.md') == 0) {
                continue;
            }
            $value = str_replace('.md', '', $value);
            $posts[] = strtolower($value);
        }
        return $posts;
    }
    //
}
