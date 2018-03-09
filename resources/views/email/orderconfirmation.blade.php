@component('mail::message')
Hello,

We have received your order and will prcess it immediately. 

@component('mail::button', ['url' => 'https://mamahome360.com/webapp/payment'])
Click Here for payment
@endcomponent

Thanks,<br>
Mamahome Pvt. Ltd.
@endcomponent
