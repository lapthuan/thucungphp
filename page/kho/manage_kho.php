<?php
if (isset($_GET['id'])) {
    $qry = pg_query($connPG, "SELECT * FROM kho WHERE makho = '{$_GET['id']}'");
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
        <h3 class="card-title"><?php echo (isset($_GET['id']) ? "Cập nhật " : "Tạo mới ") ?> kho</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage">

                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

                <div class="form-group">
                    <label for="makho">Mã kho</label>
                    <input type="text" name="makho" id="makho" class="form-control"
                        value="<?php echo isset($makho) ? $makho : ''; ?>" required <?php echo isset($_GET['id']) ? "readonly" : "" ?>>
                </div>

                <div class="form-group">
                    <label for="tenkho">Tên kho</label>
                    <input type="text" name="tenkho" id="tenkho" class="form-control"
                        value="<?php echo isset($tenkho) ? $tenkho : ''; ?>" required>
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
                    <label for="masanpham">Sản phẩm</label>
                    <select name="masanpham" id="masanpham" class="form-control" required>
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
                    <input type="text" name="soluong" id="soluong" class="form-control"
                        value="<?php echo isset($soluong) ? $soluong : ''; ?>" required>
                </div>

                <!-- Các trường khác nếu có -->

            </form>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="manage">Lưu</button>
        <a class="btn btn-flat btn-default" href="?page=kho">Hủy</a>
    </div>
</div>

<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=save_kho',
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