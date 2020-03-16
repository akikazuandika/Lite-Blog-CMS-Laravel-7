@extends('layouts.admin')
@section('title', $title)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ url('admin') }}">Home</a></li>
<li class="breadcrumb-item active">List Posts</li>
@endsection

@section('content')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<div class="row">
    <div class="col-12">
        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="text-center" >Category</th>
                            <th class="text-center" >Tags</th>
                            <th class="text-center" >Comments</th>
                            <th class="text-center" >Published</th>
                            <th class="text-center" >Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $item)
                            <tr>
                                <td style="width:42%" >
                                    <p>{{ ucwords($item->title) }}</p>
                                    <div>
                                        <a class="text-success" href="{{ url('post') . "/" . $item->id }}">View</a>
                                        <a href="{{ url('admin/post/edit') . "/" . $item->id }}">Edit</a>
                                        <a class="text-danger" href="{{ url('admin/post/delete') . "/" . $item->id }}">Delete</a>
                                    </div>
                                </td>
                                <td class="text-center" >{{ $item->category->category_name }}</td>
                                <td class="text-center" >
                                    @foreach ($item->tags as $tag)
                                        {{ ucwords($tag->tag_name) }}
                                        @if (!$loop->last)
                                            {{ ", " }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="text-center" > 4</td>
                                <td class="text-center" >
                                    @if ($item->is_public == 0)
                                        {{ 'No' }}
                                    @else
                                        {{ 'Yes' }}
                                    @endif
                                </td>
                                <td class="text-center" >{{ $item->created_at->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th class="text-center" >Category</th>
                            <th class="text-center" >Tags</th>
                            <th class="text-center" >Comments</th>
                            <th class="text-center" >Published</th>
                            <th class="text-center" >Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
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
</script>
@endsection
