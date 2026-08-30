<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index() {
        
        $categories = User::find(session('user')['id'])->categories;
        return view('home', ['categories' => $categories]);
    }

    public function newCategory() {
        return view('new_category');
    }

    public function newCategorySubmit(Request $request) {
        $request->validate([
            'text_title' => 'required|min:3|max:50',
        ], [
            'text_title.required' => 'O nome é obrigatório.',
            'text_title.min' => 'O nome deve ter pelo menos :min caracteres.',
            'text_title.max' => 'O nome deve ter no máximo :max caracteres.',
        ]);   
        
        $id = session('user')['id'];

        $category = new Category();
        $category->user_id = $id;
        $category->nome = $request->text_title;
        $category->status = $request->status;
        $category->descricao = $request->text_note;
        $category->save();
        return redirect()->route('home');
    }

    public function editCategory($id) {
        try {
            $decrypted_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }
        $category = Category::find($decrypted_id);
        return view('edit_category' , ['category' =>  $category]);
    }

    public function editCategorySubmit(Request $request) {
        if ($request->category_id === null) {
            return redirect()->route('home');
        }

        $request->validate([
            'text_title' => 'required|min:3|max:50',
        ], [
            'text_title.required' => 'O nome é obrigatório.',
            'text_title.min' => 'O nome deve ter pelo menos :min caracteres.',
            'text_title.max' => 'O nome deve ter no máximo :max caracteres.',
        ]);

        $id = Crypt::decrypt($request->category_id);

        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('home');
        }

        $category->nome = $request->text_title;
        $category->status = $request->status;
        $category->descricao = $request->text_note;
        $category->save();
        return redirect()->route('home');
    }

    public function deleteCategory($id) {
        try {
            $decrypted_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }
        $category = Category::find($decrypted_id);
        if (!$category) {
            return redirect()->route('home');
        }
        return view('delete_category', ['category' => $category]);
    }

    public function deleteCategoryConfirm($id) {
        $decrypted_id = Crypt::decrypt($id);
        $category = Category::find($decrypted_id);
        if (!$category) {
            return redirect()->route('home');
        }
        $category->forceDelete();
        return redirect()->route('home');
    }

    public function toAccessCategory($id) {
        $decrypted_id = Crypt::decrypt($id);
        $category = Category::find($decrypted_id);
        if (!$category) {
            return redirect()->route('home');
        }
        return view('category_page', ['category' => $category]);
    }
}