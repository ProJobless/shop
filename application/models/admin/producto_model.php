<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Producto_model extends CI_Model {

		function subir_lista(){
                        $upload =  ($_SERVER['HTTP_HOST'] == 'localhost:8080') ? 'tecnoadmin' : 'admin';
                        $config['upload_path'] = $_SERVER['DOCUMENT_ROOT'].'/'.$upload.'/files/';
                        //echo $config['upload_path'];
			$config['allowed_types'] = 'csv';
			$config['max_size']	= '2048';
			$config['file_name'] = 'lista_productos';
			$config['overwrite'] = TRUE;
                        
                        //print_r($config);
                        //print_r($_FILES);
			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload('archivo'))
			{
				$data['success'] = 'error';
                                $data['resultado'] = $this->upload->display_errors();
                                $data['detalles'] = NULL;
                                //echo 'bad';
				
			}
			else
			{
                                $data['success'] = 'acierto';
				$data['resultado'] = 'La lista se ha subido correctamente';
                                $tmp = $this->upload->data();
                                $data['detalles'] = $this->actualiza_presentaciones($tmp['raw_name']);
                                //echo 'cool';
                                /*
                                $tmp = $this->upload->data();
                                print_r($tmp);
                                break;
                                */
			}
                        //break;
                        return $data;
                }
                
                function actualiza_presentaciones($nombre_archivo){
                    $this->load->library('CSVReader');
                    $filePath = "files/$nombre_archivo.csv";
                    $csvdata = $this->csvreader->parse_file($filePath);
                    $data['procesados'] = 0;
                    $data['actualizados'] = 0;
                    $data['rechazados'] = 0;
                    
                    foreach($csvdata as $cs){
                        $search_clave = array_key_exists('clave', $cs);
                        //$search_iva = array_key_exists('iva', $cs);
                        $search_precio = array_key_exists('precio', $cs);
                        
                        if($search_clave == TRUE && /*$search_iva == TRUE &&*/ $search_precio == TRUE){
                            $data['mensaje'] = 'Archivo con encabezados correctos';
                            
                            $clave = trim($cs['clave']);
                            $tamano = strlen($clave);
                            $clave_ok = ($tamano == 3) ? '0'.$clave : $clave;
                            $search_producto = $this->buscar_clave($clave_ok);
                            $verifica_precio = is_numeric(trim($cs['precio']));
                            
                            if($search_producto == TRUE && $verifica_precio == TRUE){
                                //$data['aceptados'][] = $cs;
                                $update = array(
                                   //'iva' => trim($cs['iva']), 
                                   'precio_publico' => trim($cs['precio'])  
                                );
                                
                                $this->db->where(array('clave'=>$clave_ok));
                                $this->db->update('presentacion',$update);
                                //$data['updated'][] = $cs;
                                $data['actualizados']++;
                            }else{
                                $cs['error_detalle'] = ($search_producto == FALSE) ? 'producto no existe' : (($verifica_precio == FALSE) ? 'Precio no numérico' : '');  
                                $data['rejected'][] = $cs;
                                $data['rechazados']++;
                            }
                        }else{
                            $data['mensaje'] = 'El archivo no contiene los encabezados correctos.';
                            $data['rejected'][] = NULL;
                            break;
                        }
                       
                        $data['procesados']++;
                        
                    }
                    return $data;
                    //print_r($csvdata);
                }
                
                function buscar_clave($clave){
                    $q = $this->db->get_where('presentacion',array('clave'=>$clave));
                    if($q->num_rows == 0){
                        return FALSE;
                    }elseif($q->num_rows==1){
                        return TRUE;
                    }else{
                        return FALSE;
                    }
                }
		
		
	}
?>