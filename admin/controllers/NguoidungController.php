<?php 
class NguoiDungtController
{
    // Kết nối đến file model
    public $modelNguoiDung;
    public function __construct(){
        $this->modelNguoiDung = new NguoiDung();
    }
  public function index() {
    
    // Lấy ra dữ liệu bài viết
    $nguoiDungs = $this->modelNguoiDung->getAll(); // Đảm bảo getAll() trả về một giá trị
    // var_dump($baiViet)
    require_once './views/nguoidung/list_nguoi_dung.php';
}

    
public function formDangki(){
    require_once './views/acc/form_dang_ki.php';
    deleteSessionError();
}
public function DangKi() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form
        $ten = trim($_POST['ten'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $pass = trim($_POST['pass'] ?? '');
        $confirm_pass = trim($_POST['confirm_pass'] ?? '');
        $dia_chi = trim($_POST['dia_chi'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $ngay_tao = date('Y-m-d');
        $gioi_tinh = $_POST['gioi_tinh'] ?? '';
        $avartar = $_FILES['avartar'] ?? '';
        $file_thumb = uploadFile($avartar, './uploads/');
        
        $errors = [];

        // Validate dữ liệu
        if (empty($ten)) {
            $errors['ten'] = 'Tên không được để trống.';
        }
        if (empty($email)) {
            $errors['email'] = 'Email không được để trống.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
            
        }
        if (empty($gioi_tinh)) {
            $errors['gioi_tinh'] = 'Vui lòng chọn giới tính.';
        }
        if (empty($dia_chi)) {
            $errors['dia_chi'] = 'Vui lòng chọn địa chỉ.';
        }
        if (empty($phone)) {
            $errors['phone'] = 'Vui lòng chọn số điện thoại.';
        }
        if (empty($pass)) {
            $errors['pass'] = 'Mật khẩu không được để trống.';
        }
        if (empty($confirm_pass)) {
            $errors['confirm_pass'] = 'Xác nhận mật khẩu không được để trống.';
        } elseif ($pass !== $confirm_pass) {
            $errors['confirm_pass'] = 'Mật khẩu xác nhận không khớp.';
        }
        

        // Nếu có lỗi, lưu vào session và quay lại form
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = $_POST; // Lưu lại dữ liệu đã nhập để điền lại form
            header('Location: ' . BASE_URL_ADMIN . '?act=dang-ki');
            exit();
        }

        // Kiểm tra xem email đã tồn tại chưa
        if ($this->modelNguoiDung->isEmailExists($email)) {
            $_SESSION['errorsEmail'] = ['Email đã được sử dụng.'];
            $_SESSION['form_data'] = $_POST;
            header('Location: ' . BASE_URL_ADMIN . '?act=dang-ki');
            exit();
        }

        // Gán giá trị mặc định cho vai trò và trạng thái
        $vai_tro = 2;  
        $trang_thai = 1;

        // Thực hiện lưu dữ liệu vào DB
        $result = $this->modelNguoiDung->registerUser($ten, $email, $dia_chi, $phone, $pass, $ngay_tao, $gioi_tinh, $file_thumb, $vai_tro, $trang_thai);

        if ($result) {
            // Lấy thông tin người dùng vừa đăng ký
            $user = $this->modelNguoiDung->getUserByEmail($email);
            
            
            // Lưu thông tin người dùng vào session
            $_SESSION['user_admin'] = [
                'id' => $user['id'],
                'ten' => $user['ten'],
                'email' => $user['email'],
                'vai_tro' => $user['vai_tro'],
                'trang_thai' => $user['trang_thai'],
                'gioi_tinh' => $user['gioi_tinh'],
                'avartar' => $user['avartar'],
            ];
        
            // Xóa các session lỗi và dữ liệu cũ
            unset($_SESSION['errors']);
            unset($_SESSION['form_data']);
        
            header('Location: ' . BASE_URL_ADMIN . '?act=dang-ki-thanh-cong');
            exit();
        }
        
    }
}
public function formDetail()
{
$id = $_GET['id_nguoi_dung'];
$nguoiDung = $this->modelNguoiDung->getDetailData($id);

if ($nguoiDung) {
    // Hiển thị trang chỉnh sửa thông tin người dùng
    require_once './views/acc/tai_khoan.php';
    // deleteSessionError();
} else {
    // Lưu thông báo lỗi vào session
    $_SESSION['error'] = 'Người dùng không tồn tại';

    // Chuyển hướng về trang chủ hoặc trang khác
    header('Location: ' . BASE_URL_ADMIN . '?act=detail-tai-khoan');
    exit();
}
}


public function updateAcc()
{
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nguoi_dung_id = $_POST['nguoi_dung_id'] ?? '';

    

    $nguoi_dung_cu = $this->modelNguoiDung->getDetailData($nguoi_dung_id);
    $file_cu = $nguoi_dung_cu['avartar'];






    // Lấy dữ liệu từ POST
    $ten = $_POST['ten'] ?? '';
    $email = $_POST['email'] ?? '';
    $dia_chi = $_POST['dia_chi'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $avartar = $_FILES['avartar'] ?? null;

    // Khởi tạo mảng lỗi
    $errors = [];

    // Validate tên
    if (empty($ten)) {
        $errors['ten'] = 'Tên không được để trống';
    }

    // Validate email
    if (empty($email)) {
        $errors['email'] = 'Email không được để trống';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email không hợp lệ';
    } else {
        $emailExists = $this->modelNguoiDung->isEmailUpdate($email, $nguoi_dung_id);
        if ($emailExists) {
            $errors['email'] = 'Email đã tồn tại';
        }
    }
    if (empty($phone)) {
        $errors['phone'] = 'Chỉnh sửa Số điện thoại';
    }


    // Validate mật khẩu
    if (empty($pass)) {
        $errors['pass'] = 'Mật khẩu không được để trống';
    } elseif (strlen($pass) < 6) {
        $errors['pass'] = 'Mật khẩu phải có ít nhất 6 ký tự';
    }

    // Validate địa chỉ
    if (empty($dia_chi)) {
        $errors['dia_chi'] = 'Địa chỉ không được để trống';
    }

    if (isset($avartar) && $avartar['error'] == UPLOAD_ERR_OK) {
        $file_moi = uploadFile($avartar, './uploads/');
        if ($file_moi) {
            if (!empty($file_cu)) {
                deleteFile($file_cu); // Xóa ảnh cũ nếu có ảnh mới
            }
        } else {
            $file_moi = $file_cu; // Giữ lại ảnh cũ nếu upload không thành công
        }
    } else {
        $file_moi = $file_cu; // Không upload ảnh, giữ lại ảnh cũ
    }
    // var_dump($file_moi);
    // exit();

    // Nếu có lỗi, lưu lỗi vào session và chuyển hướng
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ' . BASE_URL_ADMIN . '?act=detail-tai-khoan&id_nguoi_dung=' . $nguoi_dung_id);
        exit();
    }

    // Cập nhật thông tin người dùng
    $this->modelNguoiDung->updateData(
        $nguoi_dung_id,
        $ten,                     // Cập nhật tên mới
        $email,                   // Cập nhật email mới
        $dia_chi,                 // Cập nhật địa chỉ mới
        $phone,  
        $pass,                    // Cập nhật mật khẩu mới
        $nguoi_dung_cu['ngay_tao'], // Giữ nguyên ngày tạo
        $nguoi_dung_cu['gioi_tinh'], // Giữ nguyên giới tính
        $file_moi,                // Cập nhật ảnh đại diện mới (nếu có)
        $nguoi_dung_cu['vai_tro'], // Giữ nguyên vai trò
        $nguoi_dung_cu['trang_thai'] // Giữ nguyên trạng thái
    );

    // Cập nhật lại thông tin trong session
    $_SESSION['user_admin']['ten'] = $ten;
    $_SESSION['user_admin']['email'] = $email;
    $_SESSION['user_admin']['dia_chi'] = $dia_chi;
    $_SESSION['user_admin']['phone'] = $phone;
    $_SESSION['user_admin']['pass'] = $pass;
   
    $_SESSION['user_admin']['avartar'] = $file_moi; // Lưu đường dẫn ảnh mới

    // Xóa lỗi và thông báo thành công
    unset($_SESSION['error']);
    unset($_SESSION['errors']);
    $_SESSION['success'] = 'Cập nhật thông tin thành công';
    $_SESSION['flash'] = true;

    // Chuyển hướng về trang chi tiết tài khoản
    header('Location: ' . BASE_URL_ADMIN . '?act=detail-tai-khoan&id_nguoi_dung=' . $nguoi_dung_id);
    exit();
}
}

public function formPassword()
{
$id = $_GET['id_nguoi_dung'];
$nguoiDung = $this->modelNguoiDung->getDetailData($id);

if ($nguoiDung) {
    // Hiển thị trang chỉnh sửa thông tin người dùng
    require_once './views/acc/doi_mat_khau.php';
    // deleteSessionError();
} else {
    // Lưu thông báo lỗi vào session
    $_SESSION['error'] = 'Người dùng không tồn tại';

    // Chuyển hướng về trang chủ hoặc trang khác
    header('Location: ' . BASE_URL_ADMIN . '?act=detail-tai-khoan&id_nguoi_dung=' . $nguoi_dung_id);
    exit();
}
}
public function updatePassword()
{
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nguoi_dung_id = $_POST['nguoi_dung_id']; // Giả sử bạn lưu ID người dùng trong session
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Kiểm tra mật khẩu hiện tại
    $nguoi_dung_cu = $this->modelNguoiDung->getDetailData($nguoi_dung_id);
    if (!$nguoi_dung_cu) {
        $_SESSION['error'] = 'Người dùng không tồn tại.';
        header('Location: ' . BASE_URL_ADMIN . '?act=form-password&id_nguoi_dung=' . $nguoi_dung_id);
        exit();
    }

    // Kiểm tra mật khẩu hiện tại
    if ($current_password !== $nguoi_dung_cu['pass']) {
        $_SESSION['errors']['current_password'] = 'Mật khẩu hiện tại không đúng.';
    }

    // Kiểm tra mật khẩu mới
    if (empty($new_password)) {
        $_SESSION['errors']['new_password'] = 'Vui lòng nhập mật khẩu mới.';
    } elseif (strlen($new_password) < 6) {
        $_SESSION['errors']['new_password'] = 'Mật khẩu mới phải có ít nhất 6 ký tự.';
    }

    // Kiểm tra xác nhận mật khẩu
    if ($new_password !== $confirm_password) {
        $_SESSION['errors']['confirm_password'] = 'Mật khẩu mới và xác nhận mật khẩu không khớp.';
    }

    // Nếu có lỗi, chuyển hướng về form với lỗi
    if (!empty($_SESSION['errors'])) {
        header('Location: ' . BASE_URL_ADMIN . '?act=form-password&id_nguoi_dung=' . $nguoi_dung_id);
        exit();
    }

    // Cập nhật mật khẩu mới vào cơ sở dữ liệu
    if ($this->modelNguoiDung->updatePassword($nguoi_dung_id, $new_password)) {
        $_SESSION['user_admin']['nguoi_dung_id'] = $nguoi_dung_id;
        $_SESSION['success'] = 'Đổi mật khẩu thành công.';
        header('Location: ' . BASE_URL_ADMIN . '?act=form-password&id_nguoi_dung=' . $nguoi_dung_id);
        exit();
    } else {
        $_SESSION['error'] = 'Cập nhật mật khẩu thất bại.';
        header('Location: ' . BASE_URL_ADMIN . '?act=form-password&id_nguoi_dung=' . $nguoi_dung_id);
        exit();
    }
}
}
public function formDangkiThanhCong(){
require_once './views/acc/dang_ki_thanh_cong.php';
}






   
}