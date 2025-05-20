<div>
    <div class="new_login_page_section">
        <div class="new_login_page_logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('assets/images/loginlogo.png') }}" class="img-fluid logologin" alt="loginlogo">
            </a>
        </div>
        <div class="">
            <h3>Admin Login</h3>
            <form class="row form-vertical mb-3 loginformsedit" wire:submit.prevent="login">
                @csrf
                <div class="col-lg-9 col-md-11 mb-3">
                    <label for="inputEmailAddress" class="form-label mb-0">Email Address</label>
                    <input type="email" class="form-control new_input new_input_margin" wire:model="email"
                        id="inputEmailAddress" placeholder="Email Address" value="" autocomplete="email"
                        autofocus>
                    @error('email')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-lg-9 col-md-11 mb-3">
                    <label for="inputChoosePassword" class="form-label mb-0">Enter Password</label>
                    <div class="input-group" id="show_hide_password">
                        <input type="password" class="form-control border-end-0 new_input new_input_margin"
                            placeholder="Password" id="inputChoosePassword" wire:model="password"
                            autocomplete="password">
                        <a href="javascript:void(0);" class="input-group-text bg-transparent new_input_margin"
                            onclick="togglePassword()">
                            <i class='bi bi-eye-slash' id="password-icon"></i>
                        </a>
                    </div>
                    @error('password')
                        <strong class="text-danger">{{ $message }}</strong>
                    @enderror
                </div>
                <div class="col-md-6">
                    <div class="form-check form-switch new_input_margin">
                        <input class="form-check-input" type="checkbox" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember Me</label>
                    </div>
                </div>
                @if (session()->has('error'))
                    <div class="text-danger mt-2">{{ session('error') }}</div>
                @endif
                <div class="col-lg-9 col-md-11 mb-md-0 mb-3">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary  py-2" wire:loading.attr="disabled">
                            <span wire:loading.remove><i class="bx bxs-lock-open"></i>Log in</span>
                            <span wire:loading><i class="spinner-border spinner-border-sm" role="status"></i>
                                Loading...</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
