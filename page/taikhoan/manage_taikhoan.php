<?php
if (isset($_GET['id'])) {
    $qry = pg_query($connPG, "SELECT * FROM taikhoan WHERE tentk = '{$_GET['id']}'");
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
        <h3 class="card-title"><?php echo (isset($_GET['id']) ? "Cập nhật " : "Tạo mới ") ?> tài khoản</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage">

                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

                <div class="form-group">
                    <label for="tentk">Tên tài khoản</label>
                    <input type="text" name="tentk" id="tentk" class="form-control"
                        value="<?php echo isset($tentk) ? $tentk : ''; ?>" required <?php echo isset($_GET['id']) ? "readonly" : "" ?>>
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
                    <label for="matkhau">Mật khẩu</label>
                    <input type="password" name="matkhau" id="matkhau" class="form-control"
                        value="<?php echo isset($matkhau) ? $matkhau : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="quyen">Quyền</label>

						<select name="quyen" id="quyen" class="form-control" required>

                            <option value="1" <?php echo isset($quyen) && $quyen == "1" ? 'selected' : ''; ?>>
                            Admin
                            </option>
							<option value="0" <?php echo isset($quyen) && $quyen == "0" ? 'selected' : ''; ?>>
                            Nhân viên
                            </option>

                    </select>
                </div>

                <!-- Các trường khác nếu có -->

            </form>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="manage">Lưu</button>
        <a class="btn btn-flat btn-default" href="?page=taikhoan">Hủy</a>
    </div>
</div>

<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=save_taikhoan',
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