<script>
    $( document ).ajaxStop(function() {
        $( ".delete-button").on("click",function( event ) {
            event.preventDefault();
            var form = $(this).parents('form');
            Swal.fire({
                title: "{{__("Are you sure?")}}",
                text: "{{__("You won't be able to revert this!")}}",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonText: "{{__("Yes, delete it!")}}",
                cancelButtonText: "{{__("Cancel")}}",
                customClass: {
                    confirmButton: "btn btn-primary me-3",
                    cancelButton: "btn btn-label-secondary btn-danger"
                },
                buttonsStyling: !1
            }).then((function (t) {
                if(t.isConfirmed){
                    form.submit();
                }
            }));
        });
    });
</script>
