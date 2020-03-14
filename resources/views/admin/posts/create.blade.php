@extends('layouts.admin')
@section('title', $title)

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ url('posts') }}">Posts</a></li>
<li class="breadcrumb-item active">Create Posts</li>
@endsection

@section('content')
<div class="row">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <div class="col-md-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    Create Post
                </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body pad">
                <div class="mb-1">
                    <div class="form-group col-sm-6">
                        <label>Title</label>
                        <input type="text" id="title" class="form-control" placeholder="Enter the title ...">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group col-sm-6">
                        <label>Url</label>
                        <input type="text" id="slug" class="form-control" placeholder="Enter the title ...">
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-group col-sm-6">
                        <label for="inputThumbnail">File input</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inputThumbnail">
                                <label class="custom-file-label" for="inputThumbnail">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text" id="">Upload</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-sm-12">
                    <textarea id="content" class="textarea" placeholder="Place some text here"
                        style="width: 100%; height: 400px; font-size: 14px; line-height: 16px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                        <p class="text-sm mb-0">
                            Editor <a href="https://github.com/bootstrap-wysiwyg/bootstrap3-wysiwyg">Documentation and license
                                information.</a>
                        </p>
                </div>
                <div class="mb-3 col-md-6">
                    <button onclick="send()" class="btn btn-primary">Save</button>
                    <button onclick="send(true)" class="btn btn-primary">Save & Publish</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-->
</div>

<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function () {
        // Summernote
        $('.textarea').summernote({
            height : 200
        })
    })

    function send(publish = false) {
        let title = $("#title").val()
        let slug = $("#slug").val()
        let thumbnail = "https://via.placeholder.com/1000x400.png"
        let content = $("#content").val()
        let category = 1
        let tags = ["test", "hello"]

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

        let data = {
            title,
            slug,
            thumbnail,
            content,
            category,
            tags
        }

        $.ajax({
            url : "{{ url('admin/post/doCreate') }}",
            method : "POST",
            data,
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                console.log(res);

            }
        })

    }

</script>
@endsection
