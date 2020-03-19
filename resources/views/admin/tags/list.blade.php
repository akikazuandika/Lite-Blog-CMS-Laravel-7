@extends('layouts.admin')
@section('title', $title)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
<li class="breadcrumb-item active">List Tag</li>
@endsection

@section('content')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<div class="row">
    <div class="col-6">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <button class="btn btn-primary" style="margin-bottom: 20px" data-toggle="modal"
                    data-target="#addTagModal">Add
                    Tag</button>
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Create At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tags as $item)
                        <tr id="{{ "tag_" . $item->id }}">
                            <td style="width:65%">
                                <p>{{ ucwords($item->tag_name) }}</p>
                                <div>
                                    <a class="text-success" onclick="showEditModal({{$item->id }})">Edit</a>
                                    <a class="text-danger" style="cursor: pointer"
                                        onclick="deleteTag('{{$item->id}}')">Delete</a>
                                </div>
                            </td>
                            <td class="text-center">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th class="text-center">Create At</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->

    <div class="modal fade" id="addTagModal" tabindex="-1" role="dialog" aria-labelledby="addTagModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTagModalLabel">Add Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="newTag" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="newTag">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addTag()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editTagModal" tabindex="-1" role="dialog" aria-labelledby="editTagModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTagModalLabel">Edit Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editTag" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="editTag">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnEdit">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script>
    $(function () {
      $('#example2').DataTable({
        "paging": false,
        "searching" : false,
        "lengthChange": false,
        "ordering" : false,
        "autoWidth": true,
        "info" : false
      });
    });

    function addTag() {
        let tag = $("#newTag").val();
        $.ajax({
            url : "{{ url('admin/tag/doCreate') }}",
            method : "POST",
            data : {
                tag
            },
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                alert(res.message)
                if (res.success) {
                    $("tbody").append(`
                        <tr id="${ 'tag_' + res.tag.id }" >
                            <td style="width:65%">
                                <p>${ ucwords(tag) }</p>
                                <div>
                                    <a class="text-success" onclick="showEditModal(${res.tag.id})" >Edit</a>
                                    <a class="text-danger" style="cursor: pointer" onclick="deleteTag('${ res.tag.id }')" >Delete</a>
                                </div>
                            </td>
                            <td class="text-center" >${ moment(res.tag.created_at).format('DD-MM-YYYY HH:mm') }</td>
                        </tr>
                    `)
                    $('#addTagModal').modal('hide')
                }
            }
        })
    }

    function showEditModal(id) {
        $('#editTagModal').modal('show')
        var value = $("#tag_" + id + " p").html()
        console.log(value);

        $("#editTag").val(value)
        $("#btnEdit").attr('onclick', `editTag(${id})`)
    }

    function editTag(id) {
        let value = $("#editTag").val();
        $.ajax({
            url : "{{ url('admin/tag/edit') }}",
            method : "POST",
            data : {
                id,
                tag : value
            },
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                alert(res.message)
                if (res.success) {
                    $("#tag_" + id + " p").html(value)
                    $('#addTagModal').modal('hide')
                }
            }
        })

    }

    function ucwords(string) {
        return string[0].toUpperCase() + string.slice(1)
    }

    function deleteTag(id) {
        $.ajax({
            url : "{{ url('admin/tag/delete') }}",
            method : "POST",
            data : {
                id
            },
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                alert(res.message)
                if (res.success) {
                    $("#tag_" + id).remove()
                }
            }
        })
    }
</script>
@endsection
