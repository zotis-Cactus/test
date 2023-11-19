@if(session('success'))
    <script>
        Swal.fire({
            title: '{{__('locale.Update')}}!',
            text: '{{ session('success') }}',
            icon: 'success',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        })
    </script>
@endif
@if(session('danger'))
    <script>
        Swal.fire({
            title: '{{__('locale.Update')}}!',
            text: '{{ session('danger') }}',
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        })
    </script>
@endif
@if ($errors->any())
    <script>
        var html_errors="";
        @foreach($errors->all() as $error)
            html_errors += "<p>{{ $error }}</p>";
        @endforeach
        Swal.fire({
            title: '{{__('locale.Update')}}!',
            html: html_errors,
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false
        })
    </script>
@endif
<script>
    window.addEventListener('swal',function(e){
        Swal.fire({
            'title' :  e.detail.title,
            'icon' :  e.detail.icon,
            'timer': 3000,
            'toast' :true,
            'timerProgressBar':true,
            'position' : 'top-right'
        });
    });
</script>


