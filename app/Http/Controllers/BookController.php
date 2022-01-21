<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bookName' => 'required',
            'author' => 'required',
            'coverImage' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ]);
        }

        try {

            $newBook = new Book();

            $newBook->book_name   = $request->bookName;
            $newBook->author      = $request->author;
            $newBook->cover_image = $request->coverImage;

            $newBook->save();

            return response()->json([
                'status' => true,
                'message' => "Book Added Successfully!",
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }

    }

    public function getAll($bookId = null)
    {
        try {

            if ($bookId) {

                $data = Book::find($bookId);

                return response()->json([
                    'status' => true,
                    'message' => "Book Details",
                    'data' => $data
                ], 200);

            }else{
                $allData = Book::all();
                $data = [];
                foreach ($allData as $key => $value) {
                    $setData = [
                        'bookName' => $value->book_name,
                        'author' => $value->author,
                        'coverImage' => $value->cover_image
                    ];

                    array_push($data, $setData);
                }

                return response()->json([
                    'status' => true,
                    'message' => "All Book Details",
                    'data' => $data
                ], 200);

            }

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }

    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bookId' => 'required|numeric',
            'author' => 'required',
            'coverImage' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ]);
        }

        try {

            $updateBook = Book::where('b_id', $request->bookId)->update([
                'author' => $request->author,
                'cover_image' => $request->coverImage,
            ]);

            if ($updateBook) {

                $data = Book::find($request->bookId);

                return response()->json([
                    'status' => true,
                    'message' => "Book Details Updated Successfully!",
                    'data' => $data
                ], 200);

            }else{
                throw new \Exception('data does not exist for this book id');
            }

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bookId' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ]);
        }

        try {

            $deleteBook = Book::where('b_id', $request->bookId)->delete();

            if ($deleteBook) {

                return response()->json([
                    'status' => true,
                    'message' => "Data deleted Successfully!"
                ], 200);

            }else{
                throw new \Exception('data does not exist for this book id');
            }

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }

    }

}
