<div>
    <div class="card-header">
        <h3 class="card-title">Danh sách nhân viên</h3>
        <div class="card-tools">
            <a href="?page=nhanvien/manage_nhanvien" class="btn btn-flat btn-success rounded"><span
                        class="fas fa-plus"></span> Tạo mới</a>
        </div>
    </div>
    <hr>
    <?php
// Truy vấn SQL
$sql = "SELECT manhanvien, cn.tenchinhanh, tennhanvien, diachi
            FROM public.nhanvien nv
            JOIN chinhanh cn ON cn.machinhanh = nv.machinhanh;";

// Thực hiện truy vấn
$result = pg_query($connPG, $sql);

// Kiểm tra và hiển thị kết quả trong bảng HTML
if ($result) {
    ?>
    <table id="myTable" class="table table-bordered border-primary">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Mã nhân viên</th>
            <th scope="col">Chi nhánh</th>
            <th scope="col">Tên nhân viên</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Chức năng</th>
        </tr>
        </thead>
        <tbody>
        <?php
while ($row = pg_fetch_assoc($result)) {
        ?>
        <tr>
            <th scope="row"><?=$row['manhanvien']?></th>
            <td><?=$row['tenchinhanh']?></td>
            <td><?=$row['tennhanvien']?></td>
            <td><?=$row['diachi']?></td>
            <td>
                <div class="d-flex">
                    <a class="btn btn-success"
                        href="?page=nhanvien/manage_nhanvien&id=<?php echo $row['manhanvien'] ?>">Sửa</a>
                    <a class="btn btn-danger delete_data" href="javascript:void(0)"
                        data-id="<?php echo $row['manhanvien'] ?>">Xóa</a>
                </div>
            </td>
        </tr>
        <?php
}
    ?>
        </tbody>
    </table>
    <?php
} else {
    die("Lỗi truy vấn: " . pg_last_error($conn));
}
// Đóng kết nối database
pg_close($connPG);
?>
</div>
<script>
		$(document).ready(function(){
		$('.delete_data').click(function(){
			var dataId = $(this).attr('data-id');
			_conf("Bạn có chắc chắn xóa này vĩnh viễn?","delete_nhanvien",[$(this).attr('data-id')])

		})
		$('#myTable').DataTable({
		"paging": true,
		"language": {
        "url": "<?php echo base_url ?>assets/Vietnamese.json" // hoặc đường dẫn tới file Vietnamese.json trên máy của bạn
    }
		});
	})
	function delete_nhanvien($id){

		$.ajax({
			url: _base_url_ + 'classes/Master.php?f=delete_nhanvien',
			method:"POST",
			data:{manhanvien: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("Dữ liệu là khóa ngoại không thể xóa.",'error');

			},
			success:function(resp){
				console.log('resp', resp)
			if(resp.msg && resp.status == "success"){
				alert_toast(resp.msg,"success")
				location.reload();
			}
			if(resp.msg && resp.status == "failed"){
				alert_toast(resp.msg,"warning")
			}

			}
		})
	}
</script>