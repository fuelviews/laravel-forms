<input type="hidden" name="gclid" wire:model="gclid" value="{{ request()->cookie('gclid') }}">
<input type="hidden" name="utmSource" wire:model="utmSource" value="{{ request()->cookie('utm_source') }}">
<input type="hidden" name="utmMedium" wire:model="utmMedium" value="{{ request()->cookie('utm_medium') }}">
<input type="hidden" name="utmCampaign" wire:model="utmCampaign" value="{{ request()->cookie('utm_campaign') }}">
<input type="hidden" name="utmTerm" wire:model="utmTerm" value="{{ request()->cookie('utm_term') }}">
<input type="hidden" name="utmContent" wire:model="utmContent" value="{{ request()->cookie('utm_content') }}">
