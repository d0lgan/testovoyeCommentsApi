<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function getComments($sort = '', $order = '') {
        $comments = Comment::with( 'user')->withCount('likes');

        if ($sort == 'sort_by_users') {
            $result = $comments->get()->sortBy(function($value, $key) {
                return $value['user']['name'];
            });
        } elseif ($sort == 'sort_by_date') {
            $result = $comments->orderBy('updated_at', 'desc')->get(); // Самые новые
        } elseif ($sort == 'sort_by_likes') {
            $result = $comments->orderBy('likes_count', 'desc')->get(); // От самого залайконного к менее
        } else {
            $result = $comments->get();
        }

        if ($order == 'reverse') {
            return $result->reverse();
        }

        return $result;
    }
}
