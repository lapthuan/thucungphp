<div>
    <div class="card-header">
        <h3 class="card-title">Danh sách hóa đơn</h3>
        <div class="card-tools">
            <a href="?page=hoadon/manage_hoadon" class="btn btn-flat btn-success rounded"><span
                        class="fas fa-plus"></span> Tạo mới</a>
        </div>
    </div>
    <hr>
    <?php
// Truy vấn SQL
$sql = "SELECT mahoadon, kh.tenkhachhang, nv.tennhanvien, cn.tenchinhanh, ngaylap
            FROM public.hoadon hd
            JOIN nhanvien nv ON nv.manhanvien = hd.manhanvien
            JOIN chinhanh cn ON cn.machinhanh = hd.machinhanh
            JOIN khachhang kh ON kh.makhachhang = hd.makhachhang;";

// Thực hiện truy vấn
$result = pg_query($connPG, $sql);

// Kiểm tra và hiển thị kết quả trong bảng HTML
if ($result) {
    ?>
    <table id="myTable" class="table table-bordered border-primary">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Mã hóa đơn</th>
            <th scope="col">Khách hàng</th>
            <th scope="col">Nhân viên</th>
            <th scope="col">Chi nhánh</th>
            <th scope="col">Ngày lập</th>
            <th scope="col">Xem chi tiết</th>
            <th scope="col">Chức năng</th>
        </tr>
        </thead>
        <tbody>
        <?php
while ($row = pg_fetch_assoc($result)) {
        ?>
        <tr>
            <th scope="row"><?=$row['mahoadon']?></th>
            <td><?=$row['tenkhachhang']?></td>
            <td><?=$row['tennhanvien']?></td>
            <td><?=$row['tenchinhanh']?></td>
            <td><?=date("d-m-Y", strtotime($row['ngaylap']))?></td>
            <td>  <a href="?page=chitiethoadon&&id=<?=$row['mahoadon']?>" class="btn btn-flat btn-info rounded"><span
                        class="fas fa-search-plus"></span> Xem</a></td>
            <td>
                <div class="d-flex">
                    <a class="btn btn-success"
                        href="?page=hoadon/manage_hoadon&id=<?php echo $row['mahoadon'] ?>">Sửa</a>
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
			_conf("Bạn có chắc chắn xóa này vĩnh viễn?","delete_hoadon",[$(this).attr('data-id')])

		})
		$('#myTable').DataTable({
		"paging": true,
		"language": {
        "url": "<?php echo base_url ?>assets/Vietnamese.json" // hoặc đường dẫn tới file Vietnamese.json trên máy của bạn
    }
		});
	})
	function delete_hoadon($id){

		$.ajax({
			url: _base_url_ + 'classes/Master.php?f=delete_hoadon',
			method:"POST",
			data:{mahoadon: $id},
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