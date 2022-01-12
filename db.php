<?php
    define('HOST', '127.0.0.1');
    define('USER', 'root');
    define('PASSWORD', '');
    define('DB', 'ck');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require 'vendor/autoload.php';
	
	//connect to database
    function open_database() {
        $conn = new mysqli(HOST, USER, PASSWORD, DB);
        if ($conn->connect_error){
            die('Không thể kết nối đến cơ sở dữ liệu');
        }
        return $conn;
    }
	
	//login employee
    function login_employee($user, $pass){
		$sql = "SELECT * FROM employee WHERE username=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }

        $result = $stm->get_result();
		$data = $result->fetch_assoc();
        if ($result->num_rows==0){
            return array('code' => 2, 'message' => 'Không tồn tại tài khoản'); // return array(code, message)
        }
		$hashed_password = $data['password'];
        if (!password_verify($pass, $hashed_password)){
            return array('code' => 3, 'message' => 'Sai mật khẩu'); // return array(code, message)
        }
        return array('code'=>0, 'message' =>'success', 'data' => $data);
    }

    //login admin
    function login_admin($user, $pass){
		$sql = "SELECT * FROM director WHERE username=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }

        $result = $stm->get_result();
		$data = $result->fetch_assoc();
        if ($result->num_rows==0){
            return array('code' => 2, 'message' => 'Không tồn tại tài khoản'); // return array(code, message)
        }
		$hashed_password = $data['password'];
        if (!password_verify($pass, $hashed_password)){
            return array('code' => 3, 'message' => 'Sai mật khẩu'); // return array(code, message)
        }
        return array('code'=>0, 'message' =>'success', 'data' => $data);
    }
	
	//check email exists
	function is_email_exists($email){
        $sql = "SELECT username FROM employee WHERE email=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
        if ($result->num_rows==0){
            return false; 
        } else return true; 
    }

    //check mail director
    function is_email_exists_admin($email){
        $sql = "SELECT username FROM director WHERE email=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $email);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
        if ($result->num_rows==0){
            return false; 
        } else return true; 
    }
	
	
	//check username exists
	function is_username_exists($user){
        $sql = "SELECT * FROM employee WHERE username=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
        if ($result->num_rows==0){
            return false; 
        } else return true; 
    }

    //check username exists admin
	function is_username_exists_admin($user){
        $sql = "SELECT * FROM director WHERE username=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
        if ($result->num_rows==0){
            return false; 
        } else return true; 
    }
	
	
	//register
	function register($user, $role, $email, $first_name, $last_name, $department){
        $hash = password_hash($user, PASSWORD_BCRYPT);
        /*$rand = random_int(0,1000);
        $token = md5($user.'+'.$rand);*/

        if (is_email_exists($email)){
            return array('code' => 2, 'message' => 'Email đã tồn tại'); // return array(code, message)
        }
		
		if (is_username_exists($user)){
            return array('code' => 3, 'message' => 'Username đã tồn tại'); // return array(code, message)
        }

        $sql = 'INSERT INTO account(username, password, role, email, firstname, lastname, department)
        value(?,?,?,?,?,?,?)';
        
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssss',$user, $hash, $role, $email, $first_name, $last_name, $department);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'không thể thực thi câu lệnh sql');; // return array(code, message)
        }
        // send verification email
        //send_verification_email($email, $token);
        return array('code' => 0, 'message' => 'thành công');
    }
	
	//display role
	function get_role(){
        $sql = "SELECT * FROM role";
        $conn = open_database();

        $result = $conn->query($sql);

        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//change password when login first
	function change_password($username, $pass){
        // kiểm tra email token
        /*$sql = 'SELECT * FROM reset_token WHERE email=? and token=? and expire_on>?';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $exp = time();
        $stm->bind_param('ssi', $email, $token, $exp);
        if (!$stm->execute()){
            return array('code'=> 5, 'message'=>'không thể thực thi câu lệnh sql');
        }
        $result = $stm->get_result();
        if ($result->num_rows == 0){
            return array('code'=>8, 'message'=>'Email không hợp lệ hoặc token đã hết hạn');
        }*/
        // đổi mật khẩu
        $hash = password_hash($pass, PASSWORD_BCRYPT);
		$conn = open_database();
        $sql = "UPDATE employee SET password=?, role = 'employee' WHERE username = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$hash,$username);
        if (!$stm->execute()){
            return array('code'=> 1, 'message'=>'không thể thực thi câu lệnh sql');
        }
        //xóa token 
        /*$sql = 'DELETE FROM reset_token WHERE email=?';
        $stm = $conn->prepare($sql);
        $exp = time();
        $stm->bind_param('s', $email);
        if (!$stm->execute()){
            return array('code'=> 9, 'message'=>'không thể xóa token');
        }*/

        return array('code' => 0 , 'message' => 'success');
    }
	
	//check old password
	function check_old_pass($pass, $user){
        $sql = "SELECT password FROM employee WHERE username=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
		$row = $result->fetch_assoc();
		
		$hashed_password = $row['password'];
        if (!password_verify($pass, $hashed_password)){
            return false;
        }
        return true;
    }
	
	//change password for employee
	function change_password_employee($user, $pass){
        $hash = password_hash($pass, PASSWORD_BCRYPT);
		$conn = open_database();
        $sql = "UPDATE employee SET password=? WHERE username = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$hash,$user);
        if (!$stm->execute()){
            return array('code'=> 1, 'message'=>'không thể thực thi câu lệnh sql');
        }
        return array('code' => 0 , 'message' => 'success');
    }

    //check username exists in table request_reset
	function is_username_forgot($user){
        $sql = "SELECT * FROM request_reset WHERE username=? and token = 1";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $user);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
        if ($result->num_rows==0){
            return false; 
        } else return true; 
    }
	
	//forgot password
	function forgot_password($email, $user){
        if (!is_email_exists($email)){
            return array('code'=>2, 'message' =>'Email không tồn tại');
        }
		if (!is_username_exists($user)){
            return array('code'=>3, 'message' =>'Username không tồn tại');
        }
        if (is_username_forgot($user)){
            return array('code'=>4, 'message' =>'Bạn đã gửi yêu cầu, hãy đợi yêu cầu được phê duyệt');
        }

        $token = 1;
        $sql = "INSERT INTO request_reset (username, email, token) VALUES (?,?,?)";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssi', $user, $email, $token);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
        return array('code' =>0, 'message' =>'thành công');
    }

    //send email reset password admin
    function send_reset_email($email, $token){

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'phamhuynhanhtien.12a20.2019@gmail.com';                     //SMTP username
            $mail->Password   = 'anhtien2812';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
            $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('phamhuynhanhtien.12a20.2019@gmail.com', 'Admin company');
            $mail->addAddress($email, 'Người nhận');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            //$mail->addReplyTo('info@example.com', 'Information');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Reset your password';
            $mail->Body    = "Click <a href='http://localhost:8080/taikhoan/reset_password_admin.php?email=$email&token=$token'>vào đây</a> để khôi phục tài khoản của bạn";
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
	
	//reset password
	function reset_password($user){
		if (!is_username_exists($user)){
            return array('code' => 2, 'message' => 'Username không tồn tại');; // return array(code, message)
        }
		$hash = password_hash($user, PASSWORD_BCRYPT);
		$conn = open_database();
        $sql = "UPDATE employee SET password=?, role = 'user' WHERE username = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$hash,$user);
        if (!$stm->execute()){
            return array('code'=> 1, 'message'=>'không thể thực thi câu lệnh sql');
        }
        return array('code' => 0 , 'message' => 'success');
    }

    function send_email($email){
        if (!is_email_exists_admin($email)){
            return array('code'=>7, 'message' =>'Email không tồn tại');
        }
        $token = md5($email.'+'.random_int(1000,2000));
        $sql = "UPDATE reset_token SET token=? where email=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $token, $email);
        if (!$stm->execute()){
            return array('code' =>5, 'message' =>'không thể thực thi câu lệnh sql');
        }

        if ($stm->affected_rows == 0){
            $exp = time() + 3600*24;
            $sql = "INSERT INTO reset_token values(?,?,?)";
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm->bind_param('ssi', $email, $token, $exp);
            if (!$stm->execute()){
                return array('code' =>5, 'message' =>'không thể thực thi câu lệnh sql');
            }
            // thành công
        }
        $result = send_reset_email($email, $token);
        return array('code' =>0, 'message' =>'thành công', 'result' =>$result);
    }

    //reset password admin
	function reset_password_admin($user, $email){
		if (!is_username_exists_admin($user)){
            return array('code' => 3, 'message' => 'Username không tồn tại'); // return array(code, message)
        }
        //$token = md5($email.'+'.random_int(1000,2000));
		$hash = password_hash($user, PASSWORD_BCRYPT);
		$conn = open_database();
        $sql = "UPDATE director SET password=?, role = 'admin' WHERE username = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$hash,$user);
        if (!$stm->execute()){
            return array('code'=> 1, 'message'=>'không thể thực thi câu lệnh sql');
        }
        //delete token
        $sql = 'DELETE FROM reset_token WHERE email=?';
        $stm = $conn->prepare($sql);
        $exp = time();
        $stm->bind_param('s', $email);
        if (!$stm->execute()){
            return array('code'=> 9, 'message'=>'không thể xóa token');
        }
        return array('code' => 0 , 'message' => 'success');
    }
	
	//display request reset password of employee
	function get_request(){
        $sql = "SELECT * FROM request_reset WHERE token = 1";
        $conn = open_database();

        $result = $conn->query($sql);

        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//update token in table request_reset of employee
	function update_token($id){
        $sql = "UPDATE request_reset SET token = 0 WHERE id = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('i', $id);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
        return array('code' =>0, 'message' =>'thành công');
    }
	
	//display list department
	function get_department(){
        $sql = "SELECT * FROM department";
        $conn = open_database();

        $result = $conn->query($sql);

        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//add department
    function add_department($id, $name, $manager, $contact, $phone, $describe) {
        $sql = "INSERT INTO department (id, name, manager, contact, phone, description) VALUES (?,?,?,?,?,?)";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssss',$id, $name, $manager, $contact, $phone, $describe);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//delete department
    function delete_department($id){
        $sql = "DELETE FROM department WHERE id=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//update department
    function update_department($id, $name, $manager, $contact, $phone, $describe, $idold){
        $sql = "UPDATE department SET id = ?, name = ?, manager = ?, contact = ?, phone = ?, description = ? where id = ?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssss',$id, $name, $manager, $contact, $phone, $describe, $idold);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//search department
	function search_department($id){
        $conn = open_database();
		$sql = "SELECT * FROM department WHERE id = ?";
		$stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//sort department a->z by name
	function sort_by_az(){
        $conn = open_database();
		$sql = "SELECT * FROM department ORDER BY name ASC";
		$stm = $conn->prepare($sql);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//sort department z->a by name
	function sort_by_za(){
        $conn = open_database();
		$sql = "SELECT * FROM department ORDER BY name DESC";
		$stm = $conn->prepare($sql);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//display employee by department
	function get_employee_by_department($name_department, $id_department){
        $sql = "SELECT * FROM employee WHERE department = ? and id_department = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $name_department, $id_department);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
		$result = $stm->get_result();
		
		if ($result->num_rows==0){
            return array('code' => 2, 'message' => 'Không tồn tại tài phòng ban'); // return array(code, message)
        }
		
        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//select id of department for choose manager
	function get_id_department(){
        $sql = "SELECT id FROM department";
        $conn = open_database();

        $result = $conn->query($sql);

        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//check manager exists
	function is_manager_exists($name){
        $sql = "SELECT * FROM manager WHERE name=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $name);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
        if ($result->num_rows==0){
            return false; 
        } else return true; 
    }
	
	//update position manager of department
    function update_manager($name, $id){
		if (is_manager_exists($name)){
            return array('code' => 2, 'message' => 'People cannot choose'); // return array(code, message)
        }
        $sql = "UPDATE department SET manager = ? WHERE id = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $name, $id);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
        return array('code' =>0, 'message' =>'thành công');
    }
	
	//update position manager of department
    function reset_employee($department){
        $sql = "UPDATE employee SET position = 'employee' WHERE department = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $department);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
        return array('code' =>0, 'message' =>'thành công');
    }
	
	//update position manager of department
    function update_position_employee($id){
        $sql = "UPDATE employee SET position = 'Manager' WHERE idnv = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
        return array('code' =>0, 'message' =>'thành công');
    }
	
	//reset role
    function reset_role_account($department){
        $sql = "UPDATE employee SET role = 'employee' WHERE department = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $department);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
        return array('code' =>0, 'message' =>'thành công');
    }
	
	//get tentk by id
    function get_tentk_by_id($id){
        $sql = "SELECT username FROM employee WHERE idnv = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
		$result = $stm->get_result();
		$data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
		
        return array('code'=>0, 'data'=>$data);
    }
	
	//update role in account
    function update_role_account($name){
        $sql = "UPDATE employee SET role = 'manager' WHERE username = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $name);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
        return array('code' =>0, 'message' =>'thành công');
    }
	
	//update manager in manager table
    function update_name_manager($name, $department){
        $sql = "UPDATE manager SET name = ? WHERE department = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $name, $department);
        if (!$stm->execute()){
            return array('code' =>1, 'message' =>'không thể thực thi câu lệnh sql');
        }
        return array('code' =>0, 'message' =>'thành công');
    }
	
	
	//display list employee
	function get_employee(){
        $sql = "SELECT * FROM employee";
        $conn = open_database();

        $result = $conn->query($sql);

        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//select name of department for add employee
	function get_name_department(){
        $sql = "SELECT name FROM department";
        $conn = open_database();

        $result = $conn->query($sql);

        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }

    //check id and name department exiat
    function is_id_name_department_exists($id, $name){
        $sql = "SELECT * FROM department WHERE id = ? and name=?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$id, $name);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
        if ($result->num_rows==0){
            return false; 
        } else return true; 
    }

	//add employee
    function add_employee($id, $name, $user, $position, $department, $id_department, $email, $phone, $indentity, $gender, $image, $role) {
        $hash = password_hash($user, PASSWORD_BCRYPT);
        /*$rand = random_int(0,1000);
        $token = md5($user.'+'.$rand);*/

        if (is_email_exists($email)){
            return array('code' => 2, 'message' => 'Email đã tồn tại'); // return array(code, message)
        }
		
		if (is_username_exists($user)){
            return array('code' => 3, 'message' => 'Username đã tồn tại'); // return array(code, message)
        }

        if (!is_id_name_department_exists($id_department, $department)){
            return array('code' => 4, 'message' => 'Không tồn tại phòng ban với id và name được chọn'); // return array(code, message)
        }

        $sql = "INSERT INTO employee (idnv, name, username, position, department, id_department, email, phone, indentity, gender, image, password, role) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssssssssss', $id, $name, $user, $position, $department, $id_department, $email, $phone, $indentity, $gender, $image, $hash, $role);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }

        $sql = "INSERT INTO dayoff_employee (name, tentk, tongso, ngaydasudung, ngayconlai) VALUES (?,?,12,0,12)";
		/*if(is_username_exists($user))
		{
			return array('code' => 2, 'message' => 'Account đã tồn tại'); 
		}*/
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $name, $user);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//delete employee
    function delete_employee($id){
        $sql = "DELETE FROM employee WHERE idnv=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//update emoloyee
	function update_employee($id, $name, $user, $position, $email, $phone, $indentity, $gender, $idold) {
        $sql = "UPDATE employee SET idnv = ?, name = ?, username = ?, position = ?, email = ?, phone = ?, indentity = ?, gender = ? WHERE idnv = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssssss', $id, $name, $user, $position, $email, $phone, $indentity, $gender, $idold);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//search employee
	function search_employee($id){
        $conn = open_database();
		$sql = "SELECT * FROM employee WHERE idnv = ?";
		$stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//sort employee a->z by name
	function sort_by_az_employee(){
        $conn = open_database();
		$sql = "SELECT * FROM employee ORDER BY name ASC";
		$stm = $conn->prepare($sql);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//sort employee z->a by name
	function sort_by_za_employee(){
        $conn = open_database();
		$sql = "SELECT * FROM employee ORDER BY name DESC";
		$stm = $conn->prepare($sql);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//display dayoff of manager
	function get_dayoff_manager(){
        $conn = open_database();
		$sql = "SELECT * FROM dayoff WHERE token = 1 and role = 'manager'";
		
        $result = $conn->query($sql);

        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }

    //display dayoff of employee
	function get_dayoff_employee(){
        $conn = open_database();
		$sql = "SELECT * FROM dayoff WHERE token = 1 and role = 'employee'";
		
        $result = $conn->query($sql);

        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }

    
	
	//display employee by tentk
	function get_employee_by_tentk($tentk){
        $conn = open_database();
		$sql = "SELECT * FROM employee WHERE username = ?";
		$stm = $conn->prepare($sql);
        $stm->bind_param('s', $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//display dayoff of employee by tentk
	function get_dayoff_by_tentk($tentk){
        $conn = open_database();
		$sql = "SELECT * FROM dayoff_employee WHERE tentk = ?";
		$stm = $conn->prepare($sql);
        $stm->bind_param('s', $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//display request dayoff of employee
	function request_dayoff_by_tentk($tentk){
        $conn = open_database();
		$sql = "SELECT * FROM dayoff WHERE tentk = ?";
		$stm = $conn->prepare($sql);
        $stm->bind_param('s', $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//add dayoff employee
	function add_dayoff_employee($numoff, $reason, $attach, $tentk, $role) {
		$day_request = date("Y/m/d");
        $sql = "INSERT INTO dayoff (numberoff, reason, attach, status, tentk, day_request, token, role) VALUES (?,?,?,'waiting',?,?, 0,?)";
        $conn = open_database();
		
		if(is_dayoff_exists($tentk))
		{
			return array('code' => 2, 'message' => 'Yêu cầu đang được duyệt nên không thể tạo thêm yêu cầu mới'); 
		}
		
		if(!check_seven_dayoff($tentk))
		{
			return array('code' => 3, 'message' => 'Phải đợi 7 ngày sau mới được tạo yêu cầu mới'); 
		}
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('isssss', $numoff, $reason, $attach, $tentk, $day_request, $role);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    function add_dayoff($name, $tentk) {
        $sql = "INSERT INTO dayoff_employee (name, tentk, tongso, ngaydasudung, ngayconlai) VALUES (?,?,12,0,12)";
        $conn = open_database();
		
		if(is_username_exists($tentk))
		{
			return array('code' => 2, 'message' => 'Account đã tồn tại'); 
		}
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $name, $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }



	
	//check request dayoff exists
	function is_dayoff_exists($tentk){
        $sql = "SELECT * FROM dayoff WHERE tentk=? and status = 'waiting'";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $tentk);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
        if ($result->num_rows==0){
            return false; 
        } else return true; 
    }
	
	//update day of employee
	function update_dayoff_employee_ngaydasudung($numoff, $tentk) {
        $sql = "UPDATE dayoff_employee SET ngaydasudung = ngaydasudung + ? WHERE tentk = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('is', $numoff, $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	function update_dayoff_employee_ngayconlai($numoff, $tentk) {
        $sql = "UPDATE dayoff_employee SET ngayconlai = ngayconlai - ? WHERE tentk = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('is', $numoff, $tentk);
		
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//get ngayconlai of dayoff_employee
	function get_ngayconlai($tentk){
        $conn = open_database();
		$sql = "SELECT ngayconlai FROM dayoff_employee WHERE tentk = ?";
		$stm = $conn->prepare($sql);
		$stm->bind_param('s', $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
	//compute 7 day
	function compute_dayoff($ngayyeucau, $ngayhientai){
       $ngayyeucau = strtotime($ngayyeucau);
	   $ngayhientai = strtotime($ngayhientai);
	   $temp = round(($ngayhientai - $ngayyeucau) / 86400);
	   return $temp;
    }
	
	//check 7 day for request dayoff
	function check_seven_dayoff($tentk){
        $sql = "SELECT * FROM dayoff WHERE tentk=? ORDER BY id DESC";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $tentk);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
		$row = $result->fetch_assoc();
		$today = date("Y/m/d");
		
        $number_day = compute_dayoff($row['day_request'], $today);
		if($number_day < 7)
		{
			return false;
		}
		return true;
    }
	
	//add image avatar for employee
	function change_image_employee($image, $tentk) {
        $sql = "UPDATE employee SET image = ? WHERE username = ?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $image, $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//update status dayoff approved
	function update_status_approved($tentk) {
        $sql = "UPDATE dayoff SET status = 'approved', token = 0 WHERE tentk = ?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//update status dayoff refused
	function update_status_refused($tentk) {
        $sql = "UPDATE dayoff SET status = 'refused', token = 0 WHERE tentk = ?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $tentk);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//get all tasks (manager) 
    function get_all_tasks($id_department){
        $conn = open_database();
		
		$sql = "SELECT * FROM task WHERE id_department = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id_department);
		if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();

        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code' => 0, 'message' =>'thành công', 'data' => $data);
    }

    function get_employee_by_id_task($id_department){
        $conn = open_database();
		
		$sql = "SELECT * FROM employee WHERE id_department = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id_department);
		if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();

        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code' => 0, 'message' =>'thành công', 'data' => $data);
    }
    
    //get all submission (manager)
    function get_all_submissions(){
        $conn = open_database();
		
		$sql = "SELECT * FROM submission WHERE token = 1";
		$result = $conn->query($sql);

        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code' => 0, 'message' =>'thành công', 'data' => $data);
    }
    //get task name
    function get_task($idtask){
        $conn = open_database();
		$sql = "SELECT * FROM task WHERE idtask = ?";
		$stm = $conn->prepare($sql);
        $stm->bind_param('s', $idtask);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0,'message'=>'sussess', 'data'=>$data);
    }
    // get_all_tasks_employee
    function get_all_tasks_employee($idnv){
        $conn = open_database();
		$sql = "SELECT * FROM task WHERE idnv = ? and token = 1";
		$stm = $conn->prepare($sql);
        $stm->bind_param('s', $idnv);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); // return array(code, message)
        }
		$result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        return array('code'=>0,'message'=>'sussess', 'data'=>$data);
    }
    //get all submission (employee)
    function get_submission($idnv){
        $sql = "SELECT * FROM submission where idnv=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $idnv);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        
        return array('code' => 0, 'message'=>'thành công','data'=>$data);
    }

    //create task by manager
	function add_task($id, $name, $desc, $nv, $due, $id_department) {
        //$due = $due("Y/m/d");
        $sql = "INSERT INTO task (idtask, name, status, description, idnv, dueto, id_department, token) VALUES (?,?,'New',?,?,?,?,1)";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssss', $id, $name, $desc, $nv, $due, $id_department);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    //display id employee 
	function get_employee_by_id(){
        $sql = "SELECT idnv FROM employee";
        $conn = open_database();

        $result = $conn->query($sql);
		
        $data = array();
        while (($row = $result->fetch_assoc())){
            $data[] = $row;
        }
        return array('code'=>0, 'data'=>$data);
    }
	
    //update task status 'In progress'
	function update_task_inprogress($id) {
        $sql = "UPDATE task SET status = 'In progress' WHERE idtask = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    //update task status 'canceled'
	function update_task_canceled($id) {
        $sql = "UPDATE task SET status = 'Canceled', token = 0 WHERE idtask = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    //update task status 'Waiting'
	function update_task_waiting($id) {
        $sql = "UPDATE task SET status = 'Waiting' WHERE idtask = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//update task status 'Rejected'
	function update_task_rejected($id) {
        $sql = "UPDATE task SET status = 'Rejected' WHERE idtask = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
       
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    //update task status 'Rejected'
	function update_token_rc($id) {
        $sql = "UPDATE submission SET token = 0 WHERE idsm = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//update task status 'Completed'
	function update_task_completed($id) {
        $sql = "UPDATE task SET status = 'Completed' WHERE idtask = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    //add evaluate
	function add_evaluate($evaluate, $idtask) {
        $sql = "UPDATE task SET evaluate = ? WHERE idtask = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $evaluate, $idtask);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    //add submission
	function add_submission($idnv, $idtask, $attach, $desc, $deadline, $status) {
        $day = date("Y-m-d");
        $sql = "INSERT INTO submission (idnv, idtask, attach, description, day_submit, deadline, turnin, token) VALUES (?,?,?,?,?,?,?,1)";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssss', $idnv, $idtask, $attach, $desc, $day, $deadline, $status);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
	
	//update deadline for status rejected task
	function update_deadline_reject($deadline, $id) {
        $sql = "UPDATE task SET dueto = ? WHERE idtask = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $deadline, $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    //add not and attach file for reject
	function add_note_attach($note, $attach, $idtask) {
        $day = date("Y-m-d");
        $sql = "UPDATE task SET note = ?, attach = ? WHERE idtask = ?";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss', $note, $attach, $idtask);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    //check deadline for task
	function check_deadline_task($idtask, $idsm){
        $sql = "SELECT * FROM task WHERE idtask = ?";
        $sql1 = "SELECT * FROM submission WHERE idsm = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $idtask);
        if (!$stm->execute()){
            die($stm->error);
        } 

        $result = $stm->get_result();
		$row = $result->fetch_assoc();

        $stm1 = $conn->prepare($sql1);
        $stm1->bind_param('s', $idsm);
        if (!$stm1->execute()){
            die($stm1->error);
        } 

        $result1 = $stm1->get_result();
		$row1 = $result1->fetch_assoc();
		
		
        $number_day = compute_dayoff($row['dueto'], $row1['day_submit']);
		if($number_day > 0)
		{
			return false;
		}
		return true;
    }

    //add reject table
	function add_task_history($idnv, $idtask, $status, $day, $count) {
        $sql = "INSERT INTO reject (idnv, idtask, status, day, count) VALUES (?,?,?,?,?)";
        $conn = open_database();
		
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssssi', $idnv, $idtask, $status, $day, $count);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }

    function count_task_submit($idtask){
        $sql = "SELECT count(*) FROM reject where idtask=? and status = 'Submit'";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $idtask);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		$row = $result->fetch_assoc();
        /*$data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }*/
        
        return $row;
    }

    function count_task_submit_reject($idtask){
        $sql = "SELECT count(*) FROM reject where idtask=? and status = 'Rejected'";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $idtask);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		$row = $result->fetch_assoc();
        /*$data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }*/
        
        return $row;
    }

    
    //get history task
    function get_history_task($id){
        $sql = "SELECT * FROM reject where idnv=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        
        return array('code' => 0, 'message'=>'thành công','data'=>$data);
    }

    function get_history_task_completed($idtask, $idnv){
        $sql = "SELECT * FROM reject where idtask = ?, idnv=? and status = 'Completed'";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss', $idtask, $idnv);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        
        return array('code' => 0, 'message'=>'thành công','data'=>$data);
    }

    //get status submission 
    function get_status_submission($id){
        $sql = "SELECT * FROM submission where idsm=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        
        return array('code' => 0, 'message'=>'thành công','data'=>$data);
    }

    //count task for employee 
    function count_task_employee($idnv){
        $sql = "SELECT count(*) FROM task where idnv=? and status IN('New', 'Waiting', 'In progress', 'Rejected') ";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $idnv);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		$row = $result->fetch_assoc();
        /*$data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }*/
        
        return $row;
    }

    //display task rejected
    
    //get status submission 
    function get_task_rejected($id){
        $sql = "SELECT * FROM reject where idtask=? ORDER BY id DESC";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        
        return array('code' => 0, 'message'=>'thành công','data'=>$data);
    }

    //get task of employee
    function get_view_task($id){
        $sql = "SELECT * FROM task where idtask=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        
        return array('code' => 0, 'message'=>'thành công','data'=>$data);
    }

    //get dayoff by id
    function get_dayoff_by_id($id){
        $sql = "SELECT * FROM dayoff where id=?";
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s', $id);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        $result = $stm->get_result();
		
        $data = array();
        while($row = $result->fetch_assoc())
		{
            $data[] = $row;
        }
        
        return array('code' => 0, 'message'=>'thành công','data'=>$data);
    }

    // update NEW TASK of manager
    function update_task_new($id_task, $id_employee, $description, $deadline){
        $conn = open_database();
        $sql = "UPDATE task SET description=?, idnv=?, dueto=? WHERE idtask=?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('ssss',$description, $id_employee, $deadline, $id_task);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }
    // update task of manager
    function update_task($id_task, $description, $deadline){
        $conn = open_database();
        $sql = "UPDATE task SET description=?, dueto=? WHERE idtask=?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('sss',$description,$deadline,$id_task);
        if (!$stm->execute()){
            return array('code' => 1, 'message' => 'Không thể thực thi câu lệnh sql'); 
        }
        return array('code' => 0, 'message'=>'thành công');
    }


?>