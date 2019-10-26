@component('mail::message')
# Introduction

Dear <strong>{{ $data['name'] }}</strong>
Hi, How are you?

{{ settings('site_name') }} Team , Chose you to
be one of Our great team

if you want to join our team [ click on the button] or [code verify code]

@component('mail::button', ['url' => admin_url('users-verify?_token='. csrf_token() .'&rest_code=' . $data['rest_code'])])
Verify Directly
@endcomponent
 or Copy This Code: <strong>{{ $data['rest_code'] }}</strong>
Thanks,<br>
{{ settings('site_name') }}
@endcomponent
