@extends('errors::layout')

@section('title', trans('app.error_title'))

@section('message', trans('app.error_title'))

@section('content')
  @if(isset($exception) && $exception->getMessage())
    <p>{{ $exception->getMessage() }}</p>
  @endif

  @if(Auth::check() && app()->bound('sentry') && config('monica.sentry_support') && ! empty(app('sentry')->getLastEventID()))
    <div class="subtitle">@lang('app.error_id', ['id' => app('sentry')->getLastEventID()])</div>

    <!-- Sentry JS SDK 2.1.+ required -->
    <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

    <script>
        Raven.showReportDialog({
            eventId: '{{ app('sentry')->getLastEventID() }}',
            // use the public DSN (dont include your secret!)
            dsn: '{{ config('sentry.dsn') }}',
            user: {
                'username': '{{ auth()->user()->name }}',
                'email': '{{ auth()->user()->email }}',
            }
        });
    </script>
  @endif

  <p><a href="">{{ trans('auth.back_homepage') }}</a></p>
@endsection
