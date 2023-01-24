<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CommentsController extends Controller
{
    public function getComments(Request $request, $sort = '', $order = '') {
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
            return $result->reverse()->paginate(10);
        }

        return $result->paginate(10);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
