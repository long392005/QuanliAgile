<?php
class NguoiDung{
    public $conn;
    public function __construct()
    {
        $this->conn=connectDB();
    }
    public function getAll(){
        try {
            $sql='SELECT * FROM `nguoi_dungs`';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo 'Lỗi:'.$e->getMessage();
        }
    }

    //thêm vào csdl
    public function postData($ten, $email, $dia_chi,$phone,$pass,$ngay_tao,$gioi_tinh,$avartar,$vai_tro, $trang_thai){
        try {
           
            $sql='INSERT INTO nguoi_dungs (ten, email, dia_chi,phone,pass,ngay_tao,gioi_tinh,avartar,vai_tro, trang_thai)
            VALUES (:ten, :email, :dia_chi, :phone, :pass, :ngay_tao, :gioi_tinh, :avartar, :vai_tro, :trang_thai)';
            $stmt = $this->conn->prepare($sql);
           
            $stmt->bindParam(':ten', $ten);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':dia_chi', $dia_chi);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':pass', $pass);
            $stmt->bindParam(':ngay_tao', $ngay_tao);
            $stmt->bindParam(':gioi_tinh', $gioi_tinh);
            $stmt->bindParam(':avartar', $avartar);
            $stmt->bindParam(':vai_tro', $vai_tro);
            $stmt->bindParam(':trang_thai', $trang_thai);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Lỗi:'.$e->getMessage();
        }
    }
    public function deleteData($id){
        try {
            $sql='DELETE FROM `nguoi_dungs` WHERE id= :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Lỗi:'.$e->getMessage();
        } 
    }
    
    public function getDetailData($id){
        try {
            $sql = 'SELECT * FROM nguoi_dungs where id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt ->execute([':id'=>$id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo 'lỗi ' .$e->getMessage();
        }
    }
   
   

    public function updateData($nguoi_dung_id,$ten, $email, $dia_chi,$phone,$pass,$ngay_tao,$gioi_tinh,$avartar,$vai_tro, $trang_thai){
        try {
            $sql = 'UPDATE nguoi_dungs SET
             ten=:ten, 
             email = :email, 
             dia_chi=:dia_chi, 
             phone= :phone, 
             pass=:pass, 
             ngay_tao= :ngay_tao, 
             gioi_tinh=:gioi_tinh,
             avartar= :avartar, 
             vai_tro= :vai_tro, 
             trang_thai= :trang_thai 
             WHERE id= :nguoi_dung_id';

            $stmt = $this->conn->prepare($sql);
            
            $stmt ->execute([
                ':nguoi_dung_id'=> $nguoi_dung_id,
                ':ten'=> $ten,
                ':email'=> $email,
                ':dia_chi'=> $dia_chi,
                ':phone'=> $phone,
                ':pass'=> $pass,
                ':ngay_tao'=> $ngay_tao,
                ':gioi_tinh'=> $gioi_tinh,
                ':avartar'=> $avartar,
                ':vai_tro'=> $vai_tro,
                ':trang_thai'=> $trang_thai,

            ]);
            return true;

        } catch (PDOException $e) {
            // In ra lỗi nếu có trong câu lệnh SQL
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }
    
    public function checkLogin($email, $pass) {
        try {
            $sql = 'SELECT * FROM nguoi_dungs WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
    
            $user = $stmt->fetch();
    
            if ($user) {
                
                if ($pass === $user['pass']) {
                    // Kiểm tra trạng thái tài khoản
                    if ($user['trang_thai'] == 1) {
                        return $user; // Trả về thông tin user
                    } else {
                        return "Tài khoản của bạn đã bị cấm.";
                    }
                } else {
                    return "Mật khẩu không chính xác.";
                }
            } else {
                return "Email không tồn tại.";
            }
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }

    public function isEmailExists($email) {
        $sql = 'SELECT id FROM nguoi_dungs WHERE email = :email LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch() ? true : false;
        
    }
    public function getUserByEmail($email) {
        try {
            $sql = 'SELECT * FROM nguoi_dungs WHERE email = :email LIMIT 1';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return null;
        }
    }
    public function isEmailUpdate($email, $nguoi_dung_id) {
        $sql = 'SELECT id FROM nguoi_dungs WHERE email = :email AND id != :nguoi_dung_id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':nguoi_dung_id', $nguoi_dung_id);
        $stmt->execute();
        return $stmt->fetch() ? true : false;
    }
    

  
    
    


    public function registerUser($ten, $email, $dia_chi, $phone, $pass, $ngay_tao, $gioi_tinh, $avartar, $vai_tro, $trang_thai) {
        try {
            $sql = 'INSERT INTO nguoi_dungs (ten, email, dia_chi, phone, pass, ngay_tao, gioi_tinh, avartar, vai_tro, trang_thai)
                    VALUES (:ten, :email, :dia_chi, :phone, :pass, :ngay_tao, :gioi_tinh, :avartar, :vai_tro, :trang_thai)';
            
            $stmt = $this->conn->prepare($sql);
    
            $stmt->bindParam(':ten', $ten);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':dia_chi', $dia_chi);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':pass', $pass);
            $stmt->bindParam(':ngay_tao', $ngay_tao);
            $stmt->bindParam(':gioi_tinh', $gioi_tinh);
            $stmt->bindParam(':avartar', $avartar);
            $stmt->bindParam(':vai_tro', $vai_tro);
            $stmt->bindParam(':trang_thai', $trang_thai);
//             var_dump($ten, $email, $dia_chi, $phone, $pass, $ngay_tao, $gioi_tinh, $avartar, $vai_tro, $trang_thai);
// exit(); // Dừng lại để kiểm tra giá trị

    
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    public function updatePassword($nguoi_dung_id, $new_password)
{
    // Cập nhật mật khẩu mới vào cơ sở dữ liệu (không mã hóa)
    $sql = "UPDATE nguoi_dungs SET pass = :pass WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':pass', $new_password, PDO::PARAM_STR);  // Lưu mật khẩu thuần túy
    $stmt->bindParam(':id', $nguoi_dung_id, PDO::PARAM_INT);

    // Thực thi câu lệnh SQL
    if ($stmt->execute()) {
        return true;
    }
    
    return false;
}
public function checkCurrentPassword($nguoi_dung_id, $current_password)
{
    // Lấy mật khẩu hiện tại từ cơ sở dữ liệu
    $sql = "SELECT pass FROM nguoi_dungs WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $nguoi_dung_id, PDO::PARAM_INT);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Kiểm tra mật khẩu hiện tại (so sánh trực tiếp mật khẩu)
        if ($current_password == $user['pass']) {
            return true;
        }
    }
    
    return false;
}


        }