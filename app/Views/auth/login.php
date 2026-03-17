<div class="row flex-center min-vh-100 py-6">
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
        <a class="d-flex flex-center mb-4" href="/">
            <img class="me-2" src="/assets/img/icons/spot-illustrations/falcon.png" alt="" width="58" />
            <span class="font-sans-serif text-primary fw-bolder fs-4 d-inline-block">falcon</span>
        </a>
        <div class="card">
            <div class="card-body p-4 p-sm-5">
                <div class="row flex-between-center mb-2">
                    <div class="col-auto">
                        <h5>Log in</h5>
                    </div>
                    <div class="col-auto fs-10 text-600">
                        <span class="mb-0 undefined">or</span>
                        <span><a href="/register">Create an account</a></span>
                    </div>
                </div>
                <form class="needs-validation" novalidate method="POST" action="/login">
                    <div class="mb-3">
                        <input class="form-control" type="email" name="email" placeholder="Email address" required />
                        <div class="invalid-feedback">Please enter a valid email.</div>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="password" name="password" placeholder="Password" required />
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>
                    <div class="row flex-between-center">
                        <div class="col-auto">
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                                <label class="form-check-label mb-0" for="remember">Remember me</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <a class="fs-10" href="/forgot-password">Forgot Password?</a>
                        </div>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-block w-100 mt-3" type="submit">Log in</button>
                    </div>
                </form>
                <div class="position-relative mt-4">
                    <hr />
                    <div class="divider-content-center">or log in with</div>
                </div>
                <div class="row g-2 mt-2">
                    <div class="col-sm-6">
                        <a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#">
                            <span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-outline-facebook btn-sm d-block w-100" href="#">
                            <span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>