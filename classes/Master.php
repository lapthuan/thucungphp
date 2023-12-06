<?php
require_once '../config.php';
header('Content-Type: application/json; charset=utf-8');
class Master extends DBConnectionPG
{

    public function save_sanpham()
    {
        extract($_POST);
        $giasanpham = floatval($giasanpham);
        if (empty($id)) {
            $check = checkExit($this->connPG, "sanpham", "masanpham", $masanpham);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã sản phẩm đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO sanpham(masanpham, machinhanh, tensanpham, giasanpham, madanhmuc, mathuonghieu) values ('$masanpham', '$machinhanh', '$tensanpham', '$giasanpham', '$madanhmuc', '$mathuonghieu')";
            $result = pg_query($this->connPG, $query);

            if ($result) {

                $query2 = "INSERT INTO sanpham (masanpham, machinhanh, tensanpham, giasanpham, madanhmuc, mathuonghieu) VALUES (?, ?, ?, ?, ?, ?)";
                $params = array($masanpham, $machinhanh, $tensanpham, $giasanpham, $madanhmuc, $mathuonghieu);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm sản phẩm và đông bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);

                }

            }
        } else {
            $query = "UPDATE sanpham SET
            machinhanh = '$machinhanh',
            tensanpham = '$tensanpham',
            giasanpham = '$giasanpham',
            madanhmuc = '$madanhmuc',
            mathuonghieu = '$mathuonghieu'
                    WHERE masanpham = '$id'";

            $result = pg_query($this->connPG, $query);

            if ($result) {
                // Sử dụng sqlsrv_query để cập nhật dữ liệu
                $query2 = "UPDATE sanpham SET machinhanh = (?), tensanpham = (?), giasanpham = (?), madanhmuc = (?), mathuonghieu = (?) WHERE masanpham = (?)";
                $params2 = array($machinhanh, $tensanpham, $giasanpham, $madanhmuc, $mathuonghieu, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật sản phẩm thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {

                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }

            }

        }

    }
    public function save_chinhanh()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "chinhanh", "machinhanh", $machinhanh);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã chi nhánh đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO chinhanh(machinhanh, tenchinhanh, matinh) values ('$machinhanh', '$tenchinhanh', '$matinh')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO chinhanh (machinhanh, tenchinhanh, matinh) VALUES (?, ?, ?)";
                $params = array($machinhanh, $tenchinhanh, $matinh);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm chi nhánh và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE chinhanh SET
                tenchinhanh = '$tenchinhanh',
                matinh = '$matinh'
                WHERE machinhanh = '$id'";

            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE chinhanh SET tenchinhanh = (?), matinh = (?) WHERE machinhanh = (?)";
                $params2 = array($tenchinhanh, $matinh, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật chi nhánh thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_danhmuc()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "danhmuc", "madanhmuc", $madanhmuc);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã danh mục đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO danhmuc(madanhmuc, tendanhmuc) values ('$madanhmuc', '$tendanhmuc')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO danhmuc (madanhmuc, tendanhmuc) VALUES (?, ?)";
                $params = array($madanhmuc, $tendanhmuc);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm danh mục và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE danhmuc SET tendanhmuc = '$tendanhmuc' WHERE madanhmuc = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE danhmuc SET tendanhmuc = (?) WHERE madanhmuc = (?)";
                $params2 = array($tendanhmuc, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật danh mục thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_thuonghieu()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "thuonghieu", "mathuonghieu", $mathuonghieu);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã thương hiệu đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO thuonghieu(mathuonghieu, tenthuonghieu) values ('$mathuonghieu', '$tenthuonghieu')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO thuonghieu (mathuonghieu, tenthuonghieu) VALUES (?, ?)";
                $params = array($mathuonghieu, $tenthuonghieu);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm thương hiệu và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE thuonghieu SET tenthuonghieu = '$tenthuonghieu' WHERE mathuonghieu = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE thuonghieu SET tenthuonghieu = (?) WHERE mathuonghieu = (?)";
                $params2 = array($tenthuonghieu, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật thương hiệu thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_nhacungcap()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "nhacungcap", "manhacungcap", $manhacungcap);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã nhà cung cấp đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO nhacungcap(manhacungcap, tennhacungcap, diachi) values ('$manhacungcap', '$tennhacungcap', '$diachi')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO nhacungcap (manhacungcap, tennhacungcap, diachi) VALUES (?, ?, ?)";
                $params = array($manhacungcap, $tennhacungcap, $diachi);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm nhà cung cấp và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE nhacungcap SET tennhacungcap = '$tennhacungcap', diachi = '$diachi' WHERE manhacungcap = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE nhacungcap SET tennhacungcap = (?), diachi = (?) WHERE manhacungcap = (?)";
                $params2 = array($tennhacungcap, $diachi, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật nhà cung cấp thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_loaikhachhang()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "loaikhachhang", "maloaikhachhang", $maloaikhachhang);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã loại khách hàng đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO loaikhachhang(maloaikhachhang, tenloaikhachhang) values ('$maloaikhachhang', '$tenloaikhachhang')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO loaikhachhang (maloaikhachhang, tenloaikhachhang) VALUES (?, ?)";
                $params = array($maloaikhachhang, $tenloaikhachhang);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm loại khách hàng và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE loaikhachhang SET tenloaikhachhang = '$tenloaikhachhang' WHERE maloaikhachhang = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE loaikhachhang SET tenloaikhachhang = (?) WHERE maloaikhachhang = (?)";
                $params2 = array($tenloaikhachhang, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật loại khách hàng thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_khachhang()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "khachhang", "makhachhang", $makhachhang);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã khách hàng đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO khachhang(makhachhang, tenkhachhang, diachi, maloaikhachhang) values ('$makhachhang', '$tenkhachhang', '$diachi', '$maloaikhachhang')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO khachhang (makhachhang, tenkhachhang, diachi, maloaikhachhang) VALUES (?, ?, ?, ?)";
                $params = array($makhachhang, $tenkhachhang, $diachi, $maloaikhachhang);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm khách hàng và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE khachhang SET tenkhachhang = '$tenkhachhang', diachi = '$diachi', maloaikhachhang = '$maloaikhachhang' WHERE makhachhang = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE khachhang SET tenkhachhang = (?), diachi = (?), maloaikhachhang = (?) WHERE makhachhang = (?)";
                $params2 = array($tenkhachhang, $diachi, $maloaikhachhang, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật khách hàng thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_kho()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "kho", "makho", $makho);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã kho đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO kho(makho, tenkho, machinhanh, masanpham, soluong) values ('$makho', '$tenkho', '$machinhanh', '$masanpham', '$soluong')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO kho (makho, tenkho, machinhanh, masanpham, soluong) VALUES (?, ?, ?, ?, ?)";
                $params = array($makho, $tenkho, $machinhanh, $masanpham, $soluong);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm kho và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE kho SET tenkho = '$tenkho', machinhanh = '$machinhanh', masanpham = '$masanpham', soluong = '$soluong' WHERE makho = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE kho SET tenkho = (?), machinhanh = (?), masanpham = (?), soluong = (?) WHERE makho = (?)";
                $params2 = array($tenkho, $machinhanh, $masanpham, $soluong, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật kho thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_taikhoan()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "taikhoan", "tentk", $tentk);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Tên tài khoản đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO taikhoan(tentk, manhanvien, matkhau, quyen) values ('$tentk', '$manhanvien', '$matkhau', '$quyen')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO taikhoan (tentk, manhanvien, matkhau, quyen) VALUES (?, ?, ?, ?)";
                $params = array($tentk, $manhanvien, $matkhau, $quyen);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm tài khoản và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE taikhoan SET  manhanvien = '$manhanvien', matkhau = '$matkhau', quyen = '$quyen' WHERE tentk = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE taikhoan SET manhanvien = (?), matkhau = (?), quyen = (?) WHERE tentk = (?)";
                $params2 = array($manhanvien, $matkhau, $quyen, $tentk);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật tài khoản thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_nhanvien()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "nhanvien", "manhanvien", $manhanvien);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã nhân viên đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO nhanvien(manhanvien, machinhanh, tennhanvien, diachi) values ('$manhanvien', '$machinhanh', '$tennhanvien', '$diachi')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO nhanvien (manhanvien, machinhanh, tennhanvien, diachi) VALUES (?, ?, ?, ?)";
                $params = array($manhanvien, $machinhanh, $tennhanvien, $diachi);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm nhân viên và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE nhanvien SET machinhanh = '$machinhanh', tennhanvien = '$tennhanvien', diachi = '$diachi' WHERE manhanvien = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE nhanvien SET machinhanh = (?), tennhanvien = (?), diachi = (?) WHERE manhanvien = (?)";
                $params2 = array($machinhanh, $tennhanvien, $diachi, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật nhân viên thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_phieunhap()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "phieunhap", "maphieunhap", $maphieunhap);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã phiếu nhập đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO phieunhap(maphieunhap, manhacungcap, machinhanh, ngaynhap, tongtien) values ('$maphieunhap', '$manhacungcap', '$machinhanh', '$ngaynhap', '$tongtien')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO phieunhap (maphieunhap, manhacungcap, machinhanh, ngaynhap, tongtien) VALUES (?, ?, ?, ?, ?)";
                $params = array($maphieunhap, $manhacungcap, $machinhanh, $ngaynhap, $tongtien);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm phiếu nhập và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE phieunhap SET manhacungcap = '$manhacungcap', machinhanh = '$machinhanh', ngaynhap = '$ngaynhap', tongtien = '$tongtien' WHERE maphieunhap = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE phieunhap SET manhacungcap = (?), machinhanh = (?), ngaynhap = (?), tongtien = (?) WHERE maphieunhap = (?)";
                $params2 = array($manhacungcap, $machinhanh, $ngaynhap, $tongtien, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật phiếu nhập thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }
    public function save_hoadon()
    {
        extract($_POST);
        if (empty($id)) {
            $check = checkExit($this->connPG, "hoadon", "mahoadon", $mahoadon);

            if ($check == 1) {
                $resp['status'] = 'failed';
                $resp['msg'] = 'Mã hóa đơn đã tồn tại';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

            $query = "INSERT INTO hoadon(mahoadon, makhachhang, manhanvien, machinhanh, ngaylap) values ('$mahoadon', '$makhachhang', '$manhanvien', '$machinhanh', '$ngaylap')";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "INSERT INTO hoadon (mahoadon, makhachhang, manhanvien, machinhanh, ngaylap) VALUES (?, ?, ?, ?, ?)";
                $params = array($mahoadon, $makhachhang, $manhanvien, $machinhanh, $ngaylap);
                $result2 = sqlsrv_query($this->conn, $query2, $params);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Thêm hóa đơn và đồng bộ thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                }
            }
        } else {
            $query = "UPDATE hoadon SET makhachhang = '$makhachhang', manhanvien = '$manhanvien', machinhanh = '$machinhanh', ngaylap = '$ngaylap' WHERE mahoadon = '$id'";
            $result = pg_query($this->connPG, $query);

            if ($result) {
                $query2 = "UPDATE hoadon SET makhachhang = (?), manhanvien = (?), machinhanh = (?), ngaylap = (?) WHERE mahoadon = (?)";
                $params2 = array($makhachhang, $manhanvien, $machinhanh, $ngaylap, $id);

                $result2 = sqlsrv_query($this->conn, $query2, $params2);

                if ($result2) {
                    $resp['status'] = 'success';
                    $resp['msg'] = 'Cập nhật hóa đơn thành công';
                    return json_encode($resp, JSON_UNESCAPED_UNICODE);
                } else {
                    return json_encode(sqlsrv_errors(), JSON_UNESCAPED_UNICODE);
                }
            }
        }
    }

    public function delete_sanpham()
    {
        extract($_POST);
        $query = "DELETE FROM sanpham WHERE masanpham = '$masanpham'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM sanpham WHERE masanpham = (?)";
            $params = array($masanpham);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa sản phẩm thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }

        }
    }
    public function delete_chinhanh()
    {
        extract($_POST);
        $query = "DELETE FROM chinhanh WHERE machinhanh = '$machinhanh'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM chinhanh WHERE machinhanh = (?)";
            $params = array($machinhanh);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa chi nhánh thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_danhmuc()
    {
        extract($_POST);
        $query = "DELETE FROM danhmuc WHERE madanhmuc = '$madanhmuc'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM danhmuc WHERE madanhmuc = (?)";
            $params = array($madanhmuc);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa danh mục thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_thuonghieu()
    {
        extract($_POST);
        $query = "DELETE FROM thuonghieu WHERE mathuonghieu = '$mathuonghieu'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM thuonghieu WHERE mathuonghieu = (?)";
            $params = array($mathuonghieu);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa thương hiệu thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_nhacungcap()
    {
        extract($_POST);
        $query = "DELETE FROM nhacungcap WHERE manhacungcap = '$manhacungcap'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM nhacungcap WHERE manhacungcap = (?)";
            $params = array($manhacungcap);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa nhà cung cấp thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_loaikhachhang()
    {
        extract($_POST);
        $query = "DELETE FROM loaikhachhang WHERE maloaikhachhang = '$maloaikhachhang'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM loaikhachhang WHERE maloaikhachhang = (?)";
            $params = array($maloaikhachhang);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa loại khách hàng thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_khachhang()
    {
        extract($_POST);
        $query = "DELETE FROM khachhang WHERE makhachhang = '$makhachhang'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM khachhang WHERE makhachhang = (?)";
            $params = array($makhachhang);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa khách hàng thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_kho()
    {
        extract($_POST);
        $query = "DELETE FROM kho WHERE makho = '$makho'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM kho WHERE makho = (?)";
            $params = array($makho);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa kho thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_taikhoan()
    {
        extract($_POST);
        $query = "DELETE FROM taikhoan WHERE tentk = '$tentk'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM taikhoan WHERE tentk = (?)";
            $params = array($tentk);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa tài khoản thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_nhanvien()
    {
        extract($_POST);
        $query = "DELETE FROM nhanvien WHERE manhanvien = '$manhanvien'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM nhanvien WHERE manhanvien = (?)";
            $params = array($manhanvien);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa nhân viên thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_phieunhap()
    {
        extract($_POST);
        $query = "DELETE FROM phieunhap WHERE maphieunhap = '$maphieunhap'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM phieunhap WHERE maphieunhap = (?)";
            $params = array($maphieunhap);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa phiếu nhập thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function delete_hoadon()
    {
        extract($_POST);
        $query = "DELETE FROM hoadon WHERE mahoadon = '$mahoadon'";
        $result = pg_query($this->connPG, $query);

        // Kiểm tra kết quả
        if ($result) {
            $query2 = "DELETE FROM hoadon WHERE mahoadon = (?)";
            $params = array($mahoadon);
            $result2 = sqlsrv_query($this->conn, $query2, $params);

            // Kiểm tra kết quả
            if ($result2) {
                $resp['status'] = 'success';
                $resp['msg'] = 'Xóa hóa đơn thành công';
                return json_encode($resp, JSON_UNESCAPED_UNICODE);
            }
        }
    }

}

function checkExit($connect, $table, $column, $id)
{
    $query = "SELECT COUNT(*) as count FROM $table WHERE  $column = '$id'";

    $result = pg_query($connect, $query);
    $row = pg_fetch_assoc($result);
    $count = $row['count'];
    return $count;

}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
    case 'save_sanpham':
        echo $Master->save_sanpham();
        break;
    case 'save_chinhanh':
        echo $Master->save_chinhanh();
        break;
    case 'save_danhmuc':
        echo $Master->save_danhmuc();
        break;
    case 'save_thuonghieu':
        echo $Master->save_thuonghieu();
        break;
    case 'save_nhacungcap':
        echo $Master->save_nhacungcap();
        break;
    case 'save_loaikhachhang':
        echo $Master->save_loaikhachhang();
        break;
    case 'save_khachhang':
        echo $Master->save_khachhang();
        break;
    case 'save_kho':
        echo $Master->save_kho();
        break;
    case 'save_taikhoan':
        echo $Master->save_taikhoan();
        break;
    case 'save_nhanvien':
        echo $Master->save_nhanvien();
        break;
    case 'save_phieunhap':
        echo $Master->save_phieunhap();
        break;
    case 'save_hoadon':
        echo $Master->save_hoadon();
        break;

    case 'delete_sanpham':
        echo $Master->delete_sanpham();
        break;
    case 'delete_chinhanh':
        echo $Master->delete_chinhanh();
        break;
    case 'delete_danhmuc':
        echo $Master->delete_danhmuc();
        break;
    case 'delete_thuonghieu':
        echo $Master->delete_thuonghieu();
        break;
    case 'delete_nhacungcap':
        echo $Master->delete_nhacungcap();
        break;
    case 'delete_loaikhachhang':
        echo $Master->delete_loaikhachhang();
        break;
    case 'delete_khachhang':
        echo $Master->delete_khachhang();
        break;
    case 'delete_kho':
        echo $Master->delete_kho();
        break;
    case 'delete_taikhoan':
        echo $Master->delete_taikhoan();
        break;
    case 'delete_nhanvien':
        echo $Master->delete_nhanvien();
        break;
    case 'delete_phieunhap':
        echo $Master->delete_phieunhap();
        break;
    case 'delete_hoadon':
        echo $Master->delete_hoadon();
        break;
    default:
        break;
}
