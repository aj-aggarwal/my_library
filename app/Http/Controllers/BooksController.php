<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Log;
use Exception;
use App\Services\BooksService;

class BooksController extends Controller
{
    protected $bookService;

    public function __construct(BooksService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * List all books
     */
    public function list(Request $request)
    {
        try{
            $list = Book::get();

            return response(['data' => $list]);
        } catch (Exception $e) {
            Log::error($e);

            return response([
                "message" => trans('messages.something_went_wrong'),
                "error_detail" => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add a new book
     */
    public function create(Request $request)
    {
		$request->validate([
    		'title' => 'required',
    		'isbn'	=> 'required|numeric|digits:10',
    		'published_at'	=> 'required|date|date_format:Y-m-d',
    	]);

    	try {

	    	$input = $request->all();

            // Validate the ISBN number
	    	$isValid = $this->bookService->isValidISBN($input['isbn']);
	    	if(!$isValid) {
                /// Invalid ISBN error
				return response(["message" => trans('messages.invalid_isbn')], 422);
	    	}

            //Create Book
	    	Book::create($input);

			return response(["message" => trans('messages.book_added_success')], 200);
    	} catch (Exception $e) {
    		Log::error($e);

    		return response([
    			"message" => trans('messages.something_went_wrong'),
    			"error_detail" => $e->getMessage(),
    		], 500);
    	}
    }
}
