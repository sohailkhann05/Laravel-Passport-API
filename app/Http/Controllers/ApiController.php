<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Book;
use App\User;
use Auth;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = request(['email', 'password']);

        if(!Auth::attempt($credentials))
            return response()->json(['status' => 401, 'message' => 'Invalid email or Password', 'data' => '']);

        $params = $request->only('email', 'password');
        $email = $params['email'];
        $password = $params['password'];

        Auth::attempt(['email' => $email, 'password' => $password]);

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        $data =  [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ];

        return response()->json(['status' => 200, 'message' => 'Login successfully', 'data' => $data]);
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'attachment_id' => 1,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();

        $data =  [
            'user' => $user,
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
        ];

        return response()->json(['status' => 200, 'message' => 'Successfully created user', 'data' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function books(Request $request)
    {
        $books = Book::where('user_id', \Auth::id())->select('id', 'title', 'author', 'isbn')->get();

        return response()->json(['status' => 200, 'message' => '', 'data' => $books]);
    }

    public function addBook(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'author' => 'required|string',
            'isbn' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $user = $request->user();
        $book = Book::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'description' => $request->description
        ]);

        return response()->json(['status' => 200, 'message' => 'Book added successfully', 'data' => $book]);
    }

    public function showBook(Request $request)
    {
        $book = Book::find($request->id);
        if (!$book)
            return response()->json(['status' => 200, 'message' => 'No book record found', 'data' => '']);

        return response()->json(['status' => 200, 'message' => 'Book retrieved successfully', 'data' => $book]);
    }

    public function editBook(Request $request)
    {
        $book = Book::find($request->id);
        if (!$book)
            return response()->json(['status' => 200, 'message' => 'No book record found', 'data' => '']);

        return response()->json(['status' => 200, 'message' => 'Book retrieved successfully', 'data' => $book]);
    }

    public function updateBook(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'author' => 'required|string',
            'isbn' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $book = Book::find($request->id);
        if (!$book)
            return response()->json(['status' => 200, 'message' => 'No book record found', 'data' => '']);
        
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'description' => $request->description
        ]);

        return response()->json(['status' => 200, 'message' => 'Book updated successfully', 'data' => $book]);
    }

    public function deleteBook(Request $request)
    {
        $book = Book::find($request->id);
        if (!$book)
            return response()->json(['status' => 200, 'message' => 'No book record found', 'data' => '']);
        $book->delete();

        return response()->json(['status' => 200, 'message' => 'Book deleted successfully', 'data' => '']);
    }
}
