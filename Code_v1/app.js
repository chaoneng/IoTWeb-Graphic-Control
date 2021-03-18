//  var li_id = 1
//         var mask_id = 1
//         <?php if (isset($pointX)) {
//             echo "var li_id =" . (count($pointX) + 1);
//         } ?>

//         <?php if (isset($pointX)) {
//             echo "var mask_id =" . (count($pointX) + 1);
//         } ?>

//         var wrap = document.getElementById('wrap')
//         var mask = document.getElementById('mask')
//         var img = document.getElementById('img')
//         var mask_list = document.getElementById('mask_list')
//         var pointsX = []
//         var pointsY = []

//         <?php if (isset($pointX)) {
//             for ($i = 0; $i < count($pointX); $i++) {
//                 echo "pointsX.push(" . $pointX[$i] . ")" . "
//                 ";

//                 echo "pointsY.push(" . $pointY[$i] . ")" . "
//                 ";
//             }
//         }

//         ?>

//         console.log(pointsX)

//         function getId(id, x, y) {
//             var newMask_id = document.getElementById('Mask' + id);
//             newMask_id.style['top'] = y - 4 + 'px'
//             newMask_id.style['left'] = x - 4 + 'px'
//             pointsX.push(x);
//             pointsY.push(y);
//         }

//         img.addEventListener('click', function(e) {
//             //座標是抓到案在img上面的座標(相對於整個頁面)，去剪掉warp在頁面中的座標。
//             var point_X = e.pageX - wrap.offsetLeft
//             var point_Y = e.pageY - wrap.offsetTop

//             var newPoint = document.createElement('li') //建立一個li元素
//             newPoint.setAttribute('id', 'Point' + li_id)
//             textNode = document.createTextNode('x座標:' + point_X + ' ' + 'y座標:' + point_Y)
//             newPoint.appendChild(textNode)
//             mask_list.appendChild(newPoint) //把它放到mask_list下

//             var newMask = document.createElement('div')
//             newMask.setAttribute('class', 'mask')
//             newMask.setAttribute('id', 'Mask' + mask_id)
//             wrap.insertBefore(newMask, img)
//             getId(mask_id, point_X, point_Y)
//             li_id++
//             mask_id++

//             console.log(mask_id)
//         })

//         // function upload_img() {
//         //     $.ajax({
//         //         tpye: 'POST',
//         //         url: 'upload.php',
//         //         dataType: "json",
//         //         data: {

//         //         },
//         //         success: function() {
//         //             var result = document.getElementById("success");
//         //             result.innerHTML = "成功";
//         //         },
//         //         error: function() {
//         //             var result = document.getElementById("success");
//         //             result.innerHTML = "失敗";
//         //         }
//         //     })
//         // }

//         function export_img() {
//             var imgContent = img.src
//             var name = '<?php echo $_FILES["file"]["name"]; ?>';
//             var pointsX_export = JSON.stringify(pointsX)
//             var pointsY_export = JSON.stringify(pointsY) //轉成json

//             // console.log(imgContent);
//             // var xhr = new XMLHttpRequest();
//             // xhr.open('get', 'getImg.php', );
//             // xhr.send();
//             $.ajax({
//                 type: 'POST',
//                 url: 'export.php',
//                 dataType: "json",
//                 data: {
//                     name: name,
//                     imgContent: imgContent,
//                     pointsX: pointsX_export,
//                     pointsY: pointsY_export,

//                 },

//                 success: function() {
//                     var result = document.getElementById("success");
//                     result.innerHTML = "成功";
//                 },
//                 error: function() {
//                     var result = document.getElementById("success");
//                     result.innerHTML = "失敗";
//                 }
//             })
//         }
