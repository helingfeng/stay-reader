<?php
/**
 * User: Chester
 */

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;

class NovelController
{
    public function novelList()
    {
        $condition = request()->except('page', 'per_page');
        return DB::table('sr_book')->where($condition)->orderBy('id','desc')->simplePaginate(request()->input('per_page', 15));
    }

    public function novelChapters($bookId)
    {
        return DB::table('sr_book_contents')->where(['book_id' => $bookId])->select('chapter', 'id')->get()->pluck('chapter', 'id');
    }

    public function novelContents($bookId)
    {
        return DB::table('sr_book_contents')->where(['book_id' => $bookId])->simplePaginate(request()->input('per_page', 15));
    }

    public function novelDetail($bookId)
    {
        $book = DB::table('sr_book')->where(['book_id' => $bookId])->get()->first();
        if ($book) {
            return get_object_vars($book);
        }
        return response()->json(['message' => '没有找到对应的书籍'], 404);
    }

    public function novelChapterContent($bookId, $chapterId)
    {
        $chapter = DB::table('sr_book_contents')->where(['book_id' => $bookId, 'id' => $chapterId])->first();
        if ($chapter) {
            return get_object_vars($chapter);
        }
        return response()->json(['message' => '没有找到对应章节'], 404);
    }
}