<?php
if (isset($_GET['id'])) {
    $qry = pg_query($connPG, "SELECT * FROM danhmuc WHERE madanhmuc = '{$_GET['id']}'");
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
        <h3 class="card-title"><?php echo (isset($_GET['id']) ? "Cập nhật " : "Tạo mới ") ?> danh mục</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div id="msg"></div>
            <form action="" id="manage">

                <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">

                <div class="form-group">
                    <label for="madanhmuc">Mã danh mục</label>
                    <input type="text" name="madanhmuc" id="madanhmuc" class="form-control"
                        value="<?php echo isset($madanhmuc) ? $madanhmuc : ''; ?>" required <?php echo isset($_GET['id']) ? "readonly" : "" ?>>
                </div>

                <div class="form-group">
                    <label for="tendanhmuc">Tên danh mục</label>
                    <input type="text" name="tendanhmuc" id="tendanhmuc" class="form-control"
                        value="<?php echo isset($tendanhmuc) ? $tendanhmuc : ''; ?>" required>
                </div>


            </form>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-flat btn-primary" form="manage">Lưu</button>
        <a class="btn btn-flat btn-default" href="?page=danhmuc">Hủy</a>
    </div>
</div>

<script>
	$('#manage').submit(function(e) {
	e.preventDefault();

	$.ajax({
		url: _base_url_ + 'classes/master.php?f=save_danhmuc',
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