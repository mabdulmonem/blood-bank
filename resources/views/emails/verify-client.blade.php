@component('mail::message')
    # Introduction

    Dear <strong>{{ $data['name'] }}</strong>
    Hi, How are you?

    {{ settings('site_name') }} Thank You For Chose Our Service

    We Hope To Help You PLease To Use Our Services Please Verify You Account

    if you want to join our team [ click on the button] or [code verify code]

    @component('mail::button', ['url' => url("/profile/verify/" .$data['rest_code'] ."?_token=" . $data['api_token'])])
        Verify Directly
    @endcomponent
    or Copy This Code: <strong>{{ $data['rest_code'] }}</strong>
    Thanks,<br>
    {{ settings('site_name') }}
@endcomponent
