<div>

	<div class="card-header">
		<h3 class="card-title">Danh sách sản phẩm</h3>
		<div class="card-tools">
			<a href="?page=sanpham/manage_sanpham" class="btn btn-flat btn-success rounded"><span
					class="fas fa-plus"></span> Tạo mới</a>
		</div>
	</div>
	<hr>
	<?php
// Truy vấn SQL
$sql = "SELECT masanpham, cn.tenchinhanh , tensanpham, giasanpham, dm.tendanhmuc, th.tenthuonghieu
FROM sanpham sp
JOIN chinhanh cn on cn.machinhanh = sp.machinhanh
JOIN danhmuc dm on dm.madanhmuc = sp.madanhmuc
JOIN thuonghieu th on th.mathuonghieu = sp.mathuonghieu;";

// Thực hiện truy vấn
$result = pg_query($connPG, $sql);

// Kiểm tra và hiển thị kết quả trong bảng HTML
if ($result) {
    ?>
	<table id="myTable" class="table table-bordered border-primary">
		<thead class="thead-dark">
			<tr>
				<th scope="col">Mã sản phẩm</th>
				<th scope="col">Chi nhánh</th>
				<th scope="col">Tên sản phẩm</th>
				<th scope="col">Giá</th>
				<th scope="col">Danh mục</th>
				<th scope="col">Thương hiệu</th>
				<th scope="col">Chức năng</th>

			</tr>
		</thead>
		<tbody>
			<?php
while ($row = pg_fetch_assoc($result)) {
        ?>
			<tr>
				<th scope="row"><?=$row['masanpham']?></th>
				<td><?=$row['tenchinhanh']?></td>
				<td><?=$row['tensanpham']?></td>
				<td><?=$row['giasanpham']?></td>
				<td><?=$row['tendanhmuc']?></td>
				<td><?=$row['tenthuonghieu']?></td>
				<td>
					<div class="d-flex ">
						<a class=" btn btn-success "
							href="?page=sanpham/manage_sanpham&id=<?php echo $row['masanpham'] ?>">Sửa</a>
						<a class="btn btn-danger delete_data"  href="javascript:void(0)" data-id="<?php echo $row['masanpham'] ?>" >Xóa</a>
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