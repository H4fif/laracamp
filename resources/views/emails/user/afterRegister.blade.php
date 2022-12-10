@component('mail::message')
# Welcome to Laracamp!

Hi {{ $user->name }}
<br />
Your account has been created. Now you can buy your favorite camp!

@component('mail::button', ['url' => route('login')])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
