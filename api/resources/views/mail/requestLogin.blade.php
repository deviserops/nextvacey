@component('mail::message')
# Login Request

Please click on below link to login to your account.

@component('mail::button', ['url' => $data['loginUrl']])
    Process to login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
