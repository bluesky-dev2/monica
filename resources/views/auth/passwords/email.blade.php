@extends('marketing.skeleton')

@section('content')
  <body class="marketing register">
    <div class="container">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <div class="card">
            <div class="card-block">
              <div class="card-title">{{ trans('auth.password_reset_title') }}</div>
                <div class="panel-body">
                  @if (session('status'))
                      <div class="alert alert-success">
                          {{ session('status') }}
                      </div>
                  @endif

                  <form class="form-horizontal" role="form" method="POST" action="{{ '/password/email' }}">
                      @csrf

                      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                          <label for="email" class="col-md-4 col-form-label">{{ trans('auth.password_reset_email') }}</label>

                          <div class="col-md-6">
                              <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                              @if ($errors->has('email'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                          </div>
                      </div>

                      <div class="form-group">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  <i class="fa fa-btn fa-envelope"></i>&nbsp;{{ trans('auth.password_reset_send_link') }}
                              </button>
                          </div>
                      </div>
                  </form>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </body>
@endsection
