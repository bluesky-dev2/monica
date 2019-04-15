@extends('marketing.auth')

@section('content')
  <body class="marketing register">
    <div class="container">
      <form action="{{ session('oauth') ? route('oauth.validate2fa') : route('validate2fa') }}" method="post">
        <input type="hidden" name="url" value="{{ urlencode(url()->current()) }}" />
      
        <div class="row">
          <div class="col-xs-12 col-md-6 col-md-offset-3 col-md-offset-3-right">
            <div class="signup-box">
      
              <div class="dt w-100">
                <div class="dtc tc">
                  <img src="img/monica.svg" width="97" height="88" alt="">
                </div>
              </div>
              <h2>{{ trans('auth.2fa_title') }}</h2>
          
              @include ('partials.errors')
          
              @csrf

              <h3>{{ trans('auth.mfa_auth_u2f') }}</h3>
              <u2f-connector
                :authdatas="{{ json_encode($authenticationData) }}"
                :method="'login'"
                :callbackurl="{{ json_encode(url()->current()) }}">
              </u2f-connector>

              @if (app('pragmarx.google2fa')->isActivated())
              <div class="mt5">
                <h3>{{ trans('auth.mfa_auth_otp') }}</h3>
                @include ('partials.auth.validate2fa')
              </div>
              @endif

              <div class="form-group links">
                <ul>
                  <li>{!! trans('auth.use_recovery', ['url' => route('recovery.login')]) !!}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>

  </body>
  <script src="{{ asset(mix('js/u2f-api.js')) }}" type="text/javascript"></script>
@endsection
