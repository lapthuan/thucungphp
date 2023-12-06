<?php
if (isset($_GET['id'])) {
    $qry = pg_query($connPG, "SELECT * FROM hoadon WHERE mahoadon = '{$_GET['id']}'");
    if ($qry) {
        $result = pg_fetch_assoc($qry);

        if ($result) {
            foreach ($result as $k => $v) {
                $$k = $v;
            }
        }
    }
}
?>

<div class="card card-outline">
    <div class="card-header">
        <h3 class="card-title"><?php echo (isset($_GET['id']) ? "Cập nhật " : "Tạo mới ") ?> hóa đơn</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage">

                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

                <div class="form-group">
                    <label for="mahoadon">Mã hóa đơn</label>
                    <input type="text" name="mahoadon" id="mahoadon" class="form-control"
                        value="<?php echo isset($mahoadon) ? $mahoadon : ''; ?>" required <?php echo isset($_GET['id']) ? "readonly" : "" ?>>
                </div>

                <div class="form-group">
                    <label for="machinhanh">Chi nhánh</label>
                    <select name="machinhanh" id="machinhanh" class="form-control" required>
                        <?php
$qry_chinhanh = pg_query($connPG, "SELECT * FROM chinhanh");
while ($row_chinhanh = pg_fetch_assoc($qry_chinhanh)):
?>
                            <option value="<?php echo $row_chinhanh['machinhanh']; ?>" <?php echo isset($machinhanh) && $machinhanh == $row_chinhanh['machinhanh'] ? 'selected' : ''; ?>>
                                <?php echo $row_chinhanh['tenchinhanh']; ?>
                            </option>
                        <?php endwhile;?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="manhanvien">Nhân viên</label>
                    <select name="manhanvien" id="manhanvien" class="form-control" required>
                        <?php
$qry_nhanvien = pg_query($connPG, "SELECT * FROM nhanvien");
while ($row_nhanvien = pg_fetch_assoc($qry_nhanvien)):
?>
                            <option value="<?php echo $row_nhanvien['manhanvien']; ?>" <?php echo isset($manhanvien) && $manhanvien == $row_nhanvien['manhanvien'] ? 'selected' : ''; ?>>
                                <?php echo $row_nhanvien['tennhanvien']; ?>
                            </option>
                        <?php endwhile;?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="makhachhang">Khách hàng</label>
                    <select name="makhachhang" id="makhachhang" class="form-control" required>
                        <?php
$qry_khachhang = pg_query($connPG, "SELECT * FROM khachhang");
while ($row_khachhang = pg_fetch_assoc($qry_khachhang)):
?>
                            <option value="<?php echo $row_khachhang['makhachhang']; ?>" <?php echo isset($makhachhang) && $makhachhang == $row_khachhang['makhachhang'] ? 'selected' : ''; ?>>
                                <?php echo $row_khachhang['tenkhachhang']; ?>
                            </option>
                        <?php endwhile;?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ngaylap">Ngày lập</label>
                    <input type="date" name="ngaylap" id="ngaylap" class="form-control"
                        value="<?php echo isset($ngaylap) ? $ngaylap : ''; ?>" required>
                </div>

                <!-- Các trường khác nếu có -->

            </form>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="manage">Lưu</button>
        <a class="btn btn-flat btn-default" href="?page=hoadon">Hủy</a>
    </div>
</div>

<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=save_hoadon',
		data: new FormData($(this)[0]),
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		type: 'POST',
		error: function(resp) {
			console.log('error', resp)

		},
		success: function(resp) {
			console.log('resp', resp)
			if(resp.msg && resp.status == "success"){
				alert_toast(resp.msg,"success")
			}
			if(resp.msg && resp.status == "failed"){
				alert_toast(resp.msg,"warning")
			}
		}
	})
})
</script>