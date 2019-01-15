@extends('layouts.skeleton')

@section('content')
  <div class="dashboard">

    <section class="ph3 ph5-ns pv4 cf w-100 bg-gray-monica">
      <div class="mw9 center">
        <div class="{{ htmldir() == 'ltr' ? 'fl' : 'fr' }} w-70 ph2">
          <div class="flex items-center">
            <div class="pr2">
              {{ trans('people.people_list_last_updated') }}
            </div>
            @foreach($lastUpdatedContacts as $contact)
            <div class="pr2 pointer avatars">
              <avatar :contact="{{ $contact }}" :clickable="true"></avatar>
            </div>
            @endforeach
          </div>
        </div>
        <div class="{{ htmldir() == 'ltr' ? 'fl tr' : 'fr tl' }} w-30 ph2">
          <a href="{{ route('people.create') }}" class="btn btn-primary" style="padding: 15px 45px;">
            {{ trans('people.people_list_blank_cta') }}
          </a>
        </div>
      </div>
    </section>

    {{-- Main section --}}
    <section class="ph3 ph5-ns cf w-100 bg-gray-monica">
      <div class="mw9 center">
        <div class="{{ htmldir() == 'ltr' ? 'fl' : 'fr' }} w-50-ns w-100 pa2">
          <div class="br3 ba b--gray-monica bg-white mb4">
            <div class="pa3 bb b--gray-monica">
              <p class="mb0">
                📅
                {{ trans('dashboard.reminders_next_months') }}
              </p>
            </div>
            <div class="pt3 pr3 pl3 mb4">
              @include('dashboard._monthReminder', ['reminderOutboxesList' => $reminderOutboxes])
            </div>
          </div>
        </div>
        <div class="{{ htmldir() == 'ltr' ? 'fl' : 'fr' }} w-50-ns w-100 pa2">
          <div class="br3 ba b--gray-monica bg-white mb3">
            <div class="pa3 bb b--gray-monica">
              <p class="mb1 b">☀️ {{ trans('dashboard.product_changes') }} <span class="fr normal"><a href="/changelog">{{ trans('dashboard.product_view_details') }}</a></span></p>
              <ul>
                @foreach ($changelogs as $changelog)
                <li class="mb1">
                  <span class="gray f6">{{ $changelog['date'] }}</span>
                  <span class="stat-description">{{ $changelog['title'] }}</span>
                </li>
                @endforeach
              </ul>
            </div>
          </div>

          <dashboard-log :default-active-tab="'{!! auth()->user()->dashboard_active_tab !!}'"></dashboard-log>

          <div class="br3 ba b--gray-monica bg-white mb3">
            <div class="pa3 bb b--gray-monica tc">
              <ul>
                <li class="tc dib fl w-third">
                  <span class="db f3 fw5 green">{{ $number_of_contacts }}</span>
                  <span class="stat-description">{{ trans('dashboard.statistics_contacts') }}</span>
                </li>
                <li class="tc dib fl w-third">
                  <span class="db f3 fw5 blue">{{ $number_of_activities }}</span>
                  <span class="stat-description">{{ trans('dashboard.statistics_activities') }}</span>
                </li>
                <li class="tc dib w-third">
                  <span class="db f3 fw5 orange">{{ $number_of_gifts }}</span>
                  <span class="stat-description">{{ trans('dashboard.statistics_gifts') }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>

  </div>
@endsection
