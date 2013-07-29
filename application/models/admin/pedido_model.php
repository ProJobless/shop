<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Pedido_model extends CI_Model {

		function guardarnosurtido($post,$editar=false){

			//print_r($post['nosurtido']);
			$idpedido = $post['nopedido'];

			//Buscar si hay un pedido ya insertado
			$q = $this->db->get_where('contenidonosurtido',array('pedido_idpedido'=>$idpedido));

			if($q->num_rows() > 0){
				foreach($post['nosurtido'] as $key => $val){
					//echo 'hola';
					$data = array(
						'contenido_idcontenido' => $key,
						'nosurtido' => $val,
						'pedido_idpedido' => $idpedido
					);

					//echo 'arreglo';
					//print_r($data);
					$this->db->where(array('contenido_idcontenido'=>$key));
					$this->db->update('contenidonosurtido',$data);
				}

				//echo 'update';

			}else{
				foreach($post['nosurtido'] as $key => $val){
					//echo 'hola';
					$data = array(
						'contenido_idcontenido' => $key,
						'nosurtido' => $val,
						'pedido_idpedido' => $idpedido
					);

					//echo 'arreglo';
					//print_r($data);
					$this->db->insert('contenidonosurtido',$data);
				}

				//echo 'insertado';

			}
			

			//echo 'some';
			
			
		}

		function getnosurtidos($idpedido){
			$q = $this->db->get_where('contenidonosurtido',array('pedido_idpedido'=>$idpedido));
			if($q->num_rows()>0){
				$productos = $q->result_array();
				foreach($productos as $producto){
					$data[$producto['contenido_idcontenido']] = $producto['nosurtido'];
				}
			}else{
				$data[0] = 0.00;
			}

			return $data;
		}
		
		function getreporte($nopedido,$fase,$campos='*'){
			$this->db->select($campos);
			$q = $this->db->get_where('reporte',array('Pedido_idPedido'=>$nopedido,'Estado_idEstado'=>$fase));
			return $q->result_array();
		}

		function get_log_fechas($nopedido){
			$pedido1 = $this->getreporte($nopedido,1,'fecha_aut, Estado_idEstado');
			//$pedido2 = $this->getreporte($nopedido,4,'fecha_aut, Estado_idEstado');
			$pedido2 = $this->getreporte($nopedido,8,'fecha_aut, Estado_idEstado');

			if(!empty($pedido1) && !empty($pedido2)){
				print_r($pedido1);
				print_r($pedido2);
				$mayor = $pedido2[0]['fecha_aut'];
				$menor = $pedido1[0]['fecha_aut'];
				$day = $this->restar_fechas($mayor,$menor,'DAY');
				$month = $this->restar_fechas($mayor,$menor,'MONTH');
				$year = $this->restar_fechas($mayor,$menor,'YEAR');
				$hora = $this->restar_fechas($mayor,$menor,'HOUR');
				$minuto = $this->restar_fechas($mayor,$menor,'MINUTE');
				$segundo = $this->restar_fechas($mayor,$menor,'SECOND');

				$domingos = $this->domingos($mayor,$menor);

				$day = abs($day);
				$hora = abs($hora);
				$minuto = abs($minuto);
				$segundo = abs($segundo);

				$day = $day - $domingos;
				$hora = $hora - ($domingos*24) - ($day*24);
				$minuto = $minuto - ($domingos*24*60) - ($hora*60) - ($day*24*60);
				$segundo = $segundo - ($domingos*24*60*60) - ($minuto*60) - ($hora*60*60) - ($day*24*60*60);

				echo 'segundo: '.$segundo.'minuto: '.$minuto.'hora: '.$hora.'dia: '.$day.' mes: '.$month.'año: '.$year;

				
			}


		}

		function get_diferencia($mayor,$menor){
			/*$mayor = $pedido2[0]['fecha_aut'];
			$menor = $pedido1[0]['fecha_aut'];*/
			$day = $this->restar_fechas($mayor,$menor,'DAY');
			//$month = $this->restar_fechas($mayor,$menor,'MONTH');
			//$year = $this->restar_fechas($mayor,$menor,'YEAR');
			$hora = $this->restar_fechas($mayor,$menor,'HOUR');
			$minuto = $this->restar_fechas($mayor,$menor,'MINUTE');
			$segundo = $this->restar_fechas($mayor,$menor,'SECOND');

			$domingos = $this->domingos($mayor,$menor);

			$day = abs($day);
			$hora = abs($hora);
			$minuto = abs($minuto);
			$segundo = abs($segundo);

			$day = $day - $domingos;
			$hora = $hora - ($domingos*24) - ($day*24);
			$minuto = $minuto - ($domingos*24*60) - ($hora*60) - ($day*24*60);
			$segundo = $segundo - ($domingos*24*60*60) - ($minuto*60) - ($hora*60*60) - ($day*24*60*60);

			$last = abs($day).' Días '.abs($hora).' Horas '.abs($minuto).' Minutos y '.abs($segundo).' Segundos';
			//$last = abs($verdadera_resta).' Días '.(abs($verdadera_resta) - $dia_seg).' Horas '.(abs($verdadera_resta) - $dia_seg - $hora_seg).' Minutos y '.(abs($verdadera_resta) - $dia_seg - $hora_seg - $minuto_seg).' Segundos';
			return $last;

		}
		

		function restar_fechas($mayor,$menor,$tiempo){
			$q = $this->db->query("SELECT TIMESTAMPDIFF(".$tiempo.",'".$mayor."','".$menor."') as resultado;");
			$tmp = $q->result_array();
			return $tmp[0]['resultado'];
		}

		function domingos($mayor,$menor){
			$fecha_uno = date('Y-m-d',strtotime($menor));
				$fecha_dos = date('Y-m-d',strtotime($mayor));
				$uno = explode('-',$fecha_uno);
				$dos = explode('-',$fecha_dos);

				$dia1 = explode(' ',$uno[2]);
				$dia2 = explode(' ',$dos[2]);
				$coincidencia = 0;
				for($i = $uno[0]; $i <= $dos[0]; $i++){

					
					$bisiesto = date('L',strtotime($dos[0]));

					for($j = $uno[1]; $j <= $dos[1]; $j++){

						
						$limit = ($j == 2 && $bisiesto == 1) ? 29 : ( ($j == 2) ? 28 : ( ($j == 1 || $j == 3 || $j == 5 || $j == 7 || $j == 8 || $j == 10 || $j == 12) ? 31 : 30 ) );

						for($k = 1; $k <= $limit; $k++){

								if( ($dia1[0] == $dia2[0]) && ($uno[1] == $dos[1])  ){
									//echo 'zero if ';
									if(($k == $dia1[0])){
										$dias[] = $i.'-'.$j.'-'.$k;
									}
									
									$coincidencia = 1;
									
								}elseif( ($dia1[0] != $dia2[0]) && ($uno[1] == $dos[1]) ){

									if( ($k >= $dia1[0]) && ($k <= $dia2[0]) ){
										$dias[] = $i.'-'.$j.'-'.$k;
									}
									
								
								}elseif( ($j == $uno[1]) && ($k>=$dia1[0]) ){
									//echo 'primer if ';
									$dias[] = $i.'-'.$j.'-'.$k;
								}elseif( ($j == $dos[1]) && ($k<=$dia2[0])  ){
									//echo 'segundo if ';
									$dias[] = $i.'-'.$j.'-'.$k;
								}elseif( ($j > $uno[1]) && ($j < $dos[1]) ){
									//echo 'ultimo if';
									$dias[] = $i.'-'.$j.'-'.$k;
								}
								
							
							

						}

					}

				}
				$domingos = 0;
				foreach($dias as $dia){
					/*echo strtotime($dia);
					echo "\n";
					echo date('Y-m-d',strtotime($dia));
					echo "\n";
					echo date('D',strtotime($dia));/*/
					$day = date('D',strtotime($dia));
					
					if( $day == 'Sun'){
						//echo "\nSUN".date('Y-m-d',$dia);
						$domingos++;
						
					}
				}

				return $domingos;
		}
		function dummie(){
			echo 'dummie';
		}
		
		
	}
?>