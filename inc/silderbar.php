<div class="sidebar left ">
	<div class="user-panel">

		<div class="info">
			<p>bootstrap develop</p>
			<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		</div>
	</div>
	<ul class="list-sidebar bg-defoult">

		<li> <a href="#"><i class="fa fa-diamond"></i> <span class="nav-label">Trang chủ</span></a> </li>
		<li> <a href="#" data-toggle="collapse" data-target="#products" class="collapsed active"> <i
					class="fa fa-bar-chart-o"></i> <span class="nav-label">Quản lí</span> <span
					class="fa fa-chevron-left pull-right"></span> </a>
			<ul class="sub-menu collapse" id="products">
				<li class="active"><a href="?page=sanpham">Sản phẩm</a></li>
				<li><a href="?page=danhmuc">Danh mục</a></li>
				<li><a href="?page=thuonghieu">Thương hiệu</a></li>
				<li><a href="?page=nhacungcap">Nhà cung cấp</a></li>
				<li><a href="?page=hoadon">Hóa đơn</a></li>
				<li><a href="?page=phieunhap">Phiếu nhập</a></li>
				<li><a href="?page=khachhang">Khách hàng</a></li>
				<li><a href="?page=loaikhachhang">Loại khách hàng</a></li>
				<li><a href="?page=kho">Kho</a></li>
			</ul>
		</li>
		<li> <a href="#" data-toggle="collapse" data-target="#tables" class="collapsed active"><i
					class="fa fa-table"></i> <span class="nav-label">Quản trị</span><span
					class="fa fa-chevron-left pull-right"></span></a>
			<ul class="sub-menu collapse" id="tables">
				<li><a href="?page=nhanvien">Nhân viên</a></li>
				<li><a href="?page=taikhoan">Tài khoản</a></li>
				<li><a href="?page=chinhanh">Chi nhánh</a></li>
				<li><a href="?page=tinh">Tỉnh</a></li>
			</ul>
		</li>

	</ul>
</div>

<script>
$(document).ready(function() {
	$('.button-left').click(function() {
		$('.sidebar').toggleClass('fliph');
	});

});
</script>
