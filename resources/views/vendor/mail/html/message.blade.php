@component('mail::message')
{{-- Logo --}}
<div style="text-align:center;">
  <img src="{{ asset('images/logo.png') }}" alt="Tech Care Logo" width="80" style="margin-bottom: 10px;">
</div>

# Welcome to Tech Care! 💙

Hi **{{ $user->name ?? 'there' }}**,  
Thank you for joining **Tech Care Store** — your trusted destination for smart gadgets & tech accessories.

Please verify your email address to activate your account and start shopping.

@component('mail::button', ['url' => $actionUrl])
Verify My Email
@endcomponent

If you didn’t create an account, please ignore this email — no action is required.

Thanks for being part of our community!  
**– The Tech Care Team**

<hr style="margin: 30px 0;">

<p style="font-size: 12px; color: #999;">
If you're having trouble clicking the "Verify My Email" button, copy and paste this link in your browser:<br>
<a href="{{ $actionUrl }}" style="word-break: break-all;">{{ $actionUrl }}</a>
</p>

@endcomponent
