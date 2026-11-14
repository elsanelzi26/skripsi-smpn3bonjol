<script src="{{ asset('template/js/lib/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ asset('template/js/lib/bootstrap.min.js') }}"></script>
<script src="{{ asset('template/js/lib/jquery.nanoscroller.min.js') }}"></script>
<script src="{{ asset('template/js/lib/menubar/sidebar.js') }}"></script>
<script src="{{ asset('template/js/lib/preloader/pace.min.js') }}"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('template/ckeditor4/ckeditor.js') }}"></script>

<script src="{{ asset('template/js/scripts.js') }}"></script>
<script src="{{ asset('template/js/lib/calendar-2/moment.latest.min.js') }}"></script>
<script src="{{ asset('template/js/lib/calendar-2/pignose.calendar.min.js') }}"></script>
<script src="{{ asset('template/js/lib/calendar-2/pignose.init.js') }}"></script>

<script src="{{ asset('template/js/lib/owl-carousel/owl.carousel.min.js') }}"></script>

<script>
    // Auto close alert
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);

    // CSRF Token Global untuk AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>