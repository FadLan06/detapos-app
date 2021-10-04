<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <input type="file" accept="image/*" onchange="convertImg(event)">
    <div>
        <img src="" width="300" style="margin: 10px 20px" id="ori">
    </div>
    <div>
        <img src="" width="300" style="margin: 10px 20px" id="con">
    </div>
    <input type="text" name="" id="view">

    <script>
        const ori = document.querySelector("#ori");
        const con = document.querySelector("#con");

        function convertImg(event) {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]);
                ori.src = src;

                let canvas = document.createElement('canvas');
                let ctx = canvas.getContext("2d");

                let userImage = new Image();
                userImage.src = src;

                userImage.onload = function() {
                    canvas.width = userImage.width;
                    canvas.height = userImage.height;
                    ctx.drawImage(userImage, 0, 0);

                    // document.body.appendChild(canvas);
                    let webpImage = canvas.toDataURL("image/webp", 1);
                    con.src = webpImage;
                    console.log(ctx)
                }
            }
        }
    </script>
</body>

</html>