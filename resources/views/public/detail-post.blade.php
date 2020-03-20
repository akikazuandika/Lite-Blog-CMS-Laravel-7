@extends('layouts.app')
@section('title', 'Detail ' . $title)

@section('content')
<div class="row">
    <div class="col col-md-12" style="padding : 15px; height:250px">
        <img class="col-md-12" style="max-width:100%; max-height:100%; padding-left: 0px; padding-right: 0px"
            src="{{ $post->thumbnail }}" alt="">
        {!! $post->content !!}
    </div>
    <div class="col-md-12" style="margin-top: 20px">
        <h4>Comments</h4>
        <hr>
        <div id="listComment">

        </div>
        <div class="form-group mt-2">
            <textarea class="form-control" rows="3" id="comment" placeholder="Enter comment..."></textarea>
            <button class="btn btn-primary mt-2" id="btnSend">
                Send
            </button>
        </div>
    </div>

    <script>
        $("#btnSend").click(() => {
            let comment = $("#comment").val()
            let id_post = "{{ $post->id }}"
            $.ajax({
                url : "{{ url('comment/create') }}",
                method : "POST",
                data : {
                    comment,
                    id_post
                },
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : (res) => {
                    alert(res.message)
                    if (res.success) {
                        $("#listComment").append(`
                        <div class="card" id="comment_${res.comment.id}">
                            <div class="card-body">
                                ${res.comment.comment}
                            </div>
                        </div>
                        `)
                        $("#comment").val('')
                    }
                }
            })
        })
    </script>
</div>
@endsection
