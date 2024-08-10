<?php
class Zalo extends CApplicationComponent {
    private $_zalo; 
    private $_api = 'https://zaloapi.conek.vn/';
    public $username; // AWS Access key
	public $password; // AWS Secret key	
	public $brandname; //Nha khoa 2000 chi nhánh Ngô Gia Tự

    protected function getUrl($path) {
        return $this->_api . $path;
    } 

    protected function send($path, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl($path));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $res = curl_exec($ch);
        curl_close($ch);
        return json_decode($res, true);
    }

    protected function extractParam($string)
    {
        $regex = '/\[([^\[\]]+)\]/';
        $matches = [];
        preg_match_all($regex, $string, $matches);
    
        $array = [];
        for ($i = 0; $i < count($matches[1]); $i++) {
            $array[] = $matches[1][$i];
        }
    
        return $array;
    }

    public function sendSms($templateId, $phone, $message = '', $templateData = []) {
        $path = 'SendSMSZalo';
        $data = [
            'username' => $this->username,
            'password' => $this->password,
            'brandname' => $this->brandname,
            'message_sms' => $message,
            'phone' => $phone,
            'template_id' => $templateId,
            'template_data' => $templateData,
            'type_send' => 2,
            'resend_sms' => 1,
            'brandname_sms' => $this->brandname,
            'unicode' => 1
        ];
        return $this->send($path, $data);
    }

    protected function mockTemplates() {
        return array(
            array(
              "template_id" =>  285246,
              "content" =>  "THÔNG BÁO LỊCH HẸN\n\nXin chào Quý khách [tenkhachhang]; Mã khách hàng: [makhachhang]\n\nQuý khách có lịch hẹn tại Nha khoa 2000 Cơ sở [so];\n\nThời gian:\n[thoigian]\nĐịa chỉ:\n[diachi]\nQuý khách vui lòng đến đúng giờ để đảm bảo đủ thời lượng điều trị.\n\nVui lòng liên hệ Hotline nếu Quý khách cần thay đổi lịch hẹn.\n\nCảm ơn Quý khách!",
              "param" =>  "[tenkhachhang],[makhachhang],[so],[thoigian],[diachi]"
            ),
            array(
              "template_id" =>  285610,
              "content" =>  "Chăm sóc sau Phẫu thuật Implant!\n\nNha khoa 2000 Cơ sở 2 cảm ơn Quý khách [tenkhachhang] - mã khách hàng [makh] đã sử dụng dịch vụ tại nha khoa ngày [ngay].\n\nĐể hiểu rõ thêm những điều cần lưu ý sau khi Phẫu thuật Implant, vui lòng truy cập đường dẫn.\n\nTrân trọng!",
              "param" =>  "[tenkhachhang],[makh],[ngay]"
            ),
            array(
              "template_id" =>  285247,
              "content" =>  "TÁI KHÁM RĂNG ĐỊNH KỲ\n\nXin chào Quý khách [tenkh] mã khách hàng [makh]\n\nNha khoa 2000 Cơ sở 2 kính mời Quý khách đến kiểm tra răng định kỳ để kịp thời phát hiện các bệnh lý về răng.\n\nVui lòng liên hệ Hotline đặt hẹn trước khi đến để được phục vụ tốt nhất.\n\nXin cảm ơn!",
              "param" =>  "[tenkh],[makh]"
            ),
            array(
              "template_id" =>  285241,
              "content" =>  "CHĂM SÓC SAU ĐIỀU TRỊ\n\nNha khoa 2000 Cơ sở 2 cảm ơn Quý khách [tenkhachhang] - mã khách hàng [makh] đã sử dụng dịch vụ tại nha khoa vào ngày [ngay]. Sau khi điều trị, nếu Quý Khách gặp những triệu chứng bất thường như:\n\nĐau nhức (tăng dần) - Chảy máu kéo dài - Cấn/cộm (đối với điều trị trám răng/ răng/mão/cầu răng/ hàm giả...).\n\nVui lòng liên hệ Hotline để được hướng dẫn cụ thể.\n\nTrân trọng!",
              "param" =>  "[tenkhachhang],[makh],[ngay]"
            )
        );
    }
    public function getTemplates() {
        try {
            $path = 'GetTemplateZalo';
            $data = [
                'username' => $this->username,
                'password' => $this->password
            ];
            // $result = $this->send($path, $data);
            // $templates = $result['data'];
            $templates = $this->mockTemplates();
            return array_map(function($template) {
                $template['param'] = $this->extractParam($template['param']);
                return $template;
            }, $templates);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return array();
        }
    }
}