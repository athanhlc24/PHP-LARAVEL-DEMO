@extends('admin.layout')
@section("custom_css")
    <link rel="stylesheet" href="/admin/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
@endsection

@section("main_content")
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Student</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="post" action="{{url("/admin/student/create-Student")}}" role="form" enctype="multipart/form-data" >
            @csrf
            <div class="card-body">
                <div class="form-group">
                    <label> Name</label>
                    <input type="text" name="name" class="form-control" required >
                </div>
                <div class="form-group">
                    <label> Age</label>
                    <input type="number" min="18" max="50" name="age" class="form-control" required >
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" required >
                </div>
                <div class="form-group">
                    <label> Telephone</label>
                    <input type="text" name="telephone" class="form-control" required >
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
@section("custom_js")
    <script src="/admin/plugins/select2/js/select2.full.min.js"></script>
    <script type="text/javascript">
        $('.select2').select2();
    </script>
@endsection
