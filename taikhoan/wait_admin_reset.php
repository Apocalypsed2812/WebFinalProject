<?php
  session_start();
  if (!isset($_SESSION['wait_admin_reset'])) {
    header('Location: login.php');
    exit();
  }
  //session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Gửi yêu cầu thành công</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
      integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
      crossorigin="anonymous"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </head>
  <body style="background: linear-gradient(85deg, #abdcff 0%, #0396ff 100%)">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mt-5 mx-auto p-3 border rounded" >
            <h4 class="text-center" >Gửi yêu cầu thành công</h4>
            <p>Vui lòng đợi admin reset tài khoản của bạn về giá trị mặc định</p>
            <p>Nhấn <a href="login.php">vào đây</a> để trở về trang đăng nhập, hoặc trang web sẽ tự động chuyển hướng sau <span id="counter" class="text-danger">10</span> giây nữa.</p>
        </div>
      </div>
    </div>
  <script>
      let duration = 5;
      let countDown = 1000;
      let id = setInterval(() => {

          countDown --;
          if (countDown >= 0) {
              $('#counter').html(countDown);
          }
          if (countDown == -1) {
              clearInterval(id);
              window.location.href = 'login.php';
          }

      }, 1000);
  </script>
  </body>
</html>
