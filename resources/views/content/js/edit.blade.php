<script>
    $(document).ajaxStop(function () {
        edit_listener();
    });
    $(function () {
        edit_listener();
    });

    function edit_listener() {
        //$('#modal-form').on('shown.bs.modal', function (event)
        $('.item-edit, .create-new').click(function (event) {
            var form = $('.model-form');

            form.block({
                //message: '<div class="spinner-border text-white" role="status"></div>',
                message: feather.icons['refresh-cw'].toSvg({
                    "class": 'font-medium-1 spinner text-primary'
                }),
                css: {
                    backgroundColor: 'transparent',
                    border: '0'
                },
                overlayCSS: {
                    opacity: 0.5
                }
            });
            //var button = event.relatedTarget;
            const button = $(this);
            var type = button.attr('data-type');
            var model_name = button.attr('data-model-name');
            if (type === 'create') {
                $(".modal-title").html('{{ __('Create') }}');
                var action_url = window.location.href;

                form.removeClass('was-validated');
                form.trigger("reset");
                form.attr('action', action_url);
                form.find('[name="_method"]').remove();
                form.unblock();
            } else if (type === 'edit') {
                $(".modal-title").html('{{ __('Update') }}');
                var id = button.attr('data-bs-id');
                const action_url = 'http://' + window.location.hostname + '/' + model_name + '/' + id;
                form.removeClass('was-validated');
                form.trigger("reset");

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                $.ajax({
                    // The URL for the request
                    url: action_url,
                    type: "GET",
                    dataType: "json",
                    success: function (model) {
                        //$(model).each(function(){
                        Object.entries(model).forEach(entry => {
                            const [key, value] = entry;
                            $(".model-form :input[name='" + key + "']").val(value);
                            //console.log(key, value);
                        });
                        form.unblock();

                        /*  $("#edit-number").val( sim.number );
                          $("#edit-installation-code").val( sim.installation_code );

                          var offers_id = [];
                          $.each( sim.offers, function() {
                              offers_id.push( (this).id );
                          });
                          $("#edit-offer-id").val( offers_id );
                          $("#edit-offer-id").trigger('change');*/
                    },
                    error: function (error) {
                        console.log('Error:', error);
                    }
                });
                form.append('<input name="_method" type="hidden" value="PATCH">');
                form.attr('action', action_url);
            }

        })
    }
</script>
