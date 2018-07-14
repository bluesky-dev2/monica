{{ trans('mail.greetings', ['username' => $user->first_name]) }},

{{ trans_choice('mail.notification_description', $notification->scheduled_number_days_before, ['count' => $notification->scheduled_number_days_before, 'date' => $notification->reminder->next_expected_date->toDateString()]) }}

{!! $reminder->title !!}

{{ trans('mail.for') }}

{{ $contact->name }}

{{-- COMMENTS --}}
@if (! is_null($reminder->description))
COMMENT:
{!! $reminder->description !!}
@endif

-------

{{ trans('mail.footer_contact_info') }}
{{ config('app.url') }}/people/{{ $contact->hashID() }}
