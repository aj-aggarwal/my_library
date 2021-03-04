<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use Exception;
use App\UserActionLog;
use App\Book;
use Crypt;
use App\Services\BooksService;

class CheckInCheckOutController extends Controller
{
    protected $bookService;

    public function __construct(BooksService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Check In/ CheckOut Books
     */
    public function userActions(Request $request)
    {
		$request->validate([
			'book_id'	=> 'required',
			'action'	=> 'required|in:CHECKIN,CHECKOUT'
		]);

    	try {
    		$input = $request->all();
    		$bookId = Crypt::decrypt($input['book_id']);
    		$book = Book::find($bookId);
    		if(!$book) {
    			return response(["message" => trans('messages.invalid_book_id')], 422);
    		}

            $isBookAvailable = $this->bookService->isBookAvailable($bookId);

    		// check book availability
    		if($input['action'] == 'CHECKOUT' && !$isBookAvailable) {
                return response(["message" => trans('messages.book_already_checkout')], 422);
	    	}

    		// check book already check in
    		if($input['action'] == 'CHECKIN' && $isBookAvailable) {
    			return response(["message" => trans('messages.book_already_checkin')], 422);
	    	}

    		// create user action log
    		$data['user_id'] = auth()->id();
    		$data['book_id'] = $bookId;
    		$data['action']  = $input['action'];
    		UserActionLog::create($data);

    		// Update book status
   			$this->bookService->updateBookStatus($bookId, $input['action']);

            if($input['action'] == 'CHECKIN') {
                return response(["message" => trans('messages.checked_in_success')], 200);
            }else {
                return response(["message" => trans('messages.checked_out_success')], 200);
            }
   			
    	} catch (Exception $e) {
            Log::error($e);
    		return response([
    			"message" => trans('messages.something_went_wrong'),
    			"error_detail" => $e->getMessage(),
    		], 500);
    	}
    }
}
