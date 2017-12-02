<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommentRequest;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['handleComment']]);
    }

    /**
     * 文章归档
     *
     * @param      $year
     * @param null $month
     * @param null $day
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archive($year, $month = null, $day = null)
    {
        if (! empty($year) && ! empty($month) && ! empty($day)) {

            // 如果是按日期归档
            $searchDate = Carbon::create($year, $month, $day);
            $startDate  = clone $searchDate;
            $endDate    = clone $searchDate;
            $from       = $startDate->startOfDay();
            $to         = $endDate->endOfDay();

            $title = sprintf('%d年%d月%d日', $year, $month, $day);

        } elseif (! empty($year) && ! empty($month)) {

            // 如果按月归档
            $searchDate = Carbon::create($year, $month);
            $startDate  = clone $searchDate;
            $endDate    = clone $searchDate;
            $from       = $startDate->startOfMonth();
            $to         = $endDate->endOfMonth();

            $title = sprintf('%d年%d月', $year, $month);

        } elseif (! empty($year)) {

            // 如果按年归档
            $searchDate = Carbon::create($year);
            $startDate  = clone $searchDate;
            $endDate    = clone $searchDate;
            $from       = $startDate->startOfYear();
            $to         = $endDate->endOfYear();

            $title = sprintf('%d年', $year);
        }

        $posts = Post::where('created_at', '>=', $from)
            ->where('created_at', '<=', $to)
            ->published()
            ->recent()
            ->with('tags')
            ->paginate(option('page_size', 20));

        return view('posts.index', compact('posts', 'title'));
    }

    /**
     * 查看单个文章
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $post = Post::query()->where('id', $id)
            ->published()
            ->firstOrFail();

        $post->load('user', 'comments.user');

        $post->views_count += 1;
        $post->save();

        $comments = $post->getComments();

        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * 评论文章
     *
     * @param CommentRequest $request
     * @param                $postId
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function handleComment(CommentRequest $request, $postId)
    {
        /* @var $post Post */
        $post = Post::find($postId);

        if (! $post || ! $post->exists) {
            return back()->withInput()->withErrors(['text' => '文章不存在']);
        }

        $comment           = new Comment($request->all());
        $comment->owner_id = $post->user_id;

        DB::beginTransaction();

        if (! $post->comments()->save($comment)) {

            DB::rollBack();

            return back()->withInput()->withErrors(['text' => '评论失败，请刷新后重试']);
        }

        DB::commit();

        return redirect()->to(route('posts.show', $post->id) . '#comment-' . $comment->id);
    }
}
