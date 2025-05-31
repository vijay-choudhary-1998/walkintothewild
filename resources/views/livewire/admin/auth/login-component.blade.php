<div class="container">
    <div class="row py-3">
        <div class="col-xl-7 mx-auto">
            <div class="card border-top border-0 border-4 border-dark">
                <div class="card-body p-5">
                    <div class="card-title text-center"><i class="bx bxs-user-circle text-dark font-50"></i>
                        <h5 class="mb-5 mt-2 text-dark">Admin Login</h5>
                    </div>
                    <hr>
                    <form class="row g-3" wire:submit.prevent="login">
                        <div class="col-12">
                            <label for="inputLastEnterUsername" class="form-label">Enter Email</label>
                            <div class="input-group input-group-lg"> <span class="input-group-text bg-transparent"><i
                                        class='bx bxs-user'></i></span>
                                <input type="email" class="form-control border-start-0" id="inputLastEnterUsername"
                                    placeholder="Enter Email" wire:model="email" autocomplete="email" autofocus />
                            </div>
                            @error('email')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="inputLastEnterPassword" class="form-label">Enter Password</label>
                            <div class="input-group input-group-lg"> <span class="input-group-text bg-transparent"><i
                                        class='bx bxs-lock-open'></i></span>
                                <input type="password" class="form-control border-start-0" id="inputLastEnterPassword"
                                    placeholder="Enter Password" wire:model="password" autocomplete="password" />
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
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck3">
                                <label class="form-check-label" for="gridCheck3">Check me out</label>
                            </div>
                        </div>
                        <div class="col-md-6 text-end"> <a href="javascript:;">Forgot Password ?</a>
                        </div>
                        <div class="col-12">
                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-lg px-5" wire:loading.attr="disabled">
                                    <span wire:loading.remove>
                                        <i class='bx bxs-lock-open'></i>
                                        Login
                                    </span>
                                    <span wire:loading>
                                        <i class="spinner-border spinner-border-sm" role="status"></i>
                                        Loading...
                                    </span>
                                </button>
                            </div>
                        </div>
                        <hr />
                        <div class="col-12 text-center">
                            <p class="mb-0">or Sign in with:</p>
                        </div>
                        <div class="col-12">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-facebook btn-lg px-5"><i
                                        class='bx bxl-facebook'></i>Login
                                    with facebook</button>
                                <button type="submit" class="btn btn-light btn-lg px-5"><i
                                        class='bx bxl-google'></i>Login
                                    with Google</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        window.togglePassword = function() {
            const passwordInput = document.getElementById("inputLastEnterPassword");
            const passwordIcon = document.getElementById("password-icon");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordIcon.classList.remove("bi-eye-slash");
                passwordIcon.classList.add("bi-eye");
            } else {
                passwordInput.type = "password";
                passwordIcon.classList.remove("bi-eye");
                passwordIcon.classList.add("bi-eye-slash");
            }
        };
    </script>
@endscript
