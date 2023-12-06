<?php
if (isset($_GET['id'])) {
    $qry = pg_query($connPG, "SELECT * FROM khachhang WHERE makhachhang = '{$_GET['id']}'");
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
        <h3 class="card-title"><?php echo (isset($_GET['id']) ? "Cập nhật " : "Tạo mới ") ?> khách hàng</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage">

                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

                <div class="form-group">
                    <label for="makhachhang">Mã khách hàng</label>
                    <input type="text" name="makhachhang" id="makhachhang" class="form-control"
                        value="<?php echo isset($makhachhang) ? $makhachhang : ''; ?>" required <?php echo isset($_GET['id']) ? "readonly" : "" ?>>
                </div>

                <div class="form-group">
                    <label for="tenkhachhang">Tên khách hàng</label>
                    <input type="text" name="tenkhachhang" id="tenkhachhang" class="form-control"
                        value="<?php echo isset($tenkhachhang) ? $tenkhachhang : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="diachi">Địa chỉ</label>
                    <input type="text" name="diachi" id="diachi" class="form-control"
                        value="<?php echo isset($diachi) ? $diachi : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="maloaikhachhang">Loại khách hàng</label>
                    <select name="maloaikhachhang" id="maloaikhachhang" class="form-control" required>
                        <?php
$qry_loaikhachhang = pg_query($connPG, "SELECT * FROM loaikhachhang");
while ($row_loaikhachhang = pg_fetch_assoc($qry_loaikhachhang)):
?>
                            <option value="<?php echo $row_loaikhachhang['maloaikhachhang']; ?>" <?php echo isset($maloaikhachhang) && $maloaikhachhang == $row_loaikhachhang['maloaikhachhang'] ? 'selected' : ''; ?>>
                                <?php echo $row_loaikhachhang['tenloaikhachhang']; ?>
                            </option>
                        <?php endwhile;?>
                    </select>
                </div>

                <!-- Các trường khác nếu có -->

            </form>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="manage">Lưu</button>
        <a class="btn btn-flat btn-default" href="?page=khachhang">Hủy</a>
    </div>
</div>
<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=save_khachhang',
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