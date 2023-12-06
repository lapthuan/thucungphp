<?php
if (isset($_GET['id'])) {
    $qry = pg_query($connPG, "SELECT * FROM phieunhap WHERE maphieunhap = '{$_GET['id']}'");
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
        <h3 class="card-title"><?php echo (isset($_GET['id']) ? "Cập nhật " : "Tạo mới ") ?> phiếu nhập</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage">

                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

                <div class="form-group">
                    <label for="maphieunhap">Mã phiếu nhập</label>
                    <input type="text" name="maphieunhap" id="maphieunhap" class="form-control"
                        value="<?php echo isset($maphieunhap) ? $maphieunhap : ''; ?>" required <?php echo isset($_GET['id']) ? "readonly" : "" ?>>
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
                    <label for="manhacungcap">Nhà cung cấp</label>
                    <select name="manhacungcap" id="manhacungcap" class="form-control" required>
                        <?php
$qry_nhacungcap = pg_query($connPG, "SELECT * FROM nhacungcap");
while ($row_nhacungcap = pg_fetch_assoc($qry_nhacungcap)):
?>
                            <option value="<?php echo $row_nhacungcap['manhacungcap']; ?>" <?php echo isset($manhacungcap) && $manhacungcap == $row_nhacungcap['manhacungcap'] ? 'selected' : ''; ?>>
                                <?php echo $row_nhacungcap['tennhacungcap']; ?>
                            </option>
                        <?php endwhile;?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ngaynhap">Ngày nhập</label>
                    <input type="date" name="ngaynhap" id="ngaynhap" class="form-control"
                        value="<?php echo isset($ngaynhap) ? $ngaynhap : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="tongtien">Tổng tiền</label>
                    <input type="text" name="tongtien" id="tongtien" class="form-control"
                        value="<?php echo isset($tongtien) ? $tongtien : ''; ?>" required>
                </div>

                <!-- Các trường khác nếu có -->

            </form>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="manage">Lưu</button>
        <a class="btn btn-flat btn-default" href="?page=phieunhap">Hủy</a>
    </div>
</div>
<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=save_phieunhap',
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