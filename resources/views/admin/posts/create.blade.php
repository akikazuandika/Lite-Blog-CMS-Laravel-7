@extends('layouts.admin')
@section('title', $title)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ url('posts') }}">Posts</a></li>
<li class="breadcrumb-item active">Create Posts</li>
@endsection

@section('content')
<div class="row">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-body pad">
                <div class="row mb-2">
                    <div class="col col-md-8">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" onchange="changeSlug()" id="title" class="form-control" placeholder="Enter the title ...">
                        </div>
                    </div>

                    <div class="col col-md-4">
                        <div class="form-group">
                            <label>Category</label>
                            <select id="category" class="form-control select2bs4" style="width: 100%;"
                                data-placeholder="Select a category">
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" >{{ $item->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Url</label>
                            <input type="text" onkeyup="showUrl()" id="slug" class="form-control" placeholder="Enter the title ...">
                            <span id="showUrlWrapper" style="display: none" > Your post available at : {{ url('post') }}/<span id="showSlug" ></span> </span>
                            <span id="showErrorSlug" style="display: none">This slug is not available</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tags</label>
                            <div class="select2-purple">
                                <select id="tags" class="select2bs4" multiple="multiple"
                                    data-placeholder="Select some tags" style="width: 100%;">
                                    @foreach ($tags as $item)
                                        <option value="{{ $item->id }}">{{ $item->tag_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="inputThumbnail">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input onchange="uploadImage()" type="file" class="custom-file-input"
                                        id="inputThumbnail" style="cursor: pointer">
                                    <label class="custom-file-label" for="inputThumbnail">Choose file</label>
                                    <input type="text" id="imagePath" style="display: none">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5" id="wrapperUploadedImage" style="height: 150px">
                        <img src="https://awmaa.com/wp-content/uploads/2017/04/default-image.jpg"
                            style="max-width:100%; max-height:100%">
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-12">
                        <textarea id="content" class="textarea" placeholder="Place some text here"
                            style="width: 100%; height: 400px; font-size: 14px; line-height: 16px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                    </div>
                    <div class="col-md-12">
                        <p class="text-sm mb-0">
                            Editor <a href="https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg">Documentation and
                                license information.</a>
                        </p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-12">
                        <button onclick="send()" class="btn btn-primary btn-send">Save</button>
                        <button onclick="send(true)" class="btn btn-primary btn-send">Save & Publish</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function () {
        // Summernote
        $('.textarea').summernote({
            height : 200
        })

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    })

    $("#slug").blur(() => {
        if ($("#slug").val() != "") {
            $("#slug").removeAttr("onchange")
        }
    })

    function showUrl() {
        $("#showUrlWrapper").css("display", "block")
        $("#showSlug").html($("#slug").val())
    }

    function changeSlug(){
        let title = $("#title").val()
        title = title.replace(/[^A-Z0-9]+/ig, "-")
        $("#slug").val(title)
        showUrl()
        checkSlug(title)
    }

    function checkSlug(slug) {
        $.ajax({
            url : "{{ url('admin/post/check-slug') }}",
            method : "POST",
            data : {
                slug
            },
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                if (res.success) {
                    $("#showUrlWrapper").css("display", "block")
                    $("#showErrorSlug").css("display", "none")
                    $("#slug").attr("class", "form-control is-valid")
                    $(".btn-send").attr("disabled", false)
                }else{
                    $("#showUrlWrapper").css("display", "none")
                    $("#showErrorSlug").css("display", "block")
                    $("#slug").attr("class", "form-control is-invalid")
                    $(".btn-send").attr("disabled", true)
                }
            }
        })
    }

    function uploadImage() {
        let formData = new FormData()
        formData.append("file", $('input[type=file]')[0].files[0])

        $.ajax({
            url : "{{ url('admin/image/upload') }}",
            method : 'POST',
            data : formData,
            contentType: false,
            processData: false,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                if (res.success == true) {
                    $("#wrapperUploadedImage").empty()
                    $("#wrapperUploadedImage").append(`
                    <img src="${res.url}" style="max-width:100%; max-height:100%; cursor:pointer" onclick="window.open('${res.url}')" >
                    `)
                    $("#imagePath").val(res.url)
                }else{
                    alert("Failed upload a image")
                }
            }
        })
    }

    function send(publish = false) {
        let title = $("#title").val()
        let slug = $("#slug").val()
        let thumbnail = $("#imagePath").val()
        let content = $("#content").val()
        let category = $("#category").val()
        let tags = $("#tags").val()

        if (title == "" || title == undefined) {
            return alert("Title Empthy")
        }

        if (slug == "" || slug == undefined) {
            return alert("slug Empthy")
        }

        if (thumbnail == "" || thumbnail == undefined) {
            return alert("Thumbnail Empthy")
        }

        if (content == "" || content == undefined) {
            return alert("Content Empthy")
        }

        if (category == "" || category == undefined) {
            return alert("Category Empthy")
        }

        publish == false ? publish = 0 : publish = 1;

        let data = {
            title,
            slug,
            thumbnail,
            content,
            category,
            tags,
            publish
        }

        $.ajax({
            url : "{{ url('admin/post/doCreate') }}",
            method : "POST",
            data,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                if (res.success) {
                    alert("Success create post")
                    window.location.href = "{{ url('admin/posts') }}"
                }else{
                    alert("Failed create post")
                }
            }
        })

    }

</script>
@endsection
