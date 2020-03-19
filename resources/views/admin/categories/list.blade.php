@extends('layouts.admin')
@section('title', $title)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
<li class="breadcrumb-item active">List Category</li>
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
                    data-target="#addCategoryModal">Add
                    Category</button>
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Create At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                        <tr id="{{ "category_" . $item->id }}">
                            <td style="width:65%">
                                <p>{{ ucwords($item->category_name) }}</p>
                                <div>
                                    <a class="text-success" onclick="showEditModal({{$item->id }})">Edit</a>
                                    <a class="text-danger" style="cursor: pointer"
                                        onclick="deleteCategory('{{$item->id}}')">Delete</a>
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

    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="newCategory" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="newCategory">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="addCategory()">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editCategory" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="editCategory">
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

    function addCategory() {
        let category = $("#newCategory").val();
        $.ajax({
            url : "{{ url('admin/category/doCreate') }}",
            method : "POST",
            data : {
                category
            },
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                alert(res.message)
                if (res.success) {
                    $("tbody").append(`
                        <tr id="${ 'category_' + res.category.id }" >
                            <td style="width:65%">
                                <p>${ ucwords(category) }</p>
                                <div>
                                    <a class="text-success" onclick="showEditModal(${res.category.id})" >Edit</a>
                                    <a class="text-danger" style="cursor: pointer" onclick="deleteCategory('${ res.category.id }')" >Delete</a>
                                </div>
                            </td>
                            <td class="text-center" >${ moment(res.category.created_at).format('DD-MM-YYYY HH:mm') }</td>
                        </tr>
                    `)
                    $('#addCategoryModal').modal('hide')
                }
            }
        })
    }

    function showEditModal(id) {
        $('#editCategoryModal').modal('show')
        var value = $("#category_" + id + " p").html()
        console.log(value);

        $("#editCategory").val(value)
        $("#btnEdit").attr('onclick', `editCategory(${id})`)
    }

    function editCategory(id) {
        let value = $("#editCategory").val();
        $.ajax({
            url : "{{ url('admin/category/edit') }}",
            method : "POST",
            data : {
                id,
                category : value
            },
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : (res) => {
                alert(res.message)
                if (res.success) {
                    $("#category_" + id + " p").html(value)
                }
            }
        })

    }

    function ucwords(string) {
        return string[0].toUpperCase() + string.slice(1)
    }

    function deleteCategory(id) {
        $.ajax({
            url : "{{ url('admin/category/delete') }}",
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
                    $("#category_" + id).remove()
                }
            }
        })
    }
</script>
@endsection
