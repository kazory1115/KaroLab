<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\Blog;

class BlogController extends Controller
{
    protected $customMessages = [
        'title.required' => '標題是必填的。',
        'content.required' => '內容是必填的。',
        'title.max' => '標題長度不能超過 255 個字。',
    ];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 取得所有部落格文章，依建立時間由新到舊排序
        $blogs = Blog::orderBy('created_at', 'desc')->limit(10)->get();

        // 回傳 JSON 格式的資料
        return response()->json([
            'status' => 'success',
            'data' => $blogs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        try {
            // 驗證輸入資料並使用自訂錯誤訊息
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ], $this->customMessages);

            /**
             * strip_tags(...)：移除所有 HTML 標籤。
             * trim(...)：移除字串前後空白。
             * mb_substr(...)：取前 20 個字元，支援多位元語系（如中文），避免亂碼。
             */
            $summary = mb_substr(trim(strip_tags($validatedData['content'])), 0, 20);

            $validatedData['summary'] = $summary;

            // 開始資料庫交易
            DB::beginTransaction();

            // 在這裡執行資料庫操作
            $blog = Blog::create($validatedData);  // 使用已驗證的資料來創建新文章

            DB::commit();  // 提交交易

            // 統一的回應格式
            return response()->json([
                'status' => 'success',
                'message' => '成功儲存',
                'data' => $blog  // 返回創建的文章資料
            ], 201); // 回應 201 Created 表示新創建的資源已經在伺服器上生成。
        } catch (\Illuminate\Validation\ValidationException $e) {
            // 驗證錯誤的回應
            return response()->json([
                'status' => 'error',
                'message' => '資料驗證失敗',
                'errors' => $e->errors()  // Laravel 會自動收集所有驗證錯誤
            ], 422);  // 422 Unprocessable Entity 表示資料無法處理
        } catch (\Exception $e) {
            // 發生錯誤時回滾交易
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => '儲存失敗',
                'error' => $e->getMessage()  // 詳細錯誤訊息
            ], 500);  // 回應 500 表示伺服器錯誤
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 取得單篇部落格文章
        $blog = Blog::find($id);

        if (empty($blog)) {
            return response()->json([
                'status' => 'error',
                'message' => '找不到該文章'
            ], 404);
        }
        // 回傳 JSON 格式的資料
        return response()->json([
            'status' => 'success',
            'data' => $blog
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // 驗證輸入資料並使用自訂錯誤訊息
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ], $this->customMessages);

            /**
             * strip_tags(...)：移除所有 HTML 標籤。
             * trim(...)：移除字串前後空白。
             * mb_substr(...)：取前 20 個字元，支援多位元語系（如中文），避免亂碼。
             */
            $summary = mb_substr(trim(strip_tags($validatedData['content'])), 0, 20);

            $validatedData['summary'] = $summary;

            // 開始資料庫交易
            DB::beginTransaction();

            // 在這裡執行資料庫操作
            $blog = Blog::where('id',$id)->update($validatedData);  // 使用已驗證的資料來創建新文章

            DB::commit();  // 提交交易

            // 統一的回應格式
            return response()->json([
                'status' => 'success',
                'message' => '成功更新',
                'data' => $blog  // 返回創建的文章資料
            ], 201); // 回應 201 Created 表示新創建的資源已經在伺服器上生成。
        } catch (\Illuminate\Validation\ValidationException $e) {
            // 驗證錯誤的回應
            return response()->json([
                'status' => 'error',
                'message' => '資料驗證失敗',
                'errors' => $e->errors()  // Laravel 會自動收集所有驗證錯誤
            ], 422);  // 422 Unprocessable Entity 表示資料無法處理
        } catch (\Exception $e) {
            // 發生錯誤時回滾交易
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => '儲存失敗',
                'error' => $e->getMessage()  // 詳細錯誤訊息
            ], 500);  // 回應 500 表示伺服器錯誤
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
