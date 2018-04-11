<footer class="ph3 ph5-ns pb4 cf w-100">
  <div class="mw9 center">
    <div class="flex f6">
      <div class="fl w-40-ns w-100 pa2 bt b--gray-monica pt3">
        <ul>
          <li class="di mr2">{{ trans('app.footer_remarks') }} <a href="mailto:regis@monicahq.com">{{ trans('app.footer_send_email') }}</a></li>
          <li class="di mr2"><a href="https://monicahq.com/privacy" hreflang="en">{{ trans('app.footer_privacy') }}</a></li>
          <li class="di"><a href="https://tinyletter.com/monicahq" hreflang="en">{{ trans('app.footer_newsletter') }}</a></li>
        </ul>
      </div>

      <div class="fl w-20-ns w-100 pa2 tc bt b--gray-monica pt3">
        <img src="/img/monica.svg" width="20" height="21" />
      </div>

      <div class="fl w-40-ns w-100 pa2 tr bt b--gray-monica pt3">
        <ul>
          <li class="di"><a href="https://monicahq.com/changelog" hreflang="en">{{ trans('app.footer_release') }}</a></li>
          <li class="di ml2"><a href="https://github.com/monicahq/monica">{{ trans('app.footer_source_code') }}</a></li>
          <li class="di ml2">{{ trans('app.footer_version', ['version' => config('monica.app_version')]) }}</li>

          @include('partials.check')
        </ul>
      </div>
    </div>
  </div>
</footer>
