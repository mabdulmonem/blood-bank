@component('mail::message')
    # Introduction

    Dear <strong>{{ $client->name }}</strong>
    Hi, How are you?

    {{ settings('site_name') }}

    your Password Has Has Been Updated


    Thanks,<br>
    {{ settings('site_name') }}
@endcomponent
