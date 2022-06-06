<script src="{{ asset("/assets/js/vendor/jquery-2.1.4.min.js") }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="{{ asset("/assets/js/plugins.js") }}"></script>
<script src="{{ asset("/assets/js/main.js") }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    toastr.options =
        {
            "closeButton" : true,
            "progressBar" : false,
            "debug" : false,
            "newestOnTop" : true,
            "positionClass" : "toast-top-right",
            "preventDuplicates" : true,
            "onclick" : null,
            "showDuration" : "300",
            "hideDuration" : "1000",
            "timeOut" : "5000",
            "extendedTimeOut" : "2000",
            "showEasing" : "swing",
            "hideEasing" : "linear",
            "showMethod" : "fadeIn",
            "hideMethod" : "fadeOut"
        }
    @if(isset($status) && $status == 'success')
    toastr.success("{{ $msg }}", "Success");
    @elseif(isset($status) && $status == 'error')
    toastr.error("{{ $msg }}", "Error");
    @endif
</script>
<script>
    window.$ = jQuery;
</script>
@stack('scripts')
