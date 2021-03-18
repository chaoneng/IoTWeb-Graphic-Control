<?php
// include("./mysql_connect.php");
function get_image()
{
    $name = $_FILES['file']['name'];
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); //取得附檔名，轉換小寫
    $extensions_arr = array("jpg", "jpeg", "png", "gif");
    if (in_array($imageFileType, $extensions_arr)) {
        $image_base64 = base64_encode(file_get_contents($_FILES['file']['tmp_name']));
        $image = 'data:image/' . $imageFileType . ';base64,' . $image_base64;
        return [
            'image' => $image,
            'name' => $name,
        ];
    }
}
if (isset($_POST['upload'])) {
    $image = get_image();
    $image_name = $image['name'];
    $image_conten = $image['image'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>


    <div class="container-fluid ">
        <div class="row w-100">
            <div class="col-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="./index.php">Navbar</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                                </li>
                                <li class="nav-item file-form">
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="file" name="file" class="m-2">
                                        <button class="btn btn-outline-success" type="submit" name="upload" id="upload" class="m-2">上傳檔案</button>
                                    </form>
                                    <button class="btn btn-outline-success" type="submit" name="export" onclick="export_img()" id="export">匯出檔案</button>
                                </li>
                            </ul>

                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id='search' value="AA025-1" style="width: auto;">
                            <button class="btn btn-outline-success" type="submit" onclick="search()">Search</button>

                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <div class="row w-100">

            <div class="col-7">
                <div class="wrap" id="wrap">
                    <?php if (isset($_POST['upload'])) : ?>
                        <img src="<?php echo  './images/' . $image_name ?>" id="img" alt="">
                    <?php endif ?>
                </div>
            </div>
            <div class="col-2">
                <h3>標記點位</h3>
                <input type="radio" name="radio" value="1" id="icon_1"> 1(煙霧偵測器) <br>
                <input type="radio" name="radio" value="2" id="icon_2"> 2(一般磁簧) <br>
                <input type="radio" name="radio" value="3" id="icon_3"> 3(緊急壓扣) <br>
                <input type="radio" name="radio" value="4" id="icon_4"> 4(紅外線偵測器) <br>
                <input type="radio" name="radio" value="5" id="icon_5"> 5(攝影機) <br>

            </div>
            <div class="col-3">
                <div class="mark_list" id="mark_list">
                    <ul id='icon_list_1' class="icon-list-1"></ul>
                    <ul id='icon_list_2' class="icon-list-2"></ul>
                    <ul id='icon_list_3' class="icon-list-3"></ul>
                    <ul id='icon_list_4' class="icon-list-4"></ul>
                    <ul id='icon_list_5' class="icon-list-5"></ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">編輯</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="input-group input-group-sm mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroup-sizing-sm">新增...</span>
                        </div>
                        <input type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" id='text'>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChanges" onclick="saveChanges()">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    <script>
        var mark_id = 1
        var wrap = document.getElementById('wrap')
        var mark_list = document.getElementById('mark_list')
        var icon_1 = document.getElementById('icon_1')
        var icon_2 = document.getElementById('icon_2')
        var img
        var pointsX = []
        var pointsY = [] //用來取得每一個點的座標
        var icon_id = 0 //id對應圖片
        var icon = [] //為點陣列新增對應的icon
        var point = [] //用來取得list中的座標元素
        var delete_point = [] //用來放刪除按鈕
        var mark = [] //用來取得mark元素
        var img_data
        var texts = [] //為每個點新增可編輯文字
        var edit_id //控制現在哪個編輯被選取到
        var icon_list_1 = document.getElementById('icon_list_1')
        var icon_list_2 = document.getElementById('icon_list_2')
        var icon_list_3 = document.getElementById('icon_list_3')
        var icon_list_4 = document.getElementById('icon_list_4')
        var icon_list_5 = document.getElementById('icon_list_5')




        function setPointTitle(icon_id) {
            switch (icon_id) {
                case 1:
                    return '煙霧'
                case 2:
                    return '磁簧'
                case 3:
                    return '壓扣'
                case 4:
                    return '紅外線'
                case 5:
                    return '攝影機'
            }
        }


        //把陣列中的undefined清除掉
        function initArrar() {
            pointsX = pointsX.filter(function(s) {
                if (s != undefined) {
                    return s
                }
            })
            pointsY = pointsY.filter(function(s) {
                if (s != undefined) {
                    return s
                }
            })
            icon = icon.filter(function(s) {
                if (s != undefined) {
                    return s
                }
            })
            texts = texts.filter(function(s) {
                if (s != 'undefined') {
                    return s
                }
            })
        }

        function import_point_addEvent() { //把事件新增到刪除匯入資料的按鈕上
            for (let i = 1; i < pointsX.length + 1; i++) {
                mark[i] = document.getElementById('mark' + i)
                point[i] = document.getElementById('point' + i)
                delete_point[i] = document.getElementById('delete_btn' + i)
                delete_point[i].addEventListener('click', function() {
                    delete pointsX[i - 1]
                    delete pointsY[i - 1]
                    delete icon[i - 1]
                    texts[i - 1] = 'undefined'
                    wrap.removeChild(mark[i])
                    point[i].parentNode.removeChild(point[i])
                    console.log(i)
                })
                var edit_btn = []
                edit_btn[i] = document.getElementById('edit_btn' + i)
                edit_btn[i].addEventListener('click', function() {
                    edit_id = i
                    if (texts[i - 1] == 'empty') {
                        text.value = ''
                    } else {
                        text.value = texts[i - 1]
                    }
                })
            }
        }

        //點擊新增按鈕時加入事件
        function addEvent(icon_id, x, y) {
            var newmark_id = document.getElementById('new_mark' + mark_id);

            function delete_btn(id) {
                return document.getElementById('new_delete_btn' + mark_id).addEventListener('click', function() {
                    //創建一個閉包，為每次丟進去的id創建一個新的執行域`
                    var newPoint = document.getElementById('point' + id)
                    new_mark = document.getElementById('new_mark' + id)
                    delete pointsX[id - 1]
                    delete pointsY[id - 1]
                    delete icon[id - 1]
                    texts[id - 1] = 'undefined'
                    wrap.removeChild(new_mark)
                    newPoint.parentNode.removeChild(newPoint)
                    console.log(pointsX)
                })
            }

            function edit_btn(id) {
                return document.getElementById('edit_btn' + mark_id).addEventListener('click', function() {
                    edit_id = id
                    if (texts[id - 1] == 'empty') {
                        text.value = ''
                    } else {
                        text.value = texts[id - 1]
                    }
                })
            }
            delete_btn(mark_id)
            edit_btn(mark_id)
            newmark_id.style['top'] = y - 4 + 'px'
            newmark_id.style['left'] = x - 4 + 'px'
            pointsX.push(x);
            pointsY.push(y);
            icon.push(icon_id)
        }

        function img_event() {
            img = document.getElementById('img')
            img.addEventListener('click', function(e) {
                //座標是抓到案在img上面的座標(相對於整個頁面)，去剪掉warp在頁面中的座標。
                var newmark = document.createElement('div')
                if (icon_1.checked == true) {

                    newmark.setAttribute('class', 'mark_icon_1')
                    newmark.setAttribute('id', 'new_mark' + mark_id)
                    icon_id = 1
                    var point_X = e.pageX - wrap.offsetLeft
                    var point_Y = e.pageY - wrap.offsetTop
                    var newPoint = document.createElement('li') //建立一個li元素
                    newPoint.setAttribute('id', 'point' + mark_id)
                    title = document.createTextNode(setPointTitle(icon_id))
                    textNode = document.createTextNode('X:' + point_X + ' ' + 'Y:' + point_Y)
                    newPoint.appendChild(title)
                    newPoint.appendChild(textNode)
                    icon_list_1.appendChild(newPoint) //把它放到mark_list下
                    var editPoint = document.createElement('button')
                    editPoint_textNode = document.createTextNode('edit')
                    editPoint.appendChild(editPoint_textNode)
                    editPoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    editPoint.setAttribute('id', 'edit_btn' + mark_id)
                    editPoint.setAttribute('data-bs-toggle', 'modal')
                    editPoint.setAttribute('data-bs-target', '#exampleModal')
                    var deletePoint = document.createElement('button')
                    deletePoint_textNode = document.createTextNode('delete')
                    deletePoint.appendChild(deletePoint_textNode)
                    deletePoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    deletePoint.setAttribute('id', 'new_delete_btn' + mark_id)
                    var getPoint = document.getElementById('point' + mark_id)
                    getPoint.appendChild(editPoint)
                    getPoint.appendChild(deletePoint)
                }
                if (icon_2.checked == true) {

                    newmark.setAttribute('class', 'mark_icon_2')
                    newmark.setAttribute('id', 'new_mark' + mark_id)
                    icon_id = 2
                    var point_X = e.pageX - wrap.offsetLeft
                    var point_Y = e.pageY - wrap.offsetTop
                    var newPoint = document.createElement('li') //建立一個li元素
                    newPoint.setAttribute('id', 'point' + mark_id)
                    title = document.createTextNode(setPointTitle(icon_id))
                    textNode = document.createTextNode('X:' + point_X + ' ' + 'Y:' + point_Y)
                    newPoint.appendChild(title)
                    newPoint.appendChild(textNode)
                    icon_list_2.appendChild(newPoint) //把它放到mark_list下
                    var editPoint = document.createElement('button')
                    editPoint_textNode = document.createTextNode('edit')
                    editPoint.appendChild(editPoint_textNode)
                    editPoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    editPoint.setAttribute('id', 'edit_btn' + mark_id)
                    editPoint.setAttribute('data-bs-toggle', 'modal')
                    editPoint.setAttribute('data-bs-target', '#exampleModal')
                    var deletePoint = document.createElement('button')
                    deletePoint_textNode = document.createTextNode('delete')
                    deletePoint.appendChild(deletePoint_textNode)
                    deletePoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    deletePoint.setAttribute('id', 'new_delete_btn' + mark_id)
                    var getPoint = document.getElementById('point' + mark_id)
                    getPoint.appendChild(editPoint)
                    getPoint.appendChild(deletePoint)
                }
                if (icon_3.checked == true) {

                    newmark.setAttribute('class', 'mark_icon_3')
                    newmark.setAttribute('id', 'new_mark' + mark_id)
                    icon_id = 3
                    var point_X = e.pageX - wrap.offsetLeft
                    var point_Y = e.pageY - wrap.offsetTop
                    var newPoint = document.createElement('li') //建立一個li元素
                    newPoint.setAttribute('id', 'point' + mark_id)
                    title = document.createTextNode(setPointTitle(icon_id))
                    textNode = document.createTextNode('X:' + point_X + ' ' + 'Y:' + point_Y)
                    newPoint.appendChild(title)
                    newPoint.appendChild(textNode)
                    icon_list_3.appendChild(newPoint) //把它放到mark_list下
                    var editPoint = document.createElement('button')
                    editPoint_textNode = document.createTextNode('edit')
                    editPoint.appendChild(editPoint_textNode)
                    editPoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    editPoint.setAttribute('id', 'edit_btn' + mark_id)
                    editPoint.setAttribute('data-bs-toggle', 'modal')
                    editPoint.setAttribute('data-bs-target', '#exampleModal')
                    var deletePoint = document.createElement('button')
                    deletePoint_textNode = document.createTextNode('delete')
                    deletePoint.appendChild(deletePoint_textNode)
                    deletePoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    deletePoint.setAttribute('id', 'new_delete_btn' + mark_id)
                    var getPoint = document.getElementById('point' + mark_id)
                    getPoint.appendChild(editPoint)
                    getPoint.appendChild(deletePoint)
                }
                if (icon_4.checked == true) {

                    newmark.setAttribute('class', 'mark_icon_4')
                    newmark.setAttribute('id', 'new_mark' + mark_id)
                    icon_id = 4
                    var point_X = e.pageX - wrap.offsetLeft
                    var point_Y = e.pageY - wrap.offsetTop
                    var newPoint = document.createElement('li') //建立一個li元素
                    newPoint.setAttribute('id', 'point' + mark_id)
                    title = document.createTextNode(setPointTitle(icon_id))
                    textNode = document.createTextNode('X:' + point_X + ' ' + 'Y:' + point_Y)
                    newPoint.appendChild(title)
                    newPoint.appendChild(textNode)
                    icon_list_4.appendChild(newPoint) //把它放到mark_list下
                    var editPoint = document.createElement('button')
                    editPoint_textNode = document.createTextNode('edit')
                    editPoint.appendChild(editPoint_textNode)
                    editPoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    editPoint.setAttribute('id', 'edit_btn' + mark_id)
                    editPoint.setAttribute('data-bs-toggle', 'modal')
                    editPoint.setAttribute('data-bs-target', '#exampleModal')
                    var deletePoint = document.createElement('button')
                    deletePoint_textNode = document.createTextNode('delete')
                    deletePoint.appendChild(deletePoint_textNode)
                    deletePoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    deletePoint.setAttribute('id', 'new_delete_btn' + mark_id)
                    var getPoint = document.getElementById('point' + mark_id)
                    getPoint.appendChild(editPoint)
                    getPoint.appendChild(deletePoint)
                }
                if (icon_5.checked == true) {

                    newmark.setAttribute('class', 'mark_icon_5')
                    newmark.setAttribute('id', 'new_mark' + mark_id)
                    icon_id = 5
                    var point_X = e.pageX - wrap.offsetLeft
                    var point_Y = e.pageY - wrap.offsetTop
                    var newPoint = document.createElement('li') //建立一個li元素
                    newPoint.setAttribute('id', 'point' + mark_id)
                    title = document.createTextNode(setPointTitle(icon_id))
                    textNode = document.createTextNode('X:' + point_X + ' ' + 'Y:' + point_Y)
                    newPoint.appendChild(title)
                    newPoint.appendChild(textNode)
                    icon_list_5.appendChild(newPoint) //把它放到mark_list下
                    var editPoint = document.createElement('button')
                    editPoint_textNode = document.createTextNode('edit')
                    editPoint.appendChild(editPoint_textNode)
                    editPoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    editPoint.setAttribute('id', 'edit_btn' + mark_id)
                    editPoint.setAttribute('data-bs-toggle', 'modal')
                    editPoint.setAttribute('data-bs-target', '#exampleModal')
                    var deletePoint = document.createElement('button')
                    deletePoint_textNode = document.createTextNode('delete')
                    deletePoint.appendChild(deletePoint_textNode)
                    deletePoint.setAttribute('class', 'btn btn-outline-success mx-1')
                    deletePoint.setAttribute('id', 'new_delete_btn' + mark_id)
                    var getPoint = document.getElementById('point' + mark_id)
                    getPoint.appendChild(editPoint)
                    getPoint.appendChild(deletePoint)
                    console.log(pointsX)
                }

                wrap.insertBefore(newmark, img)
                addEvent(icon_id, point_X, point_Y)
                texts[mark_id - 1] = 'empty'
                mark_id++
            })
        }

        //寫入檔案到資料庫
        function export_img() {
            initArrar()
            var name = img.getAttribute('src').replace('./images/', '');
            name.replace('./images/', '')
            var pointsX_export = JSON.stringify(pointsX)
            var pointsY_export = JSON.stringify(pointsY) //轉成json
            var icon_export = JSON.stringify(icon)
            var texts_export = JSON.stringify(texts)
            $.ajax({
                type: 'POST',
                url: 'export.php',
                dataType: "json",
                data: {
                    name: name,
                    pointsX: pointsX_export,
                    pointsY: pointsY_export,
                    icon: icon_export,
                    text: texts_export
                },
            })
        }

        function importImg() {
            var import_img = document.createElement('img')
            import_img.setAttribute('src', img_data.image)
            import_img.setAttribute('id', 'img')
            wrap.appendChild(import_img)
            img_event()
            let import_pointX = JSON.parse(img_data.x)
            let import_pointY = JSON.parse(img_data.y)
            let import_icon = JSON.parse(img_data.icon)
            let import_text = JSON.parse(img_data.text)
            console.log(parseInt(import_text[1]))
            for (let i = 1; i < import_pointX.length + 1; i++) {
                let addMark = document.createElement('div')
                addMark.setAttribute('class', 'mark_icon_' + import_icon[i - 1])
                addMark.setAttribute('id', 'mark' + i)
                addMark.setAttribute('style', 'top:' + (parseInt(import_pointY[i - 1]) - 4) + 'px;left:' + (parseInt(import_pointX[i - 1]) - 4) + 'px')
                wrap.insertBefore(addMark, img)
                pointsX.push(import_pointX[i - 1])
                pointsY.push(import_pointY[i - 1])
                icon.push(import_icon[i - 1])
                let addPoint = document.createElement('li')
                addPoint.setAttribute('class', 'point' + i)
                addPoint.setAttribute('id', 'point' + i)
                title = document.createTextNode(setPointTitle(import_icon[i - 1]))
                textNode = document.createTextNode('X:' + (parseInt(import_pointX[i - 1])) + ' ' + 'Y:' + (parseInt(import_pointY[i - 1])))
                addPoint.appendChild(title)
                addPoint.appendChild(textNode)
                switch (icon[i - 1]) {
                    case 1:
                        icon_list_1.appendChild(addPoint)
                        break
                    case 2:
                        icon_list_2.appendChild(addPoint)
                        break
                    case 3:
                        icon_list_3.appendChild(addPoint)
                        break
                    case 4:
                        icon_list_4.appendChild(addPoint)
                        break
                    case 5:
                        icon_list_5.appendChild(addPoint)
                        break
                }

                //新增編輯刪除按鈕
                let editPoint = document.createElement('button')
                editPoint_textNode = document.createTextNode('edit')
                editPoint.appendChild(editPoint_textNode)
                editPoint.setAttribute('class', 'btn btn-outline-success mx-1')
                editPoint.setAttribute('id', 'edit_btn' + i)
                editPoint.setAttribute('data-bs-toggle', 'modal')
                editPoint.setAttribute('data-bs-target', '#exampleModal')
                editPoint.setAttribute('data-id', i)
                let deletePoint = document.createElement('button')
                deletePoint_textNode = document.createTextNode('delete')
                deletePoint.appendChild(deletePoint_textNode)
                deletePoint.setAttribute('class', 'btn btn-outline-success mx-1')
                deletePoint.setAttribute('id', 'delete_btn' + i)
                var getPoint = document.getElementById('point' + i)
                getPoint.appendChild(editPoint)
                getPoint.appendChild(deletePoint)
                texts[mark_id - 1] = 'empty'
                mark_id++
            }
            for (i = 0; i < import_pointX.length; i++) {
                texts[i] = import_text[i]
            }
            import_point_addEvent()
        }

        function saveChanges() {
            var text = document.getElementById('text').value
            texts[edit_id - 1] = text
        }


        function search() {
            let search = document.getElementById('search')
            let str = search.value
            $.ajax({
                type: 'POST',
                url: 'search.php',
                dataType: 'json',
                data: {
                    str: str,
                },
                success: function(data) {
                    img_data = data
                    console.log(JSON.parse(img_data.text))
                    importImg()
                },
            })
        }
        <?php if (isset($_POST['upload'])) : ?>
            img_event()
        <?php endif ?>
    </script>
</body>

</html>