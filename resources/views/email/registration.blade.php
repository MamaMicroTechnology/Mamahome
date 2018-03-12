@component('mail::layout')
{{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => 'https://mamahome360.com'])
            Mamahome360.com
        @endcomponent
    @endslot
Hello {{ $name }},

We have received your registration request. We will verify your registration in a few minutes.
After that, your login credentials will be<br>
Email : {{ $email }}<br>
Password : {{ $password }}<br>

@component('mail::button', ['url' => 'https://mamahome360.com/webapp/blogin'])
Click Here to login
@endcomponent

Thanks,<br>
Mamahome Pvt. Ltd.

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        All Rights Reserved https://mamahome360.com
    @endcomponent
@endslot
@endcomponent