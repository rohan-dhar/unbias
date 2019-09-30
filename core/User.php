<?php 
	/*
		TODO:
		Implememtts a Low-Level interface for user signin and signup
		Interacts directly with MySQL and $_SESSION to perform operartions
		MySQL operations should 
	*/

	/*
		NOTES:
		User Status Codes:
			0 -> NO SESSION DATA (SIGNED OUT)
			1 -> SESSION DATA WHICH IS VALID (SIGNED IN)
			2 -> SESSION DATA FOUND OF DEACTIVATED/UNAUTH USER (DEACT)
	*/

	class User{
		
		protected $id = null;
		
		protected $status = 0;

		protected $userName = null;
		protected $name = null;
		protected $pass = null;
		protected $email = null;

		protected $dbFetched = false;

		const MIN_USERNAME_LEN = 4;
		const MIN_NAME_LEN = 2;
		const MIN_PASSWORD_LEN = 5;
		const ID_LEN = 24;

		public static function genId(){
			$done = false;
			$id = '';
			while(!$done){
				$id = bin2hex(random_bytes(self::ID_LEN/2));
				$qry = $GLOBALS["db"]->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
				$qry->execute([":id" => $id]);
				$res = $qry->fetch(PDO::FETCH_ASSOC);
				if(!isset($res["id"])){
					$done = true;
				}
			}			
			return $id;
		}

		public function getUserId(){
			return $this->userId;
		}

		public function getStatus(){
			return $this->status;
		}

		public function getDetails(){
			return [
				"id" => $this->id,
				"userName" => $this->userName,
				"name" => $this->name,
				"email" => $this->email,
			];
		}

		public function signOut(){
			unset($_SESSION["userId"]);
			$this->id = null;
			
			$this->userName = null;
			$this->name = null;
			$this->email = null;
			$this->pass = null;

			$this->status = 0;
		}

		protected function setSession($res){
			
			$this->status = 1;
			$_SESSION["userId"] = $res["id"];
			
			$this->id = $res["id"];
			$this->userName = $res["userName"];
			$this->email = $res["email"];
			$this->name = $res["name"];
			$this->pass = $res["password"];

		}

		public function signIn($user, $pass){
			if($this->status != 0){
				return [false, "ALREADY_SIGNEDIN", "You're already signed in."];
			}

			$user = trim($user);
			
			if(strlen($user) < 1 || strlen($pass) < 1){
				return [false, "MISSING_DATA", "Please enter both username and password"];
			}
			
			$qry = $GLOBALS["db"]->prepare("SELECT * FROM users WHERE userName = :userName OR email = :email LIMIT 1");
			$qry->execute([
				":userName" => $user,
				":email" => $user
			]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);

			if(!@isset($res["id"])){
				return [false, "INC_USER", "No user found with this username / email"];
			}
			if(!password_verify($pass, $res["password"])){
				return [false, "INC_PASS", "You've entered an incorrect password"];	
			}

			$this->setSession($res);

			return [true];
		}

		public function signUp($userName, $email, $name, $pass, $cPass, $signIn){
			if($this->status != 0){
				return [false, "ALREADY_SIGNEDIN", "You're already signed in."];
			}

			$userName = trim($userName);
			$email = trim($email);
			$name = trim($name);
			
			if(strlen($userName) < self::MIN_USERNAME_LEN){
				return [false, "INC_USER_NAME_LEN","Your username needs to be ".self::MIN_USERNAME_LEN." characters long."];
			}
			if(strlen($name) < self::MIN_NAME_LEN){
				return [false, "INC_NAME_LEN","Your name needs to be ".self::MIN_NAME_LEN." characters long."];
			}
			if(strlen($pass) < self::MIN_PASSWORD_LEN){
				return [false, "INC_PASSWORD_LEN","Your password needs to be ".self::MIN_PASSWORD_LEN." characters long."];
			}

			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				return [false, "INC_EMAIL_VAL","You've entered an invalid email."];
			}
			if($pass != $cPass){
				return [false, "INC_PASS","The two passwords do not match."];
			}

			$qry = $GLOBALS["db"]->prepare('SELECT * FROM users WHERE email = :email OR userName = :userName LIMIT 1');
			$qry->execute([
				":userName" => $userName,
				":email" => $email
			]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);
			if(isset($res["id"])){
				if($res["email"] == $email){
					return [false, "INC_EMAIL","This email is already used. Try to sign in."];	
				}
				if($res["userName"] == $userName){
					return [false, "INC_USERNAME","This username is already used. Try another Username."];	
				}
				return [false, "INC_USERNAME","This username or email is already used."];	
			}

			$id = self::genId();
			$pass = password_hash($pass, PASSWORD_DEFAULT);

			$qry = $GLOBALS["db"]->prepare("INSERT INTO users (id, userName, email, name, password, status) VALUES (:id, :userName, :email, :name, :pass, 'ACTIVE')");
			$qry->execute([
				':id' => $id,
				':userName' => $userName,
				':email' => $email,
				':name' => $name,				
				':pass' => $pass,
			]);

			if($signIn){
				$this->setSession([
					'id' => $id,
					'userName' => $userName,
					'email' => $email,
					'name' => $name,				
					'pass' => $pass,					
				]);
			}

			return [true];
		}

		function __construct(){
			if(!@isset($_SESSION["userId"])){
				$this->status = 0;
				return;
			}

			$qry = $GLOBALS["db"]->prepare("SELECT * FROM users WHERE id = :uid LIMIT 1");
			$qry->execute([
				":uid" => $_SESSION["userId"]
			]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);

			if(!@isset($res["id"])){
				$this->signOut();
				return;
			}

			$this->id = $res["id"];
			$this->userName = $res["userName"];
			$this->name = $res["name"];
			$this->pass = $res["password"];
			$this->email = $res["email"];				

			if($res['status'] != 'ACTIVE'){
				$this->status = 2;
			}else{
				$this->status = 1;
			}
		}

	}
?>
