<script src="{{ URL::asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/modernizr.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.slimscroll.js') }}"></script>
<script src="{{ URL::asset('assets/js/waves.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.nicescroll.js') }}"></script>
<script src="{{ URL::asset('assets/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/toastr/toastr.min.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('assets/js/app.js') }}"></script>

@if($errors->any())
    <script>
        toastr.error('{{$errors->first()}}')
    </script>
@endif

@if (\Session::has('toast-success'))
    <script>
        toastr.success('{!! \Session::get('success') !!}')
    </script>
@endif

@if (\Session::has('toast-info'))
    <script>
        toastr.info('{!! \Session::get('info') !!}')
    </script>
@endif

@if (\Session::has('swal-success'))
    <script>
        Swal.fire({
            type: "success",
            icon: 'success',
            title: 'Your work has been saved',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif
@if (\Session::has('swal-error'))
    <script>
        Swal.fire({
            type: "error",
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        })
    </script>
@endif

<script>
    function swal_delete(url_del, csrf_token) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger ml-1',
            buttonsStyling: false,
        }).then(function (result) {

            if (result.value) {

                $.ajax({
                    //method: "delete",
                    type: "POST",
                    url: url_del,
                    data: {
                        "_method": "DELETE",
                        "_token": csrf_token,
                    }
                })
                    .done(function (msg) {
                        if (msg.message == 'success') {
                            Swal.fire(
                                {
                                    type: "success",
                                    title: 'Deleted!',
                                    text: 'Your data has been deleted.',
                                    confirmButtonClass: 'btn btn-success',
                                }
                            )
                            location.reload();
                        } else {
                            Swal.fire(
                                {
                                    type: "error",
                                    title: 'Sorry!',
                                    text: 'Your data failed to delete.',
                                    confirmButtonClass: 'btn btn-error',
                                }
                            )
                        }
                    });
            }

        })
    }
</script>

@yield('script-bottom')


