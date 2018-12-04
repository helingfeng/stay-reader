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
        return DB::table('sr_book')->where($condition)->simplePaginate(request()->input('per_page', 15));
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
        return get_object_vars(DB::table('sr_book')->where(['book_id' => $bookId])->get()->first());
    }

    public function novelChapterContent($bookId, $chapterId)
    {
        return DB::table('sr_book_contents')->where(['book_id' => $bookId, 'id' => $chapterId])->get();
    }
}