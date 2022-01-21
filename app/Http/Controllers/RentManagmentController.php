<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\RentManagment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentManagmentController extends Controller
{
    public function buyBookOnRent(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'userId' => 'required|numeric',
            'bookId' => 'required|numeric',
            'rentForDays' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ]);
        }

        try {

            $userExist = User::find($request->userId);

            if (!$userExist) {
               throw new \Exception('User ID does not Exist');
            }

            $bookExist = Book::find($request->bookId);

            if (!$bookExist) {
                throw new \Exception('Book ID does not Exist');
             }

            $newBook = new RentManagment();

            $newBook->user_id       = $request->userId;
            $newBook->book_id       = $request->bookId;
            $newBook->rent_for_days = $request->rentForDays;
            $newBook->return_status = 'N';

            $newBook->save();

            return response()->json([
                'status' => true,
                'message' => "User had Successfully buy book on rent!",
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }

    }


    public function returnRentedBook(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'rentId' => 'required|numeric',
            'returnBook' => 'in:Y,N',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "message" => $validator->errors(),
            ]);
        }

        try {

            $rentExist = User::find($request->rentId);

            if (!$rentExist) {
               throw new \Exception('Rent ID does not Exist');
            }

            $updateRentStatus = RentManagment::where('id', $request->rentId)->update([
                'return_status' => 'Y'
            ]);

            if (!$updateRentStatus) {
                throw new \Exception('Something went wrong!');
            }

            return response()->json([
                'status' => true,
                'message' => "User had Successfully returned rented book!",
            ], 200);

        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 200);
        }

    }

}
