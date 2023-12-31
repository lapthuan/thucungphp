<div>
    <div class="card-header">
        <h3 class="card-title">Chi tiết phiếu nhập</h3>
        <div class="card-tools d-flex justify-content-between">
            <a href="?page=manage_chitietphieunhap&&id=<?php echo $_GET['id'] ?>" class="btn btn-flat btn-success rounded"><span
                        class="fas fa-plus"></span> Tạo mới</a>
						<a href="?page=phieunhap" class="btn btn-flat btn-info rounded"><span
                        class="fas fa-backward"></span> Trở về</a>
        </div>
    </div>
    <hr>
    <?php
// Truy vấn SQL
$maphieunhap = pg_escape_string($_GET['id']); // Sanitize input
$sql = "SELECT maphieunhap,sp.masanpham, sp.tensanpham, soluong, dongia
            FROM public.chitietphieunhap ct
            JOIN sanpham sp ON sp.masanpham = ct.masanpham
            WHERE maphieunhap = '{$maphieunhap}'";

// Thực hiện truy vấn
$result = pg_query($connPG, $sql);

// Kiểm tra và hiển thị kết quả trong bảng HTML
if ($result) {
    ?>
    <table id="myTable" class="table table-bordered border-primary">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Mã phiếu nhập</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Đơn giá</th>
            <th scope="col">Chức năng</th>
        </tr>
        </thead>
        <tbody>
        <?php
while ($row = pg_fetch_assoc($result)) {
        ?>
        <tr>
            <th scope="row"><?=$row['maphieunhap']?></th>
            <td><?=$row['tensanpham']?></td>
            <td><?=$row['soluong']?></td>
            <td><?=$row['dongia']?></td>
            <td>
                <div class="d-flex">
                    <a class="btn btn-success"
                        href="?page=manage_chitietphieunhap&&id=<?php echo $_GET['id'] ?>&&sp=<?php echo $row['masanpham'] ?>">Sửa</a>
                    <a class="btn btn-danger delete_data" href="javascript:void(0)"
                        data-id="<?php echo $row['maphieunhap'] ?>"
                        data-masanpham="<?php echo $row['masanpham'] ?>"
                        >Xóa</a>
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
			_conf("Bạn có chắc chắn xóa này vĩnh viễn?","delete_chitietphieunhap",[$(this).attr('data-id'),$(this).attr('data-masanpham')])

		})
		$('#myTable').DataTable({
		"paging": true,
		"language": {
        "url": "<?php echo base_url ?>assets/Vietnamese.json" // hoặc đường dẫn tới file Vietnamese.json trên máy của bạn
    }
		});
	})
	function delete_chitietphieunhap($id,$masanpham){
        console.log('id', $id)
        console.log('masanpham', $masanpham)
		$.ajax({
			url: _base_url_ + 'classes/Master.php?f=delete_chitietphieunhap',
			method:"POST",
			data:{maphieunhap: $id,masanpham: $masanpham},
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