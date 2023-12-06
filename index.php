<?php require_once 'config.php';?>



<!DOCTYPE html>
<html lang="en">

<?php include_once "inc/header.php"?>

<body>
	<?php include_once "inc/navbar.php"?>
	<div class="main">
		<aside class="d-flex">
			<?php include_once "inc/silderbar.php"?>
			<?php $page = isset($_GET['page']) ? $_GET['page'] : 'home';?>


			<div class="w-100 m-4 body-color">
				<div class=" m-4">
					<?php

if (!file_exists("page/" . $page . ".php") && !is_dir("page/" . $page)) {
    include '404.html';
} else {
    if (is_dir("page/" . $page)) {
        include "page/" . $page . '/index.php';
    } else {
        include "page/" . $page . '.php';
    }
}
?>
				</div>

			</div>

		</aside>
	</div>
	<?php include_once "inc/footer.php"?>
	<div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xác nhận</h5>
                </div>
                <div class="modal-body">
                    <div id="delete_content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id='confirm' onclick="">Thực hiện</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
