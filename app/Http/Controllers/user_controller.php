<?php

namespace App\Http\Controllers;

use App\Repository\admin_repository_interface;
use App\Repository\user_repository_interface;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class user_controller extends Controller
{
    private user_repository_interface $user_repository;

    public function __construct(user_repository_interface $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    public function index()
    {
        $users = $this->user_repository->all();

        return view('pages.login', [
            'users' => $users
        ]);
    }

    public function proses_login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($_POST['email'] == "admin" && $_POST['password'] == "admin") { //cek admin
            return redirect('admin/list_customer');
        } else {
            $result = $this->user_repository->pengecekan_login($_POST['email'], $_POST['password']);
            echo($result->isEmpty());
            if (!$result->isEmpty()) { //cek email dan password
                $request->session()->put('user_login', $result);
                return redirect('/list_user');
            }
            else {
                if (!$this->user_repository->pengecekan_login($_POST['email'], null)->isEmpty()) { //cek email ada atau tidak
                    $request->session()->flash('message', 'Wrong password');
                    return redirect()->back()->withInput();
                } else { //jika email tidak ada
                    $request->session()->flash('message', 'Email not found');
                    return redirect()->back()->withInput();
                }
            }
        }
    }

    public function pergi_ke_list_user(Request $request){
        return view('pages.list_user')->with('users', $request->session()->get('user_login'));
    }
}
