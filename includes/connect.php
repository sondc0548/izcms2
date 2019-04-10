<?php
	// kêt nối CSDL
	$dbc = mysqli_connect("localhost", "root", "", "izcms");
	// nếu ko kết nối thành công thì báo lỗi ra trình duyệt
	if(!$dbc){ // nếu  ko tồn tại biến $dbc hoặc có lỗi
		trigger_error("Could not connect to db:". mysqli_connect_error());
	} else {
		// đặt phương thức kết nối là  utf-8
		mysqli_set_charset($dbc,"utf-8");
	}
?>