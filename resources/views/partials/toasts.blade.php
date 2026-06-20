{{-- Global toast notifications (toastr) for flash & validation messages.
     Reads session keys: status/success → success, error → error, warning, info.
     Renders one error toast per validation message. --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
<style>
    /* Theme toastr to match Wamo's dark glass UI */
    #toast-container > div {
        opacity: 1;
        border-radius: 1rem;
        padding: 1rem 1.25rem 1rem 3.25rem;
        box-shadow: 0 18px 50px -12px rgba(0, 0, 0, .65);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        background-position: 1.1rem center;
        font-size: .875rem;
        font-weight: 500;
        line-height: 1.4;
    }
    #toast-container > div:hover { box-shadow: 0 18px 50px -10px rgba(0, 0, 0, .75); }
    #toast-container > .toast-success { background-color: rgba(16, 185, 129, .15); border: 1px solid rgba(16, 185, 129, .4); color: #6ee7b7; }
    #toast-container > .toast-error   { background-color: rgba(244, 63, 94, .15);  border: 1px solid rgba(244, 63, 94, .4);  color: #fda4af; }
    #toast-container > .toast-warning { background-color: rgba(245, 158, 11, .15);  border: 1px solid rgba(245, 158, 11, .4);  color: #fcd34d; }
    #toast-container > .toast-info    { background-color: rgba(59, 130, 246, .15);  border: 1px solid rgba(59, 130, 246, .4);  color: #93c5fd; }
    #toast-container > div .toast-title { font-weight: 700; }
    #toast-container > div .toast-close-button { color: currentColor; opacity: .6; text-shadow: none; }
    #toast-container > div .toast-close-button:hover { opacity: 1; }
    #toast-container > div .toast-progress { opacity: .35; }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            newestOnTop: true,
            preventDuplicates: true,
            positionClass: 'toast-top-right',
            timeOut: 5000,
            extendedTimeOut: 2000,
        };

        @if (session('status'))
            toastr.success(@json(session('status')));
        @endif
        @if (session('success'))
            toastr.success(@json(session('success')));
        @endif
        @if (session('error'))
            toastr.error(@json(session('error')));
        @endif
        @if (session('warning'))
            toastr.warning(@json(session('warning')));
        @endif
        @if (session('info'))
            toastr.info(@json(session('info')));
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error(@json($error));
            @endforeach
        @endif
    });
</script>
