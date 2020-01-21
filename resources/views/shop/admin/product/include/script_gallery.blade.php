<script>
    $(document).ready(function () {

        if ($('#gallery_js').length > 0) {
            var buttonMulti = $("#multi"), file;
            var _token = $('input#_token').val();
            var form_data2 = new FormData();
            form_data2.append("_token", _token);

            if (buttonMulti) {
                new AjaxUpload(buttonMulti, {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                    },
                    action: buttonMulti.data('url') + "?upload=1",
                    data: {
                        name: buttonMulti.data('name'),
                        _token: _token},
                    name: buttonMulti.data('name'),
                    onSubmit: function (file, ext) {
                        if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                            alert('Only Images!');
                            return false;
                        }
                        buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'block'});
                    },
                    onComplete: function (file, response) {
                        buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'none'});
                        response = JSON.parse(response);
                        $('.' + buttonMulti.data('name')).append('<img src="{{asset('storage/uploads/gallery/')}}/'
                            + response.file + '" style="max-height: 200px; cursor: pointer;" alt="Image not found"  ' +
                            'data-src="'+response.file+'" class="del-items-tmp" ' +
                            'onerror="this.src = \'{{asset("storage/images/no_image.jpg")}}\';">');
                    }
                });
            }
        }

        $('.multi').delegate('img', 'click', function () {
            var $this = $(this);
            src = $this.data('src');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/admin/products/delete-gallery-tmp')}}',
                data: {src: src, _token: _token},
                type: 'POST',
                beforeSend: function () {
                    $this.closest('.file-upload').find('.overlay').css({'display': 'block'});
                },
                success: function (res) {
                    setTimeout(function () {
                        $this.closest('.file-upload').find('.overlay').css({'display': 'none'});
                        if (res == 1) {
                            $this.fadeOut();
                        }
                    }, 1000);
                }
            });
        });

        $('.del-items').on('click', function () {
            var res = confirm('Do u want delete this image?');
            if (!res) {
                return false;
            }
            var $this = $(this);
            id = $this.data('id');
            src = $this.data('src');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{url('/admin/products/delete-gallery')}}',
                data: {id: id, src: src, _token: _token},
                type: 'POST',
                beforeSend: function () {
                    $this.closest('.file-upload').find('.overlay').css({'display': 'block'});
                },
                success: function (res) {
                    setTimeout(function () {
                        $this.closest('.file-upload').find('.overlay').css({'display': 'none'});
                        if (res == 1) {
                            $this.fadeOut();
                        }
                    }, 1000);
                }
            });
        });
    });
</script>