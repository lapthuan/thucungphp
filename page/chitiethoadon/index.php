<div>
    <div class="card-header">
        <h3 class="card-title">Chi tiết hóa đơn</h3>
        <div class="card-tools">
            <a href="?page=chitiethoadon/manage_chitiethoadon" class="btn btn-flat btn-success rounded"><span
                        class="fas fa-plus"></span> Tạo mới</a>
						<a href="?page=hoadon" class="btn btn-flat btn-info rounded"><span
                        class="fas fa-backward"></span> Trở về</a>
            <!-- You can add additional tools or buttons here if needed -->
        </div>
		<hr>

    </div>
    <hr>
    <?php
// Truy vấn SQL
$mahoadon = pg_escape_string($_GET['id']); // Sanitize input
$sql = "SELECT mahoadon, sp.tensanpham, soluong
            FROM public.chitiethoadon ct
            JOIN sanpham sp ON sp.masanpham = ct.masanpham
            WHERE mahoadon = '{$mahoadon}'";

// Thực hiện truy vấn
$result = pg_query($connPG, $sql);

// Kiểm tra và hiển thị kết quả trong bảng HTML
if ($result) {
    ?>
    <table id="myTable" class="table table-bordered border-primary">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Mã hóa đơn</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Chức năng</th>
        </tr>
        </thead>
        <tbody>
        <?php
while ($row = pg_fetch_assoc($result)) {
        ?>
        <tr>
            <th scope="row"><?=$row['mahoadon']?></th>
            <td><?=$row['tensanpham']?></td>
            <td><?=$row['soluong']?></td>
            <td>
                <div class="d-flex">
                    <a class="btn btn-success"
                        href="?page=chitiethoadon/manage_chitiethoadon&id=<?php echo $row['mahoadon'] ?>">Sửa</a>
                    <a class="btn btn-danger delete_data" href="javascript:void(0)"
                        data-id="<?php echo $row['mahoadon'] ?>">Xóa</a>
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
			_conf("Bạn có chắc chắn xóa này vĩnh viễn?","delete_sanpham",[$(this).attr('data-id')])

		})
		$('#myTable').DataTable({
		"paging": true,
		"language": {
        "url": "<?php echo base_url ?>assets/Vietnamese.json" // hoặc đường dẫn tới file Vietnamese.json trên máy của bạn
    }
		});
	})
	function delete_sanpham($id){

		$.ajax({
			url: _base_url_ + 'classes/Master.php?f=delete_sanpham',
			method:"POST",
			data:{masanpham: $id},
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
