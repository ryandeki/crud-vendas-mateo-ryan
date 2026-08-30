<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;

class MainController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('home', ['items' => $items]);
    }

    public function categories()
    {

        $categories = User::find(session('user')['id'])->categories;
        return view('categories', ['categories' => $categories]);
    }

    public function items()
    {
        $items = User::find(session('user')['id'])->items;
        return view('items.items', ['items' => $items]);
    }

    public function newItem()
    {
        $categories = User::find(session('user')['id'])->categories;

        return view('items.new_item', ['categories' => $categories]);
    }

    public function newItemSubmit(Request $request)
    {
        $request->validate([
            'text_title' => 'required|max:50|min:3',
            'category' => ['required', Rule::notIn([route('new')])],
            'price' => 'required|decimal:0,2',
            'description' => 'max:200',
        ], [
            'text_title.required' => 'O nome é obrigatório',
            'text_title.max' => 'O nome deve conter no máximo :max caracteres',
            'text_title.min' => 'O nome deve conter no mínimo :min caracteres',

            'category.required' => 'Selecione uma categoria',
            'category.not_in' => 'Selecione uma categoria',

            'price.required' => 'O preço é obrigatório',
            'price.decimal' => 'O preço deve ser um número com no máximo 2 casas decimais',

            'description' => 'A descrição deve conter no máximo :max caracteres',
        ]);

        $item = new Item();
        $item->user_id = session('user')['id'];
        $item->category_id = Category::where('nome', $request->category)->first()->id;
        $item->nome = $request->text_title;
        $item->estado = $request->status;
        $item->preco = $request->price;
        $item->descricao = $request->description;
        $item->save();

        return redirect()->route('home');
    }

    public function editItem($id)
    {
        $decrypted_id = Operations::decryptId($id);
        $item = Item::find($decrypted_id);

        if (!$item || $item->user_id != session('user')['id']) {
            return redirect()->route('home');
        }

        $categories = User::find(session('user')['id'])->categories;

        return view('items.edit_item', ['item' => $item, 'categories' => $categories]);
    }

    public function editItemSubmit(Request $request)
    {
        if ($request->item_id === null) {
            return redirect()->route('home');
        }

        $request->validate([
            'text_title' => 'required|max:50|min:3',
            'category' => ['required', Rule::notIn([route('new')])],
            'price' => 'required|decimal:0,2',
            'description' => 'max:200',
        ], [
            'text_title.required' => 'O nome é obrigatório',
            'text_title.max' => 'O nome deve conter no máximo :max caracteres',
            'text_title.min' => 'O nome deve conter no mínimo :min caracteres',

            'category.required' => 'Selecione uma categoria',
            'category.not_in' => 'Selecione uma categoria',

            'price.required' => 'O preço é obrigatório',
            'price.decimal' => 'O preço deve ser um número com no máximo 2 casas decimais',

            'description' => 'A descrição deve conter no máximo :max caracteres',
        ]);

        $decrypted_id = Operations::decryptId($request->item_id);
        $item = Item::find($decrypted_id);

        if (!$item || $item->user_id != session('user')['id']) {
            return redirect()->route('home');
        }

        $item->category_id = Category::where('nome', $request->category)->first()->id;
        $item->nome = $request->text_title;
        $item->estado = $request->status;
        $item->preco = $request->price;
        $item->descricao = $request->description;
        $item->save();

        return redirect()->route('items');
    }

    public function deleteItem($id)
    {
        $decrypted_id = Operations::decryptId($id);
        $item = Item::find($decrypted_id);

        if (!$item || $item->user_id != session('user')['id']) {
            return redirect()->route('home');
        }

        return view('items.delete_item', ['item' => $item]);
    }

    public function deleteItemConfirm($id)
    {
        $decrypted_id = Operations::decryptId($id);
        $item = Item::find($decrypted_id);

        if (!$item || $item->user_id != session('user')['id']) {
            return redirect()->route('home');
        }

        $item->forceDelete();
        return redirect()->route('home');
    }

    public function toAccessItemPage($id)
    {
        $decrypted_id = Operations::decryptId($id);
        $item = Item::find($decrypted_id);
        if (!$item) {
            return redirect()->route('home');
        }
        return view('items.item_page', ['item' => $item]);
    }

    public function newCategory()
    {
        return view('new_category');
    }

    public function newCategorySubmit(Request $request)
    {
        $request->validate([
            'text_title' => 'required|min:3|max:50|unique:categories,nome',
        ], [
            'text_title.required' => 'O nome é obrigatório.',
            'text_title.min' => 'O nome deve ter pelo menos :min caracteres.',
            'text_title.max' => 'O nome deve ter no máximo :max caracteres.',
            'text_title.unique' => 'Já existe uma categoria com esse nome',
        ]);

        $id = session('user')['id'];

        $category = new Category();
        $category->user_id = $id;
        $category->nome = $request->text_title;
        $category->status = $request->status;
        $category->descricao = $request->text_note;
        $category->save();
        return redirect()->route('categories');
    }

    public function editCategory($id)
    {
        try {
            $decrypted_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }
        $category = Category::find($decrypted_id);
        return view('edit_category', ['category' =>  $category]);
    }

    public function editCategorySubmit(Request $request)
    {
        if ($request->category_id === null) {
            return redirect()->route('categories');
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
        return redirect()->route('categories');
    }

    public function deleteCategory($id)
    {
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

    public function deleteCategoryConfirm($id)
    {
        $decrypted_id = Crypt::decrypt($id);
        $category = Category::find($decrypted_id);
        if (!$category) {
            return redirect()->route('home');
        }
        $category->forceDelete();
        return redirect()->route('categories');
    }

    public function toAccessCategory($id)
    {
        $decrypted_id = Crypt::decrypt($id);
        $category = Category::find($decrypted_id);
        if (!$category) {
            return redirect()->route('home');
        }
        return view('category_page', ['category' => $category]);
    }
}
