<?php

namespace App\Livewire\Front\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.guest')]
class LoginComponent extends Component
{
    public $email;
    public $password;
    public $remember = false;

    protected $rules = [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];


    public function login()
    {
        $this->validate();

        if (Auth::guard('web')->attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->dispatch('swal:toast', ['type' => 'success', 'title' => '', 'message' => 'Login successful!']);
            return redirect()->route('dashboard');
        } else {
            $this->dispatch('swal:toast', ['type' => 'error', 'title' => '', 'message' => 'Invalid credentials.']);
        }
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.front.auth.login-component');
    }
}
