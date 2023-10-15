<x-front-layout title="login">
    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="post" action="{{ route('two-factor.enable') }}">
                        @csrf
                        <div class="card-body">
                            <div class="title">
                                <h3>Two Factor Authentication</h3>

                                @if (session('status') == 'two-factor-authentication-enabled')
                                    <div class="mb-4 font-medium text-sm">
                                        Please finish configuring two factor authentication below.
                                    </div>
                                @endif

                                @if(is_null($user->two_factor_secret))
                                    <p>Enable two factor authentication </p>
                            </div>
                            <div class="button">

                                <button class="btn" type="submit">Enable</button>
                                @else
                                    <p>Disable two factor authentication </p>
                            </div>
                            <div class="p-4">
                            {!! $user->twoFactorQrCodeSvg() !!}
                            </div>
                            <h3>Recovery code</h3>
                            @foreach($user->recoveryCodes() as $recovery_code)
                            <ul>
                                    <li>{{ $recovery_code }}</li>
                            </ul>
                            @endforeach
                                <div class="button">
                                @method('DELETE')
                                <button class="btn btn-primary" type="submit">Disable</button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->
</x-front-layout>


