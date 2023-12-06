<?php
if (isset($_GET['id'])) {
    $qry = pg_query($connPG, "SELECT * FROM sanpham WHERE masanpham = '{$_GET['id']}'");
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
		<h3 class="card-title"><?php echo isset($_GET['id']) ? "Cập Nhật " : "Tạo Mới " ?> Nhân viên</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage">

				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">


				<div class="form-group">
					<label for="masanpham">Mã sản phẩm</label>
					<input type="text" name="masanpham" id="masanpham" class="form-control"
						value="<?php echo isset($masanpham) ? $masanpham : ''; ?>"  required <?php echo isset($_GET['id']) ? "readonly" : "" ?>>
				</div>

				<div class="form-group">
					<label for="machinhanh" class="control-label">Chi nhánh</label>
					<select name="machinhanh" id="machinhanh" class="form-control">
						<?php
$qry = pg_query($connPG, "SELECT * FROM chinhanh");
while ($row = pg_fetch_assoc($qry)):
?>
						<option
							<?php echo isset($machinhanh) && $machinhanh == strtoupper($row['machinhanh']) ? 'selected' : '' ?>>
							<?php echo strtoupper($row['machinhanh']) ?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div class="form-group">
					<label for="madanhmuc" class="control-label">Danh mục</label>
					<select name="madanhmuc" id="madanhmuc" class="form-control">
						<?php
$qry = pg_query($connPG, "SELECT * FROM danhmuc");
while ($row = pg_fetch_assoc($qry)):
?>
						<option
							<?php echo isset($madanhmuc) && $madanhmuc == strtoupper($row['madanhmuc']) ? 'selected' : '' ?>>
							<?php echo strtoupper($row['madanhmuc']) ?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div class="form-group">
					<label for="mathuonghieu" class="control-label">Thương hiệu</label>
					<select name="mathuonghieu" id="mathuonghieu" class="form-control">
						<?php
$qry = pg_query($connPG, "SELECT * FROM thuonghieu");
while ($row = pg_fetch_assoc($qry)):
?>
						<option
							<?php echo isset($mathuonghieu) && $mathuonghieu == strtoupper($row['mathuonghieu']) ? 'selected' : '' ?>>
							<?php echo strtoupper($row['mathuonghieu']) ?></option>
						<?php endwhile;?>
					</select>
				</div>
				<div class="form-group">
					<label for="tensanpham">Tên sản phẩm</label>
					<input type="text" name="tensanpham" id="tensanpham" class="form-control"
						value="<?php echo isset($tensanpham) ? $tensanpham : ''; ?>" required>
				</div>

				<div class="form-group">
					<label for="giasanpham">Giá</label>
					<input type="number" name="giasanpham" id="giasanpham" class="form-control"
						value="<?php echo isset($giasanpham) ? $giasanpham : ''; ?>" required>
				</div>

			</form>
		</div>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="manage">Lưu</button>
		<a class="btn btn-flat btn-default" href="?page=sanpham">Hủy</a>
	</div>
</div>
<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=save_sanpham',
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