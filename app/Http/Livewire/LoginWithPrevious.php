<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LoginWithPrevious extends Component
{
    public $users = [];
    public function render()
    {
        return view('livewire.login-with-previous');
    }

    public function mount()
    {
        $users = session()->get('iptv_users', []);
        $this->users = $users;
    }

    public function login($portal, $username)
    {
        $password = $this->getPassword($portal, $username);
        $iptv = iptv()->setLoginData($portal, $username, $password);

        if ($iptv->auth()) {
            $user = $iptv->user();
            session()->put('iptv', true);
            session()->put("iptv_expire_at", $user->exp_date);
            session()->put("iptv_user", $user);
            $data = [
                'portal' => $portal,
                'username' => $username,
                'password' => $password,
            ];
            session()->put('iptv_data', $data);
            return redirect()->route('home');
        } else {
            session()->flash('error', 'Login failed');
        }

        session()->flash('error', 'Login failed');
    }

    public function getPassword($portal, $username)
    {
        $users = session()->get('iptv_users', []);
        foreach ($users as $user) {
            if ($user['portal'] == $portal && $user['username'] == $username) {
                return $user['password'];
            }
        }
    }
}
