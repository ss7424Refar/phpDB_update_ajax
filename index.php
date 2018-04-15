<!DOCTYPE html>
<html>
<head>
    <title>index.php</title>
</head>
<script type="text/javascript" src="bootstrap-3.3.7-dist/js/jquery-3.1.1.js"></script>
<script>
    $(document).ready(function () {

        loadStudentInfo();

        selectAll();

        getCheckedID();
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
                    lastTr.append("<td>" + result[i].sex + "</td>");
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

    function getCheckedID() {
        $('#delete').click(function () {
            var checkedArray = [];
            $('input[name=chk]:checked').each(function (i) {
                checkedArray[i] = $(this).val();
            });
            console.log(checkedArray);
            if (confirm("do you want delete?")) {
                if (checkedArray.length == 0) {
                    alert("please select one");
                    return;
                }
                $.ajax({
                    type: "post",
                    url: "delete.php",
                    data: {id: checkedArray},
                    dataType: "json",
                    success: function (res) {
                        if (!res){
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


</script>
<body>

<span>welcome</span>
<div class="col-md-11" id="myTable">
    <table id='smTable' border='1px'>
        <tr>
            <th><input type='checkbox' id='selectAll'>全选</th>
            <th>id</th>
            <th>name</th>
            <th>sex</th>
            <th>age</th>
        </tr>
    </table>
</div>
<button id="delete">删除</button>
<button id="add">添加</button>
<button id="update">更新</button>


</body>

</html>


<?php
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-4-14
 * Time: 下午2:43
 */

?>