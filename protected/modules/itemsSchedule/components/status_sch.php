<?php
/**
* 
*/
class status_sch 
{
	static function getStatusColor($status)
	{
		$col = '';
		switch ($status) {
			case '1':		// lịch mới
				$col = 'rgb(0,176,240)';
				break;
			case '2':		// đang chờ
				$col = 'rgb(255,255,0)';
				break;
			case '3':		// điều trị
				$col = 'rgb(0,255,0)';
				break;
			case '4':		// hoàn tất
				$col = 'rgb(255, 0, 0)';
				break;
			case '5':		// bỏ về
				$col = 'rgb(258, 108, 10)';
				break;
			case '-1':		// hẹn lại
				$col = 'rgb(0, 0, 153)';
				break;
			case '-2':		//Không đến
				$col = '#965050';
				break;
			case '0':		//Không làm việc
				$col = '#b4b4b4';
				break;
			case '6':		// vào khám
				$col = 'rgb(0,255,0)';
				break;
			case '7':		//xac nhan 
				$col = 'rgb(255, 51, 204)';
				break;
			
			default:
				$col = 'rgba(184, 59, 59, 0.75)';
				break;
		}
		return $col;
	}
}