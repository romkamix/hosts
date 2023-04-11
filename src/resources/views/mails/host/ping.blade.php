@component('mail::message')
# {{ $name }}

@component('mail::table')
| Datetime | Latency |
|:----- |:-------- |
@foreach ($pings as $ping)
| {{ $ping->created_at }} | {{ $ping->latency }} ms |
@endforeach
@endcomponent

Спасибо,<br>
{{ config('app.name') }}
@endcomponent