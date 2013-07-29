<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Surtidor_model extends CI_Model {

		function guardarsurtidor($post,$editar=false){
			$data = array(
					'nombre' => $post['nombre']
					);
			if($editar == true){
				$this->db->where('idsurtidor', $post['id']);
				$this->db->update('surtidor', $data); 
			}else{
				$this->db->insert('surtidor',$data);
			}
			
		}

		function getsurtidor($idsurtidor=0){

			if($idsurtidor == 0){
				
				$pages=10; //Numero de registros mostrados por páginas
				$this->load->library('pagination'); //Cargamos la librería de paginación
				$config['base_url'] = base_url().'surtidor/editar/0'; // parametro base de la aplicación, si tenemos un .htaccess nos evitamos el index.php
				$config['total_rows'] = $this->totalsurtidores();    
				$config['per_page'] = $pages; 
				$config['num_links'] = 5; //Numero de links mostrados en la paginación
				$config["uri_segment"] = 4; //Para que los links en la paginación sean los correctos.
				
				$config['full_tag_open'] = '<div class="pagination"><ul>';
				$config['full_tag_close'] = '</ul></div>';
				$config['first_link'] = false;
				$config['last_link'] = false;
				$config['first_tag_open'] = '<li>';
				$config['first_tag_close'] = '</li>';
				$config['prev_link'] = '&larr; Anterior';
				$config['prev_tag_open'] = '<li class="prev">';
				$config['prev_tag_close'] = '</li>';
				$config['next_link'] = 'Siguiente &rarr;';
				$config['next_tag_open'] = '<li>';
				$config['next_tag_close'] = '</li>';
				$config['last_tag_open'] = '<li>';
				$config['last_tag_close'] = '</li>';
				$config['cur_tag_open'] =  '<li class="active"><a href="#">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li>';
				$config['num_tag_close'] = '</li>';

				$this->pagination->initialize($config); 
		 	
				$q = $this->paginarsurtidores($config['per_page'],$this->uri->segment(4));

				/*$this->db->order_by('clave');
				$q = $this->db->get_where('producto_interno',array('activo'=>'SI'));*/
			}else{
				$this->db->order_by('nombre','asc');
				$q = $this->db->get_where('surtidor',array('activo'=>'SI','idsurtidor'=>$idsurtidor));
			}
			
			return $q->result_array();
		}

		function getallsurtidores(){
			$this->db->order_by('nombre','asc');
			$q = $this->db->get_where('surtidor',array('activo'=>'SI'));
			return $q->result_array();
		}

		function borrarsurtidor($idsurtidor){

			$this->db->where('idsurtidor', $idsurtidor);
			$this->db->update('surtidor', array('activo'=>'NO')); 
		}

		function paginarsurtidores($per_page,$segment) {
			$this->db->where(array('activo'=>'SI'));
			$this->db->order_by('nombre','asc');
			$q = $this->db->get('surtidor',$per_page,$segment);
			return $q;
		}

		function totalsurtidores(){
			$q = $this->db->get_where('surtidor',array('activo'=>'SI'));
			return  $q->num_rows() ;
		}
		
		
	}
?>