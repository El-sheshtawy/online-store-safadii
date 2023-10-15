<x-front-layout title="Two Factor Challenge">
    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="post" action="{{ route('two-factor.login') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Challenge</h3>
                                <p>You must enter one of them</p>
                            </div>
                            @if($errors->has('code'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('code') }}
                                </div>
                            @endif
                            <div class="form-group input-group">
                                <label for="reg-fn">two factor authentication code</label>
                                <input class="form-control" type="text" name="code">
                            </div>

                            <div class="form-group input-group">
                                <label for="reg-fn">Recovery code</label>
                                <input class="form-control" type="text" name="recovery_code">
                            </div>

                            <div class="button">
                                <button class="btn" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->
</x-front-layout>
