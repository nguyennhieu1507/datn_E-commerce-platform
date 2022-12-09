@extends('home.layout.store')
@section('content')
<style>
    .w-18{
        width: 18% !important;
    }
    input.form-control{
        width: 95%;
        height: 25px;
        font-size: 1.5rem !important;
        padding: 0px !important;
        padding-left: 1rem !important;
    }
    select{
        width: 95%;
        height: 25px;
        font-size: 1.5rem !important;
    }
    textarea{
        font-size: 1.5rem !important;
        min-height: 100px !important;
    }
    .bootstrap-tagsinput .tag {
            padding: 1px 10px;
            border-radius: 5px;
            color: #fff;
            background: lightblue;
    }

    .bootstrap-tagsinput {
        width: 96%;
        height: 30px;
        display: flex;
    }
    .drag-area{
        border: 2px dashed #333;
        height: 500px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    .drag-area.active{
        border: 2px solid #333;
    }
    .drag-area img{
        height: 100%;
        width: 100%;
        object-fit: cover;
        border-radius: 5px;
    }
    .removeFile{
        top: 45px !important;
        font-size: 3rem;
        right: 15px;
        display: none;
        cursor: pointer;
    }
    .removeFileAlbum{
        top: -20px !important;
        font-size: 3rem;
        right: -15px;
        display: none;
        cursor: pointer;
    }
    .btn-color{
        height: 25px;
        width: 25px;
        outline: 2px solid #333;
        border: 2px solid #fff;
    }
    input.btn-color-input:checked + label::after{
    font-family: "FontAwesome";
    content: "\f00c";
    display: flex;
    justify-content: center;
    align-items: center;
    }
    .btn-color:hover{
        cursor: pointer;
    }
    .input-add-size{
        padding: 5px 10px;
        border: 1px solid #dedede;
        border-radius:5px;
        outline: none;
    }
    .upload-file-attribute{
        width: 100px;
        cursor: pointer;
        outline: 2px dashed #333;
        border-radius: 10px;
    }
    .upload-file-attribute.active{
        outline: 2px solid #333;
    }
</style>
<a href="" class="btn btn-primary fs-4 mb-4">Quay trở lại</a>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if($message = session('message'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif

<form action="{{ route("user.update-product-store", [$store->id, $product->id]) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method("PUT")
    <div class="d-flex flex-wrap col-lg-12">
        <div class="col-lg-7">
            <div class="row d-flex flex-wrap justify-content-between">
                <div class="col-lg-11 mb-3 flex-basic w-45">
                    <label for="" class="form-label">Tên sản phẩm: </label>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control">
                </div>
                
                <div class="col-lg-11 mb-3 flex-basic w-45">
                    <label for="" class="form-label">Mô tả ngắn: </label>
                    <textarea id="description" name="description" class="form-control">{!! $product->description !!}</textarea>
                </div>
                <div class="col-lg-11 mb-3 flex-basic w-45">
                    <label for="" class="form-label">Mô tả dài: </label>
                    <textarea id="long_description"  name="long_description" class="form-control">{!! $product->long_description !!}</textarea>
                </div>
                <div class="col-lg-11 mb-3 flex-basic w-45">
                    <label for="" class="form-label">Thương hiệu: </label>
                    <input type="text" name="brand" value="{{ $product->brand }}"  class="form-control">
                </div>
                
            
            </div>
        </div>
        <div class="col-lg-5">
            <div class="col-lg-12 mb-4 flex-basic w-45">
                <label for="" class="form-label">Danh mục: </label>
                <select name="category_id" id="" class="form-control" style="padding: 0px; padding-left: 1rem;">
                    <option disabled selected>Chọn danh mục</option>
                    @foreach ($categories as $key => $cate)
                    <option value="{{ $cate->path }}" @if ($cate->path == $product->category_path)
                        selected="selected"
                    @endif >
                    @php
                        $str = '';
                        for($i = 0; $i < $cate->level; $i++){
                            echo $str;
                            $str .= '--';
                        }
                    @endphp
                    {{ $cate->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-12 position-relative">
                <div class="d-flex align-items-center justify-content-between mb-3"><label for="">Upload ảnh sản phẩm: </label>
                    <button type="button" class="btn btn-danger fs-4 d-flex align-items-center" id="upload-file-product"><div class="icon me-2"><i class="fas fa-cloud-upload-alt fs-1"></i></div> Chọn ảnh</button>
                    <input type="file" hidden id="input-hidden" name="thumb"></div>
                    <input type="hidden" name="thumbOld" value="{{ $product->thumb }}">
                <div class="drag-area" style="display: block">
                   <img src="{{ asset("upload/product/$product->thumb") }}" alt="">
                </div>
                <div class="removeFile position-absolute top-0 right-0">
                    <i class="fa-regular fa-circle-xmark text-white"></i>
                </div>
            </div>
            <div class="col-lg-12 mb-4">
                <i class="fs-5 text-danger">(giữ phím ctrl để chọn nhiều ảnh hơn)</i>
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <label for="" class="form-label">Album ảnh: </label>
                    <button type="button" class="btn btn-danger fs-4 d-flex align-items-center" id="button-album"><div class="icon me-2"><i class="fas fa-cloud-upload-alt fs-1"></i></div> Chọn ảnh</button>
                    <input type="file" name="url[]" id="album" multiple hidden>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-between bg-light rounded gap-2 py-2" id="show-album">
                    {{-- @foreach ($store->product as $prd)
                        @foreach ($prd->images as $key => $image)
                        <div class="col-lg-2 position-relative my-4">
                            <img class="img-fluid" src="{{ asset("upload/product/$store->id/album/$image->url") }}" alt="">
                            <input type="hidden" name="imageOld" value="{{ $image->url }}">
                            <div class="removeFileAlbum position-absolute top-0 right-0 d-block">
                                <i class="fa-regular fa-circle-xmark text-dark" onclick="removeFileOnlyAlbum({{ $key }})"></i>
                            </div>
                            </div>
                        @endforeach
                    @endforeach --}}
                </div>
            </div>
            
            <div class="col-lg-12 mb-4 flex-basic w-45">
                <label for="" class="form-label">Xuất sứ: </label>
                <input type="text"  name="origin" value="{{ $product->origin }}" class="form-control">
            </div>
            <div class="col-lg-12 mb-4 flex-basic w-45">
                <label for="" class="form-label">Tiêu đề: </label>
                <input type="text"  name="title" value="{{ $product->title }}" class="form-control">
            </div>
            <div class="col-lg-12 mb-4 flex-basic w-45">
                <label for="" class="form-label">Từ khoá: </label>
                <input type="text"  name="keyword[]" data-role="tagsinput" class="form-control" value="
                {{ $product->keyword }}
                ">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <label for="" class="form-label">Phân loại sản phẩm: </label>
            <div class="d-flex my-3">
                <input type="radio" class="btn-check" value="2" name="type" id="option1" autocomplete="off" >
                <label class="btn btn-secondary me-2 button-selected-size fs-3" for="option1">Chọn thuộc tính</label>
                <input type="radio" class="btn-check" value="1" name="type" id="option2" autocomplete="off" >
                <label class="btn btn-secondary me-2 button-selected-color fs-3" for="option2">Chọn Màu</label>
                <input type="radio" class="btn-check" value="0" name="type" id="option3" autocomplete="off" checked>
                <label class="btn btn-secondary me-2 button-selected-all fs-3" for="option3">Chọn cả 2</label>
            </div>
            <div class="d-flex mb-4 flex-column" id="selected-size">
                <div class="my-2">
                    <div class="d-flex mb-2" id="show-attribute">
                        <div class="checkbox-attribute me-2">
                            <input type="radio" value="{{ $product->attributes[0]->attribute }}" name="attribute" class="btn-check btn-attribute" id="attribute-{{ $product->attributes[0]->attribute }}" autocomplete="off" checked>
                            <label class="btn btn-primary fs-4" for="attribute-{{ $product->attributes[0]->attribute }}">{{ $product->attributes[0]->attribute }}</label>
                        </div>
                    </div>
                    <input type="text" id="add-attribute" class="input-add-size" placeholder="Thêm thuộc tính">
                    <button type="button" id="btn-attribute" class="btn btn-danger fs-3">Thêm thuộc tính</button>
                </div>
                <div class="d-flex my-2" id="template-size">
                    <div class="checkbox-size me-2">
                        <input type="checkbox" value="S" name="size[]" class="btn-check btn-size" id="size-S" autocomplete="off">
                        <label class="btn btn-primary fs-4" for="size-S">S</label>
                    </div>
                    <div class="checkbox me-2">
                        <input type="checkbox" value="M" name="size[]" class="btn-check btn-size" id="size-M" autocomplete="off">
                        <label class="btn btn-primary fs-4" for="size-M">M</label>
                    </div>
                    <div class="checkbox me-2">
                        <input type="checkbox" value="L" name="size[]" class="btn-check btn-size" id="size-L" autocomplete="off">
                        <label class="btn btn-primary fs-4" for="size-L">L</label>
                    </div>
                    <div class="checkbox me-2">
                        <input type="checkbox" value="XL" name="size[]" class="btn-check btn-size" id="size-XL" autocomplete="off">
                        <label class="btn btn-primary fs-4" for="size-XL">XL</label>
                    </div>
                    <div class="checkbox me-2">
                        <input type="checkbox" value="128GB" name="size[]" class="btn-check btn-size" id="size-128GB" autocomplete="off">
                        <label class="btn btn-primary fs-4" for="size-128GB">128GB</label>
                    </div>
                </div>
                <div class="button-add-size">
                    <input type="text" placeholder="Thêm giá trị" class="input-add-size" id="text-size">
                    <button type="button" class="btn btn-danger fs-4" id="input-add-size">Thêm giá trị thuộc tính</button>
                </div>
            </div>
            <div class="d-flex align-items-center" id="selected-color" >
                <div class="d-flex" id="template-color">
                    <div class="checkbox-color me-3">
                        <input type="checkbox" class="btn-check btn-color-input" name="color[]" value="#0000ff" id="color-#0000ff"  autocomplete="off">
                        <label style="background: #0000ff;" class="rounded-circle btn-color" for="color-#0000ff"></label>
                    </div>
                    <div class="checkbox-color me-3">
                        <input type="checkbox" class="btn-check btn-color-input" name="color[]"  value="#ff0000" id="color-#ff0000"  autocomplete="off">
                        <label style="background: #ff0000;" class="rounded-circle btn-color"  for="color-#ff0000"></label>
                    </div>
                    <div class="checkbox-color me-3">
                        <input type="checkbox" class="btn-check btn-color-input" name="color[]"  value="#ffc0cb" id="color-#ffc0cb"  autocomplete="off">
                        <label style="background: #ffc0cb;" class="rounded-circle btn-color" for="color-#ffc0cb"></label>
                    </div>
                    <div class="checkbox-color me-3">
                        <input type="checkbox" class="btn-check btn-color-input" name="color[]"  value="#ffffff" id="color-#ffffff" autocomplete="off">
                        <label style="background: #ffffff;" class="rounded-circle btn-color" for="color-#ffffff"></label>
                    </div>
                </div>
                <div class="button-add-color d-flex align-items-center">
                    <input type="color" class="input-add-color me-3 form-control-color" id="text-color">
                    <button type="button" class="btn btn-danger fs-4" id="input-add-color">Thêm màu mới</button>
                </div>
            </div>
            <button type="button" class="btn btn-primary mt-2 fs-3" id="confirm-attribute">Xác nhận</button>
            <div class="row mt-4 table-attribute" style="display: none">
                {{-- <h2 class="fs-1">Các thuộc tính</h2> --}}
                <div class="col-lg-12 d-flex flex-column">
                    <h3>Thiết lập nhanh giá trị phân loại</h3>
                    <div class="d-flex col-lg-12">
                        <input type="text" id="priceSpeed" class="form-control w-18 me-4" placeholder="Giá bán">
                        <input type="text" id="saleSpeed" class="form-control w-18 me-4" placeholder="Sale">
                        <input type="text" id="weightSpeed" class="form-control w-18 me-4" placeholder="Trọng lượng">
                        <input type="text" id="quantitySpeed" class="form-control w-18 me-4" placeholder="Tồn kho">
    
                        <button type="button" class="bg-transparent" style="border: none; text-decoration: underline" id="setupValue">Áp dụng cho tất cả</button>
                    </div>
    
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Size</th>
                                <th scope="col">Color</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Giá bán</th>
                                <th scope="col">Sale</th>
                                <th scope="col">Trọng lượng</th>
                                <th scope="col">Tồn kho</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                           
                        </tbody>
                    </table>
                </div>
                <div class="d-flex">
                    <button type="submit" class="btn btn-danger fs-3 w-25">Cập nhật sản phẩm</button>
                </div>
            </div>
            
        </div>
    </div>
</form>

@endsection
@section("scripts")
<script>
   
    let store = "{{ $store->id }}";
    let listAlbumImages = [];
    let string = '{!! json_encode($product->images) !!}';
    
    let objectImage = JSON.parse(string);

    for(let i = 0; i < objectImage.length; i++){
        listAlbumImages.push({
            "name" : objectImage[i].url,
            "url" : objectImage[i].url,
            "file" : objectImage[i].url,
        })
    }
    showImageAlbum()
    function showImageAlbum(){
        let image = "";
        listAlbumImages.forEach((item) => {
                image += `<div class="col-lg-2 position-relative my-4">
                <img class="img-fluid" src="{{ asset('upload/product/${store}/album/${item.url}') }}" alt="">
                <div class="removeFileAlbum position-absolute top-0 right-0 d-block">
                    <input type="hidden" name="imageOld[]" value="${item.url}" />
                    <i class="fa-regular fa-circle-xmark text-dark" onclick="removeFileOnlyAlbum(${listAlbumImages.indexOf(item)})"></i>
                </div>
                </div>`;
            
        })
        $("#show-album").html(image)
    }
    window.removeFileOnlyAlbum = (e) => {
        if(listAlbumImages.length == 1){
            document.querySelector("#album").value = '';
        }
        listAlbumImages.splice(e, 1);
        showImageAlbum()
    }

    // Show ra được thuộc tính sản phẩmb
    $(document).ready(function(){
        let listAttributes = [];
        let listAttributeSize = [];
        let listAttributeColor = [];
        $(".table-attribute").show();
        
        let productDetails = JSON.parse('{!! $product->detail !!}');
        let trElement = '';
        productDetails.forEach(function(item, index) {
            console.log(item, index);
            trElement += `
            <tr style="vertical-align: middle;">
                                <th scope="row">${item.attribute_value} <input type="hidden" value="${item.attribute_value}" name="sizeText[]" ></th>
                                <th scope="row"> <label style="background: ${item.color_value ?? ''}; ${!item.color_value ? 'display: flex;justify-content: center;align-items: center; color: red' : ''}" class="rounded-circle btn-color">${ !item.color_value ? '<i class="fa-solid fa-circle-xmark text-red"></i>' : ''  }</label> <input type="hidden" value="${item.color_value}" name="colorText[]" ></th>
                                <td style="width: 200px">
                                    <input type="file" hidden id="image-attribute-${item.attribute_value}-${item.color_value}" class="url_image" name="url_image[]">
                                            <label for="image-attribute-${item.attribute_value}-${item.color_value}" class="upload-file-attribute"><img class="img-fluid" src="{{ asset("upload/product/6/album/`+item.url_image+`") }}" alt=""></label>
                                </td>
                                <td><input type="text" name="price[]" value="${item.price}" placeholder="Nhập giá bán" class="form-control w-50 input-price"></td>
                                <td><input type="text" name="sale[]" value="${item.sale}" placeholder="Nhập giá sale" class="form-control w-50 input-sale"></td>
                                <td><input type="text" name="weight[]" value="${item.weight}" placeholder="Nhập trọng lượng" class="form-control w-50 input-weight"></td>
                                <td><input type="text" name="quantity[]" value="${item.quantity}" placeholder="Nhập tồn kho" class="form-control w-50 input-quantity"></td>
                            </tr>
            `;
        })
        $("#tbody").html(trElement);
    })
        
</script>
@endsection