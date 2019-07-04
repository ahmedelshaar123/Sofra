@component('mail::message')


Sofra reset password

@component('mail::button', ['url' => '', 'color'=>'success'])
Reset password
@endcomponent
Welcome {{$user->name}}
<p>Your code is {{$user->pin_code}}</p>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
