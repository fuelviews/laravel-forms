<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="gclid" wire:model="gclid" value="{{ request()->query('gclid', request()->cookie('gclid', session('gclid'))) }}">
<input type="hidden" name="utmSource" wire:model="utmSource" value="{{ request()->query('utm_source', request()->cookie('utm_source', session('utm_source'))) }}">
<input type="hidden" name="utmMedium" wire:model="utmMedium" value="{{ request()->query('utm_medium', request()->cookie('utm_medium', session('utm_medium'))) }}">
<input type="hidden" name="utmCampaign" wire:model="utmCampaign" value="{{ request()->query('utm_campaign', request()->cookie('utm_campaign', session('utm_campaign'))) }}">
<input type="hidden" name="utmTerm" wire:model="utmTerm" value="{{ request()->query('utm_term', request()->cookie('utm_term', session('utm_term'))) }}">
<input type="hidden" name="utmContent" wire:model="utmContent" value="{{ request()->query('utm_content', request()->cookie('utm_content', session('utm_content'))) }}">
