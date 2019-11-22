<div class="box box-primary box-solid file-upload">
    <div class="box-header">
        <h3 class="box-title">Gallery</h3>
    </div>
    <div class="box-body" id="gallery_js">
        <div id="multi" class="btn btn-success" data-url="{{url('/admin/products/gallery')}}"
             data-name="multi">Upload
        </div>
        <div class="multi">
            @if(!empty($images))
                <p>
                    <small>Click on image for delete</small>
                </p>
                @foreach($images as $image)
                    <img src='{{asset("storage/uploads/gallery/$image")}}' alt="Image not found" style="max-height: 150px; cursor: pointer;"
                         data-id="{{$product->id}}" data-src="{{$image}}" class="del-items" onerror="this.src = '{{asset("storage/images/no_image.jpg")}}';">
                @endforeach
            @endif
        </div>
        <p>
            <small>Recommended size 700x1000</small>
        </p>
    </div>
    <div class="overlay">
        <i class="fa fa-refresh fa-spin"></i>
    </div>
</div>