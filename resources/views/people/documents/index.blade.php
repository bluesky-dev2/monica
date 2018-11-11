<div class="{{ htmldir() == 'ltr' ? 'fl' : 'fr' }} w-100 pb3 pt1 pl3 pr3">
  <div class="br2 bg-white mb4">

    @if (config('monica.requires_subscription') && auth()->user()->account->hasLimitations())

    <div class="">
        <h3>
            📄 {{ trans('people.document_list_title') }}
        </h3>

        <div class="section-blank">
          <p>{{ trans('settings.storage_upgrade_notice') }}</p>
        </div>
    </div>

    @else

    <document-list hash="{{ $contact->hashID() }}" reach-limit="{{ json_encode($contact->account->hasReachedAccountStorageLimit()) }}"></document-list>

    @endif
  </div>
</div>
