<?php 
	class Party{
		public function getAll(){
			$qry = $GLOBALS["db"]->prepare("SELECT id, name, code FROM parties");
			$qry->execute();
			$res = $qry->fetchAll(PDO::FETCH_ASSOC);
			$r = [];
			foreach ($res as $v) {
				$p = [
					'id' => $v['id'],
					'name' =>  $v['name'],
					'code' => $v["code"]
				];
				array_push($r, $p);
			}
			return $r;
		}

		public function getInfo($id){
			$qry = $GLOBALS["db"]->prepare("SELECT * FROM parties WHERE id = :id LIMIT 1");
			$qry->execute([":id" => $id]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);
			if(!@isset($res["id"])){
				return [false];
			}
			$res['interests'] =  explode(',', $res['interests']);
			$inter = [];
			foreach($res['interests'] as $v){
				array_push($inter, $GLOBALS["interests"][(int)$v]);
			}
			$res['interests'] = $inter;
			return $res;
		}
	}
	?>