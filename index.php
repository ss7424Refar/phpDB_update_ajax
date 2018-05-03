<!DOCTYPE html>
<html>
<head>

    <title>index.php</title>
    <link href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (Bootstrap 的 JavaScript 插件需要引入 jQuery) -->
    <script src="bootstrap-3.3.7-dist/js/jquery-3.1.1.js"></script>
    <!-- 包括所有已编译的插件 -->
    <script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <!--<script type="text/javascript" src="bootstrap-3.3.7-dist/js/jquery-3.1.1.js"></script>-->
    <script>
        $(document).ready(function () {

            loadStudentInfo();

            selectAll();

            deleteStudentInfo();

            addStudentInfo();

            getUpdateStudentInfo();

            updateStudentInfo();
        });

        function loadStudentInfo() {
            $('#smTable tr:gt(0)').each(function () {
                $(this).remove();
            });
            $.ajax({
                type: "get",
                url: "select.php",
                dataType: "json",
                success: function (result) {
                    console.log(result);

                    for (var i = 0; i < result.length; i++) {
                        $('#smTable').append("<tr></tr>");
                        var lastTr = $('#smTable tr:last');
                        lastTr.append("<td><input type='checkbox' name='chk' value=" + result[i].id + "></td>")
                        lastTr.append("<td>" + result[i].id + "</td>");
                        lastTr.append("<td>" + result[i].name + "</td>");
                        if (result[i].sex == 1) {
                            lastTr.append("<td>" + "男" + "</td>");
                        }else if (result[i].sex == 2) {
                            lastTr.append("<td>" + "女" + "</td>");
                        }
                        // lastTr.append("<td>" + result[i].sex + "</td>");
                        lastTr.append("<td>" + result[i].age + "</td>");
                    }

                    if (result.length == 0) {
                        $('#smTable').append("<tr></tr>");
                        var lastTr = $('#smTable tr:last');
                        lastTr.append("<span>" + "No data" + "</span>");
                    }
                },
                error: function () {
                    alert("查询失败");
                }
            });

        }

        // checkbox
        function selectAll() {
            $('#selectAll').prop("checked", false);
            $('#selectAll').click(function () {
                if (this.checked) {
                    $('input[name=chk]').prop("checked", true);
                } else {
                    $('input[name=chk]').prop("checked", false);
                }
            });
        }

        function getSelectNumber(){
            var checkedArray = [];
            $('input[name=chk]:checked').each(function (i) {
                checkedArray[i] = $(this).val();
            });

            return checkedArray;
        }

        function deleteStudentInfo() {
            $('#delete').click(function () {
                var checkedArray = getSelectNumber();
                console.log(checkedArray);
                if (checkedArray.length == 0) {
                    alert("please select one");
                    return;
                }
                if (confirm("do you want delete?")) {
                    $.ajax({
                        type: "post",
                        url: "delete.php",
                        data: {id: checkedArray},
                        dataType: "json",
                        success: function (res) {
                            if (!res) {
                                alert("delete success");
                                loadStudentInfo();
                            } else {
                                alert("delete fail!");
                            }

                        },
                        error: function () {
                            alert("delete fail!");
                        }

                    });

                }

            });
        }

        function addStudentInfo() {
            $('#add').click(function () {
                $('#add').attr("disabled", "true");
                $.ajax({
                    type : "post",
                    url : "add.php",
                    data: $('#addForm').serialize(),
                    success : function (result) {
                        if (result == "success") {
                            loadStudentInfo();
                            alert("update success!");
                        } else {
                            alert("add failed__" + result);

                        }
                    },
                    error : function(result){
                        alert("add failed" + result.responseText);
                    },
                    complete : function () {
                        $('#myAdd').modal('hide');
                        $(".modal-backdrop").remove();
                        $("body").removeClass('modal-open');
                        $('#add').removeAttr("disabled");
                    }

                });

            });
        }

        function getUpdateStudentInfo(){
            $('#update').click(function () {
                var checkArray = [];
                checkArray = getSelectNumber();
                if (checkArray.length == 0) {
                    alert('please select one');
                    return false;
                } else if (checkArray.length == 1) {
                    console.log(checkArray);
                    $.ajax({
                        type : "post",
                        data : {id: checkArray},
                        url : "returnUpdateData.php",
                        success : function(result){
                            var obj = JSON.parse(result);
                            // $.each(JSON.parse(result), function(idx, obj) {
                            // });
                            $('input[name=upId]').val(obj[0].id);
                            $('input[name=upName]').val(obj[0].name);
                            if (obj[0].sex == 1) {
                                $('input[name=upSex]').prop("checked", "checked");
                            } else if (obj[0].sex == 2) {
                                $('input[name=upSex]').prop("checked", "checked");
                            }
                            $('input[name=upAge]').val(obj[0].age);

                        },
                        error : function(){
                            alert("查询失败");
                            return;
                        }
                    });


                } else {
                    alert('only select one');
                    return false;

                }
            });
        }

        function updateStudentInfo() {
            $('#updateCon').click(function () {
                $('#updateCon').attr("disabled", "true");
                console.log($("#updateForm").serialize());
                $.ajax({
                   type : "post",
                    url : "update.php",
                    data : $('#updateForm').serialize(),
                    success : function (result) {
                        if (result == "success") {
                            loadStudentInfo();
                        }

                    },
                    error : function (result) {
                        alert("update failed!" + result.responseText);
                    },
                    complete : function(){
                        $('#myUpdate').modal('hide');
                        $(".modal-backdrop").remove();
                        $("body").removeClass('modal-open');
                        $('#updateCon').removeAttr("disabled", "true");
                        alert("update success!");
                    }

                });

            });

        }

    </script>
