<?php 
	class Event{
		public function getPartyEvents($id){
			$qry = $GLOBALS["db"]->prepare("SELECT * FROM events WHERE party = :pid");			
			$qry->execute([":pid" => $id]);
			$e = $qry->fetchAll(PDO::FETCH_ASSOC);

			$qry = $GLOBALS["db"]->prepare("SELECT interests, code FROM parties WHERE id = :pid");			
			$qry->execute([":pid" => $id]);
			$res = $qry->fetch(PDO::FETCH_ASSOC);
			$i = $res["interests"];
			$code = $res["code"];
			
			$i = explode(',', $i);
			
			foreach ($i as $k => $v) {
				$i[$k] = $GLOBALS['interests'][(int)$v];
			}
			foreach ($e as $k => $v) {
				$e[$k]['interests'] = $i;
				$e[$k]['code'] = $code;
			}			

			return $e;
		}

		public function getInterestEvents($id){
			$qry = $GLOBALS["db"]->prepare("SELECT events.*, parties.interests, parties.code FROM parties INNER JOIN events ON parties.id = events.party WHERE parties.interests LIKE :inter");			
			$qry->execute([":inter" => '%'.$id.'%']);
			
			$e = $qry->fetchAll(PDO::FETCH_ASSOC);
			
			return $e;
		}

		public function genHTML($e){
			$html = '<div class="event">';
			$html .= '<h3>'.$e['heading'].'</h3>';
			$html .= '<div class="event-info event-party"> <span class="event-info-label">Party</span> '.$e['code'].' </div>';
			$html .= '<div class="event-info event-orator"> <span class="event-info-label">Orator</span> '.$e["orator"].' </div>';
			$html .= '<div class="event-location"><span class="event-info-label">Location</span>'.$e["location"].'</div>';
			$html .= '<div class="event-info event-contro"> <span class="event-info-label">Controversy</span> <b>'.$e["controversy"].'</b> / 100 </div>';
			
			if($e["stand"] > 0){
				$html .= '<div class="event-info event-stand"> <span class="event-info-label">Stand</span> <b>'.$e['stand'].'</b> / 10 <span class="event-right">Rightist</span></div>';
			}else if($e["stand"] < 0){
				$html .= '<div class="event-info event-stand"> <span class="event-info-label">Stand</span> <b>'.abs($e['stand']).'</b> / 10 <span class="event-left">Leftist</span></div>';
			}else{
				$html .= '<div class="event-info event-stand"> <span class="event-info-label">Stand</span> <span class="event-neutral">Neutral</span></div>';
			}
						
			$html .= '<div class="event-text">'.$e['text'].'</div></div>';			
			
			return $html;
		}
	}
?>