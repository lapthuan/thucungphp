<?php
if (isset($_GET['sp'])) {
    $qry = pg_query($connPG, "SELECT * FROM chitietphieunhap WHERE maphieunhap = '{$_GET['id']}' and masanpham = '{$_GET['sp']}'");
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
        <h3 class="card-title"><?php echo (isset($_GET['sp']) ? "Cập nhật " : "Tạo mới ") ?> chi tiết phiếu nhập</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage">

                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                <input type="hidden" name="sp" value="<?php echo isset($_GET['sp']) ? $_GET['sp'] : '' ?>">

                <div class="form-group">
                    <label for="maphieunhap">Mã phiếu nhập</label>
                    <input type="text" name="maphieunhap" id="maphieunhap" class="form-control"
                        value="<?php echo isset($_GET['id']) ? $_GET['id'] : ''; ?>" required <?php echo isset($_GET['id']) ? "readonly" : "" ?>>
                </div>

                <div class="form-group">
                    <label for="masanpham">Sản phẩm</label>
                    <select name="masanpham" id="masanpham" class="form-control"<?php echo isset($_GET['sp']) ? "readonly" : "" ?> required>
                        <?php
$qry_sanpham = pg_query($connPG, "SELECT * FROM sanpham");
while ($row_sanpham = pg_fetch_assoc($qry_sanpham)):
?>
                            <option value="<?php echo $row_sanpham['masanpham']; ?>" <?php echo isset($masanpham) && $masanpham == $row_sanpham['masanpham'] ? 'selected' : ''; ?>>
                                <?php echo $row_sanpham['tensanpham']; ?>
                            </option>
                        <?php endwhile;?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="soluong">Số lượng</label>
                    <input type="number" name="soluong" id="soluong" class="form-control"
                        value="<?php echo isset($soluong) ? $soluong : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="dongia">Đơn giá</label>
                    <input type="number" name="dongia" id="dongia" class="form-control"
                        value="<?php echo isset($dongia) ? $dongia : ''; ?>" required>
                </div>

                <!-- Các trường khác nếu có -->

            </form>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="manage">Lưu</button>
        <a class="btn btn-flat btn-default" href="?page=chitietphieunhap&&id=<?php echo $_GET['id'] ?>">Hủy</a>
    </div>
</div>
<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=save_chitietphieunhap',
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