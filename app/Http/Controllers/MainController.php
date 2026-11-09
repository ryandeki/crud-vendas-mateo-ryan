<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Review;
use App\Models\Adress;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
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
        return view('categories.categories', ['categories' => $categories]);
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
        $item = Item::withTrashed()->where('id', $decrypted_id)->first();

        if (!$item || $item->user_id != session('user')['id']) {
            return redirect()->route('home');
        }

        return view('items.delete_item', ['item' => $item]);
    }

    public function deleteItemConfirm($id)
    {
        $decrypted_id = Operations::decryptId($id);
        $item = Item::withTrashed()->where('id', $decrypted_id)->first();

        if (!$item || $item->user_id !== session('user')['id']) {
            return redirect()->route('home');
        }

        if ($item->deleted_at !== null) {
            $item->forceDelete();
        }
        else {
            $item->delete();
        }
        
        return redirect()->route('home');
    }

    public function restoreItem($id) {
        $decrypted_id = Operations::decryptId($id);
        $item = Item::onlyTrashed()->where('id', $decrypted_id)->first();

        if (!$item || $item->user_id !== session('user')['id']) {
            return redirect()->route('home');
        }

        $item->restore();

        return redirect()->back();
    }

    public function trashItems() {
        $items = Item::onlyTrashed()->where('user_id', session('user')['id'])->get();
        return view('items.trash_items', ['items' => $items]);
    }

    public function toAccessItemPage($id) {
        $decrypted_id = Operations::decryptId($id);

        $item = Item::with(['reviews' => function($query) {
            $query->orderBy('created_at', 'asc');
        }, 'reviews.user'])->find($decrypted_id);

        if (!$item) {
            return redirect()->route('home');
        }

        return view('items.item_page', ['item' => $item]);
    }

    public function newCategory()
    {
        return view('categories.new_category');
    }

    public function newCategorySubmit(Request $request)
    {
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
        return redirect()->route('categories');
    }

    public function editCategory($id)
    {
        
        $decrypted_id = Operations::decryptId($id);
        
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

        $id = Operations::decryptId($request->category_id);

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
        
        $decrypted_id = Operations::decryptId($id);
       
        $category = Category::find($decrypted_id);
        if (!$category) {
            return redirect()->route('home');
        }
        return view('delete_category', ['category' => $category]);
    }

    public function deleteCategoryConfirm($id)
    {
        $decrypted_id = Operations::decryptId($id);
        $category = Category::find($decrypted_id);
        if (!$category) {
            return redirect()->route('home');
        }
        $category->forceDelete();
        return redirect()->route('categories');
    }

    public function toAccessCategory($id)
    {
        $decrypted_id = Operations::decryptId($id);
        $category = Category::find($decrypted_id);
        if (!$category) {
            return redirect()->route('home');
        }
        return view('category_page', ['category' => $category]);
    }

    public function toUserPage() {
        $user = User::where('username', session('user')['username'])
        ->whereNull('deleted_at')->first();

        if (!$user) {
            return redirect()->route('home');
        }

        return view('users.user_page', compact('user'));
    }

    public function toEditUserPage(Request $request) {
        $id = $request->query('id');
        $decrypted_id = Operations::decryptId($id);
        $user = User::find($decrypted_id);

        if (!$user || session('user')['id'] !== $user->id) {
            return redirect()->route('home');
        }

        return view('users.edit_user', compact('user'));
    }
    
    public function editUserConfirm(Request $request) {
        $decrypted_id = Operations::decryptId($request->id);
        $user = User::find($decrypted_id);
        
        $username = $request->text_username;
        $email = $request->text_email;
        $new_password = $request->new_password;

        $request->validate([
            'text_username' => 'min:3|max:50|different:field',
            'text_email' => ['email', 'max:80', Rule::unique('users', 'email')->ignore($user->id)],
            'new_password' => [Rule::excludeIf(empty($new_password)), 'min:6', 'max:16', 'different:current_password'],
            'current_password' => 'required'
        ], [
            'text_username.required' => 'O nome de usuário é obrigatório',
            'text_username.min' => 'O nome de usuário deve conter no mínimo :min caracteres',
            'text_username.max' => 'O nome de usuário deve conter no máximo :max caracteres',
            'text_username.unique' => 'Esse nome de usuário não está disponível',

            'text_email.required' => 'O campo de e-mail é obrigatório',
            'text_email.email' => 'O e-mail deve conter um endereço válido.',
            'text_email.max' => 'O e-mail deve conter no máximo :max caracteres',
            'text_email.unique' => 'Esse e-mail já está sendo utilizado',

            'new_password.required' => 'O campo de senha é obrigatório',
            'new_password.min' => 'A senha deve conter no mínimo :min caracteres',
            'new_password.max' => 'A senha deve conter no máximo :max caracteres',
            'new_password.different' => 'A nova senha não pode ser a mesma que a atual',

            'current_password.required' => 'A sua senha é necessária para aplicar as alterações'
        ]);

        $current_password = $request->current_password;

        if (!password_verify($current_password, $user->senha)) {
            return redirect()->back()->withInput()->with('edit_error', 'Senha incorreta');
        }
        
        $user->username = $username;
        $user->email = $email;

        if (!empty($new_password)) {
            $user->senha = bcrypt($new_password);
        }
        $user->save();

        return redirect()->route('user.edit.page')->withInput(['edit_success', 'Alterações salvas com sucesso']);
    }

    public function toEditAdressPage(Request $request) {
        $id = $request->query('id');
        $decrypted_id = Operations::decryptId($id);
        $user = User::find($decrypted_id);

        if (!$user || session('user')['id'] !== $user->id) {
            return redirect()->route('home');
        }

        return view('users.edit_adress', compact('user'));
    }

    public function editAdressConfirm(Request $request) {
        $request->validate([
            'input_cep' => 'required|digits:8|integer',
            'input_numero' => 'required|integer',
            'current_password' => 'required',
        ], [
            'input_cep.required' => 'O CEP é obrigatório',
            'input_cep.digits' => 'O CEP deve haver, exatamento, :digits digitos',
            'input_cep.integer' => 'O CEP deve conter apenas números',

            'input_numero.required' => 'O número do endereço é obrigatório',
            'input_numero.integer' => 'O número do endereço deve ser um número inteiro',

            'current_password' => 'A sua senha é necessária para aplicar as alterações',
        ]);

        $decrypted_id = Operations::decryptId($request->id);
        $user = User::find($decrypted_id);

        if (!$user || session('user')['id'] !== $user->id) {
            return redirect()->route('home');
        }

        $password = $request->current_password;

        if (password_verify($password, $user->password)) {
            return redirect()->back()->withInput()->with('edit_error', 'Senha incorreta');
        }

        $adress = new Adress();
        $adress->cep = $request->input_cep;
        $adress->logradouro = $request->text_logradouro;
        $adress->numero = $request->input_numero;
        $adress->complemento = $request->text_complemento;
        $adress->cidade = $request->text_cidade;
        $adress->bairro = $request->text_bairro;
        $adress->uf = $request->text_uf;
        $adress->user_id = session('user')['id'];
        $adress->save();

        return redirect()->route('user.page')->withInput(['edit_success', 'Alterações salvas com sucesso']);
    }

    
    public function newReview($id) {
        $decrypted_id = Operations::decryptId($id);
        $item = Item::find($decrypted_id);

        if (!$item) {
            return redirect()->route('home');
        }

        return view('reviews.new_review', ['item' => $item]);
    }

    public function newReviewSubmit(Request $request) {
        $request->validate([
            'titulo' => 'required|min:3|max:50',
            'nota' => 'required',
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'titulo.min' => 'O título deve ter pelo menos :min caracteres.',
            'titulo.max' => 'O título deve ter no máximo :max caracteres.',
            
            'nota.required' => 'A nota é obrigatória.',
            
        ]);

        $decrypted_id = Operations::decryptId($request->item_id);


        $item = Item::find($decrypted_id);

        if (!$item) {
            return redirect()->back()->withErrors(['item' => 'Item não encontrado.']);
        }

        $review = new Review();
        $user = session('user');
        $review->user_id = is_array($user) ? $user['id'] : $user->id;
        $review->item_id = $item->id;
        $review->titulo = $request->titulo;
        $review->nota = $request->nota;
        $review->descricao = $request->descricao;
        $review->save();

        return redirect()->route('item.page', Operations::encryptId($item->id));
        
    }

    public function deleteReview($id) {
        $decrypted_id = Operations::decryptId($id);
        $review = Review::find($decrypted_id);

        if (!$review) {
            return redirect()->back()->withErrors(['review' => 'Avaliação não encontrada.']);
        }

        return view('reviews.delete_review', ['review' => $review]);
    }

    public function deleteReviewConfirm($id) {
        $decrypted_id = Operations::decryptId($id);
        $review = Review::find($decrypted_id);
        if (!$review) {
            return redirect()->route('home');
        }
        $review->forceDelete();
        return redirect()->route('home');
    }

}