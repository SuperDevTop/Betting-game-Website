@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url'),"class"=>"header-top-bordered"])
            <div class="header-center">
                <span class="no-float">Welcome Admin</span>
            </div>
        @endcomponent
    @endslot

    {{-- Body --}}
    <div>
        <p class="mail-body-text">
            Hello {{ ucwords($admin->name)}}!
        </p>

        <p class="mail-body-text">
            Greetings, your account is created on <strong> {{ config('app.name') }}</strong>.</br> Use the password mentioned below to signin:
        </p>

        <h2 class="verification-code">{{ $code }}</h2>

        <p class="mail-body-text">
            It is suggested to change your password after login to maintain your account privacy.
        </p>
    </div>
    {{-- Subcopy --}}

        @slot('subcopy')
            @component('mail::subcopy')
                <p>
                    Cheers,<br>
                    The {{ config('app.name') }} team
                </p>
            @endcomponent
        @endslot


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            <p style="text-align: justify !important;">The information contained in this e-mail and/or all its attachments are private and confidential and intended for the use of the legitimate addressee only. The access and use of such information without the express authorization from the legitimate addressee might result in a civil or criminal offense. If you received this e-mail by mistake, please notify the sender immediately and delete it from your computer.</p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        @endcomponent
    @endslot
@endcomponent
