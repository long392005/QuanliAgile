<?php

class AdminSanPham {

    public $conn;

    public function __construct() {
        $this->conn = connectDB();
    }
    public function insertAlbumAnhSanPham($san_pham_id , $link_hinh_anh){
        try{
            $sql= 'INSERT INTO hinh_anh_san_phams (san_pham_id , link_hinh_anh) 
                        VALUES          (:san_pham_id ,:link_hinh_anh)' ;
            $stmt= $this->conn->prepare($sql);
            $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':link_hinh_anh' => $link_hinh_anh,
            ]);
            return true;
        }catch (Exception $e) {
            echo 'Lỗi' . $e->getMessage();

        }
    }
    public function getOnetSanPham($id) {
        try {
            $sql= 'SELECT san_phams.*, danh_mucs.ten_danh_muc 
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id 
            WHERE san_phams.id =:id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();  // Fetch a single record by ID
        } catch (Exception $e) {
            echo 'lỗi ' . $e->getMessage();
        }
    }
   
    public function getDetailSanpham($id) {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
                    FROM san_phams
                    INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                    WHERE san_phams.id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();  // Fetch a single product detail with category
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }
    public function UpdateSanPham($san_pham_id, $ma_san_pham, $ten_san_pham, $gia_nhap, $gia_san_pham, $so_luong, $luot_xem, $ngay_nhap, $danh_muc_id, $trang_thai, $mo_ta, $hinh_anh) {
        try {
            $sql = 'UPDATE san_phams SET 
                        ma_san_pham = :ma_san_pham,
                        ten_san_pham = :ten_san_pham,
                        gia_nhap = :gia_nhap,
                        gia_san_pham = :gia_san_pham,
                        so_luong = :so_luong,
                        luot_xem = :luot_xem,
                        ngay_nhap = :ngay_nhap,
                        danh_muc_id = :danh_muc_id,
                        trang_thai = :trang_thai,
                        mo_ta = :mo_ta,
                        hinh_anh = :hinh_anh
                    WHERE id = :san_pham_id';
    
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':san_pham_id' => $san_pham_id,
                ':ma_san_pham' => $ma_san_pham,
                ':ten_san_pham' => $ten_san_pham,
                ':gia_nhap' => $gia_nhap,
                ':gia_san_pham' => $gia_san_pham,
                ':so_luong' => $so_luong,
                ':luot_xem' => $luot_xem,
                ':ngay_nhap' => $ngay_nhap,
                ':danh_muc_id' => $danh_muc_id,
                ':trang_thai' => $trang_thai,
                ':mo_ta' => $mo_ta,
                ':hinh_anh' => $hinh_anh,
            ]);
    
            return true;
        } catch (PDOException $e) {
            echo 'Lỗi SQL: ' . $e->getMessage();
            return false;
        }
    }

}