<div wire:ignore>
    <div class="g-recaptcha flex justify-center"
         data-sitekey="{{ config('services.recaptcha.site_key') }}"
         data-callback="onRecaptchaSuccess">
    </div>
</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
    function onRecaptchaSuccess(token) {
        console.log("reCAPTCHA Token:", token);

        if (token) {
            Livewire.dispatch('recaptchaValidated', { token: token });
        } else {
            console.warn("No reCAPTCHA token received, resetting...");
            grecaptcha.reset();
        }
    }


    document.addEventListener("DOMContentLoaded", function () {
        Livewire.on('resetCaptcha', () => {
            console.warn("Resetting reCAPTCHA...");
            grecaptcha.reset();
        });
    });
</script>
