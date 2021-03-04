<?php 
namespace App\Services;
use App\Book;

class BooksService
{
	public function isValidISBN($number)
    {
    	if(strlen($number) < 10) return false;

    	$multiplier = 10;
    	$sum = 0;
    	
    	for($i=0; $i<10; $i++){
    		$sum = $sum + $number[$i] * $multiplier;
    		$multiplier--;
    	}

    	$reminder = $sum % 11;

    	if($reminder) return false;
    	
    	return true;
    }

    public function updateBookStatus($bookId, $action)
    {
    	$status = 'AVAILABLE';
    	
    	if($action == 'CHECKOUT') {
    		$status = 'CHECKED_OUT';
    	}

    	Book::where('id', $bookId)->update(['status' => $status]);

    	return true;
    }

    public function isBookAvailable($bookId)
    {
    	$isAvailable = Book::where(['id' => $bookId,'status' => 'AVAILABLE'])->exists();
    	
        return ($isAvailable);
    }
}