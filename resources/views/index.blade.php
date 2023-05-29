<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title','students  form')</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<style>
    .error {
        color: red;
    }
</style>

<body>
<nav class="navbar navbar-light navbar-expand-lg mb-5" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand mr-auto" href="#">PositronX</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('signout') }}">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Student
        </button>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="addform" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="email">Firstname:</label>
                                <input type="text" class="form-control" id="firstname" name="firstname">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Lastname:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Date:</label>
                                <input type="date" class="form-control" id="add_date" name="add_date">
                            </div>
                            <div class="form-group">
                                <label for="email">Image:</label>
                                <input type="file" class="form-control" id="file" name="file" onchange="loadImg(event)">
                                <img src="" style=" display: none;" id="myimage" width="100px" height="100px">
                                <input type="hidden" name="image_name" id="image_name" class="image_name">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Salary:</label>
                                <input type="text" class="form-control" id="salary" name="salary">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>FirstName</th>
                    <th>LastName</th>
                    <th>Date</th>
                    <th>Salary</th>
                    <th>Image</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</body>

<script type="text/javascript">
    $(document).ready(function() {
        var token = $("meta[name='csrf-token']").attr("content");

        $('form[id="addform"]').validate({
            rules: {
                firstname: 'required',
                lastname: 'required',
                file: {
                    required: function() {
                        var img_name = $("#image_name").val();
                        if (img_name == "") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                add_date: 'required',
                salary: 'required',
            },
            messages: {
                firstname: 'This field is required',
                lastname: 'This field is required',
                file: 'Please select image',
                add_date: 'Please select date',
                salary: 'This field is required',
            },
            submitHandler: function(form) {
                var data = new FormData(form);
                data.append("file", $("#file")[0].files[0]);
                $.ajax({
                    type: 'POST',
                    url: 'save',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        var data = JSON.parse(data);
                        if (data.status == 1) {
                            $('#exampleModal').modal('toggle');
                            load.ajax.reload();

                        }
                    }
                });
            }
        });

        var load = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "userlist",
                type: 'POST',
                data: {
                    "_token": token
                }
            },
            columns: [{
                    data: 'id',
                    name: 'Id'
                },
                {
                    data: 'firstname',
                    name: 'FirstName'
                },
                {
                    data: 'lastname',
                    name: 'LastName'
                },
                {
                    data: 'date',
                    name: 'Date'
                },
                {
                    data: "img",
                    name: "Image",
                    render: function(data, type, full, meta) {
                        return '<img src="' + data + '" height="50"/>';
                    },
                },
                {
                    data: 'salary',
                    name: 'Salary'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(document).on("click", "#delete", function() {
            var id = $(this).attr('data-id');
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                type: 'POST',
                url: 'delete',
                data: {
                    id: id,
                    _token: token,
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    if (data.status == 1) {
                        load.ajax.reload();
                    }
                }
            });
        });
        $(document).on("click", "#edit", function() {
            var id = $(this).attr('data-id');
            var token = $("meta[name='csrf-token']").attr("content");
            $('#exampleModal').modal('show');
            $.ajax({
                type: 'POST',
                url: 'edit',
                data: {
                    id: id,
                    _token: token,
                },
                success: function(data) {
                    var data = JSON.parse(data);
                    $("#id").val(data.id);
                    $("#firstname").val(data.firstname);
                    $("#lastname").val(data.lastname);
                    $("#salary").val(data.salary);
                    $("#add_date").val(data.date);
                    $("#image_name").val(data.image);

                    if (data.myimage != "") {
                        $("#myimage").css("display", "block");
                        $('#myimage').attr('src', data.myimage);

                    }
                }
            });
        });
        $('#exampleModal').on('hidden.bs.modal', function(e) {
            $("#addform").trigger("reset");
            $('#myimage').attr('src', '');
            $("#myimage").css("display", "none");
        });


    })

    function loadImg(event) {
        document.getElementById("myimage").style.display = "";
        var output = document.getElementById("myimage");
        if (!event.target.files[0]) return;
        output.src = URL.createObjectURL(event.target.files[0]);
        // console.log(URL.createObjectURL(event.target.files[0]));
        output.onload = function() {
            URL.revokeObjectURL(output.src); // free memory
        };
    }
</script>

</html>