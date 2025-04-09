<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-theme="default" data-theme-colors="default">


<!-- Mirrored from themesbrand.com/velzon/html/master/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 29 Oct 2024 07:29:52 GMT -->

<head>

    <meta charset="utf-8" />
    <title>Danh mục người dùng | NN Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />

    <!-- CSS -->
    <?php
    require_once "views/layouts/libs_css.php";
    ?>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- HEADER -->
        <?php
        require_once "views/layouts/header.php";

        require_once "views/layouts/siderbar.php";
        ?>
        
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                                <h4 class="mb-sm-0">Quản lý người dùng</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                        <li class="breadcrumb-item active">Tài khoản</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Danh sách tài khoản</h4>
        <div class="flex-shrink-0">
            
<a href="?act=form-them-nguoi-dung" class="btn btn-soft-success material-shadow-none"><i class="ri-add-circle-line align-middle me-1"></i> Thêm người dùng</button></a>
        </div>
    </div><!-- end card header -->

   <!-- Striped Rows -->
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên người dùng</th>
            <th scope="col">Email</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Số điện thoại</th>
            <th scope="col">Mật khẩu</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Giới tính</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Action</th>
            <th scope="col">Trạng thái</th>
        </tr>

        </thead>
    <tbody>
        <?php foreach($nguoiDungs as $index=>$nguoiDung): ?>
        <tr>
            <th scope="fw-medium"><?= $index+1 ?></th>
            <td><?= $nguoiDung['ten'] ?></td>
            <td><?= $nguoiDung['email'] ?></td>
            <td><?= $nguoiDung['dia_chi'] ?></td>
            <td><?= $nguoiDung['phone'] ?></td>
            <td><?= $nguoiDung['pass'] ?></td>
            <td><?= $nguoiDung['ngay_tao'] ?></td>
            <td>
            <?php 
            if ($nguoiDung['gioi_tinh'] == 1) {?>
            <span class="badge bg-success">Nam</span>
               <?php
            } else { ?>
                <span class="badge bg-danger">Nữ</span>
                <?php 
            }
            ?>
            </td>
            <td><img src="<?= BASE_URL . $nguoiDung['avartar']?>" style="width:80px;" alt=""></td>

            <td>
            <?php 
            if ($nguoiDung['vai_tro'] == 1) {?>
            <span class="badge bg-success">Admin</span>
               <?php
            } else { ?>
                <span class="badge bg-danger">User</span>
                <?php 
            }
            ?>
            </td>
            <td>
            <?php 
            if ($nguoiDung['trang_thai'] == 1) {?>
            <span class="badge bg-success">Hiển thị</span>
               <?php
            } else { ?>
                <span class="badge bg-danger">Không hiển thị</span>
                <?php 
            }
            ?>
            </td>
          
           
            <td>
     <div class="hstack gap-3 flex-wrap">
     <a href="?act=form-sua-nguoi-dung&id_nguoi_dung=<?= $nguoiDung['id'] ?>" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
     <form action="?act=xoa-nguoi-dung" method="POST"
      onsubmit="return confirm('Bạn có đồng ý xóa không')">
    <input type="hidden" name="nguoi_dung_id" value="<?= $nguoiDung['id'] ?>">
    <button type="submit" class="link-danger fs-15" style="border: none; background: none;"><i class="ri-delete-bin-line"></i></button>
    </form>
</div>
     </td>
        </tr>
      
        <tr>
      <?php endforeach; ?>
    </tbody>
</table>
    </div><!-- end card-body -->
</div><!-- end card -->

<script>
    document.getElementById('toggle-code').addEventListener('click', function() {
        const codeView = document.getElementById('code-view');
        if (codeView.style.display === 'none') {
            codeView.style.display = 'block';
            this.innerText = 'Ẩn code';
        } else {
            codeView.style.display = 'none';
            this.innerText = 'Hiện code';
        }
    });
</script>

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <div class="customizer-setting d-none d-md-block">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <?php
    require_once "views/layouts/libs_js.php";
    ?>

</body>

</html>