<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{
    public function index($video)
    {
        $video = Video::find($video);

        $comments = Comment::with(['user', 'repliesRecursive.user'])
            ->where('video_id', $video->id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($comment) {
                $comment->replies = $comment->repliesRecursive;
                unset($comment->repliesRecursive);
                return $comment;
            });

        return response()->json([
            'success' => true,
            'count' => $comments->count(),
            'comments' => $comments,
        ]);
    }

    public function store(Request $request, $video)
    {
        $video = Video::find($video);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Giriş yapılmadı.'], 401);
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
            'parent_id' => ['nullable','integer', Rule::exists('comment','id')],
        ]);

        // Eğer parent_id verilmişse, onun aynı videoya ait olduğunu doğrula
        if ($request->parent_id) {
            $parent = Comment::find($request->parent_id);
            if (!$parent || $parent->video_id !== $video->id) {
                return response()->json(['success' => false, 'message' => 'Geçersiz parent_id.'], 422);
            }
        }

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $video->id,
            'comment' => $request->comment,
            'parent_id' => $request->parent_id ?? null,
        ]);

        // eager load user (dönüşte frontend için)
        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => $comment,
        ]);
    }

    public function reply(Request $request, $video)
    {
        $video = Video::find($video);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Giriş yapılmadı.'], 401);
        }

        $request->validate([
            'comment' => 'required|string|max:1000',
            'parent_id' => ['required','integer', Rule::exists('comment','id')],
        ]);

        $parent = Comment::find($request->parent_id);
        if (!$parent || $parent->video_id !== $video->id) {
            return response()->json(['success' => false, 'message' => 'Geçersiz parent_id.'], 422);
        }

        $reply = Comment::create([
            'user_id' => Auth::id(),
            'video_id' => $video->id,
            'comment' => $request->comment,
            'parent_id' => $request->parent_id,
        ]);

        $reply->load('user');

        return response()->json([
            'success' => true,
            'reply' => $reply,
        ]);
    }

    public function destroy(Request $request, $video)
    {
        $video = Video::find($video);

        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Giriş yapılmadı.'], 401);
        }

        $request->validate([
            'id' => 'required|integer|exists:comment,id',
        ]);

        $comment = Comment::where('id', $request->id)
            ->where('user_id', Auth::id())
            ->where('video_id', $video->id)
            ->first();

        if (!$comment) {
            return response()->json(['success' => false, 'message' => 'Yorum bulunamadı veya yetkiniz yok.'], 404);
        }

        $comment->delete();

        return response()->json(['success' => true, 'message' => 'Yorum silindi.']);
    }
}
