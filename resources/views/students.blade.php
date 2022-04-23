<html>
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">

    {{--//modal--}}
    <div class="container">
        <h2>Add Student</h2>
        <!-- Trigger the modal with a button -->
        <button type="button" id="add_std" class="btn btn-info btn-lg">Open Modal</button>

        <!-- Modal -->
        <div class="modal fade" id="modal_std" role="dialog">
            <div class="modal-dialog">


                <form id="form_std">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title"></h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="name" id="name_std" class="form-control" placeholder="Enter Name">
{{--                        <input type="text" name="email" id="email_std" class="form-control" placeholder="Enter Email">--}}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
                </form>


            </div>
        </div>

    </div>




    {{--list--}}
    <h1>Student List</h1>
    <table class="table table-bordered data-table">
        <thead>
          <tr>
              <th>NO</th>
              <th>name</th>
{{--              <th>email</th>--}}
              <th>Action</th>
          </tr>
        </thead>

        <tbody id="list_std">
        @foreach($students as $std)

            <tr id="row_std_"{{$std->id}}>
                <th>{{$std->id}}</th>
                <th>{{$std->name}}</th>
{{--                <th>{{$std->email}}</th>--}}
                <th>
                    <button type="button" id="edit_std" class="btn btn-info btn-lg" data-toggle="modal" data-id="{{$std->id}}">Edit</button>
                    <button type="button" id="delete_std" class="btn btn-danger btn-lg" data-toggle="modal" data-id="{{$std->id}}">Delete</button>

                </th>
            </tr>


        @endforeach

        </tbody>
    </table>


</div>


</body>


<script type="text/javascript">



    $(document).ready(function () {

            $.ajaxSetup({
                headers:{
                    'x-csrf-token' : $('meta[name="csrf-token"]').attr('content')
                }
            })

    });

    // modal
    $('#add_std').on('click', function () {
        $('#form_std').trigger('reset');
        $("#modal_title").html('Add Student');
        $('#modal_std').modal('show');
    });

    // edit
    $('body').on('click','#edit_std', function () {
        var id =$(this).data(id);

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: 'student/edit/'+id.id,
            // data: {id: id},
            type: "GET",
            cache: false,
            dataType: 'json',
            success: function (data) {

                console.log(data);
                console.log(data.name);

                $("#modal_title").html('Edit Student');
                $("#id").val(data.id);
                $("#name_std").val(data.name);
                $("#email_std").val(data.email);

                $('#modal_std').modal('show');


            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });

    // add
    $('form').on('submit', function (e) {

        e.preventDefault();

        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "/student/send",
            data: $('#form_std').serialize(),
            type: "POST",
            cache: false,
            dataType: 'json',
            success: function (data) {

                console.log(data);
                console.log(data.name);

                var row = '<tr id="row_std_'+data.id+  '">';
                row += '<td>' + data.id + '</td>';
                row += '<td>' + data.name + '</td>';
                // row += '<td>' + data.email + '<td>';
                row += '<td>' + '<button type="button" id="edit_std" class="btn btn-info btn-lg mr-1" data-toggle="modal" data-id="'+ data.id + '">Edit</button>'
                    + '<button type="button" id="del_std" class="btn btn-danger btn-lg" data-toggle="modal" data-id="'+ data.id + '">Delete</button>' +'</td></tr>';


                if ($("#id").val()){
                    $("#row_std_" + data.id).replaceWith(row);
                }else{
                    $("#list_std").prepend(row);
                }

                $("#form_std").trigger('reset');
                $("#modal_std").modal('hide');
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(jqXHR.responseText);
                alert(errorThrown);
            }
        });
    });

    // delete
    $('body').on('click','#delete_std', function () {
            var id =$(this).data(id);
            confirm("Are you sure you want to delete");
            console.log(id.id);

            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: '/student/destroy/' + id.id,
                data: {id: id},
                type: "GET",
                cache: false,
                dataType: 'json',
                success: function (data) {

                    console.log(data);
                    $("#row_std_" + id.id).remove();
                    location.reload();

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert(jqXHR.responseText);
                    alert(errorThrown);
                }
            });
        });


</script>





</html>