</head>
<body>
<div class="container">

    <div class="col-md-12" id="myTable">
        <span class="label label-primary">Welcome</span>
        <h2></h2>
        <table id='smTable'  class="table table-striped">
            <tr>
                <th><input type='checkbox' id='selectAll'>全选</th>
                <th>id</th>
                <th>name</th>
                <th>sex</th>
                <th>age</th>
            </tr>
        </table>
    </div>
    <div class="col-lg-3">
        <button id="delete" class="btn btn-warning">删除</button>
        <button data-toggle="modal" data-target="#myAdd" class="btn btn-default">添加</button>
        <button class="btn btn-primary" data-toggle="modal" data-target="#myUpdate" id="update">更新</button>

        <div class="modal fade" id="myAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="modal-title">Add </h3>
                    </div>
                    <div class="modal-body">
                        <form id="addForm" class="form-horizontal">
                            <div class="form-group">
                                <label for="NAME" class="col-sm-2 control-label">Name : </label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="NAME" name="name" placeholder="请输入名称">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Sex : </label>
                                <div class="col-sm-5">
                                    <label class="radio-inline"><input type="radio" name="sex" value="1" checked>男</label>
                                    <label class="radio-inline"><input type="radio" name="sex" value="2">女</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Age : </label>
                                <div class="col-sm-5">
                                    <input type="text"  class="form-control" name="age" placeholder="请输入age">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" id="add">提交</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myUpdate" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="myModalLable2">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Update</h3>
                    </div>
                    <div class="modal-body">
                        <form id="updateForm" class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">id : </label>
                                <div class="col-sm-5"><input type="text" class="form-control form-control-static" name="upId" readonly></input></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Name : </label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="upName"></div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Sex : </label>
                                <div class="col-sm-5">
                                    <label class="radio-inline"><input type="radio" name="upSex" value="1" checked>男</label>
                                    <label class="radio-inline"><input type="radio" name="upSex" value="2">女</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Age : </label>
                                <div class="col-sm-5"><input type="text" class="form-control" name="upAge"></div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" id="updateCon">提交</button>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


</body>

</html>
