<?php namespace App\Controllers;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Controller\BaseController;

class Jsondata extends \CodeIgniter\Controller
{
	protected $session;
	protected $request;

  function __construct(RequestInterface $request)
  {
			$this->session = session();
			$this->now = date('Y-m-d H:i:s');
			$this->request = $request;
			$this->logged = $this->session->get('logged_in');
			$this->data = array(
				'version' => \CodeIgniter\CodeIgniter::CI_VERSION,
				// 'baseURL' => BASE.'/public',
				'baseURL' => BASE,
				'userid' => $this->session->get('user_id'),
				'username' => $this->session->get('username'),
				'id' => $this->session->get('id'),
				'role' => $this->session->get('role'),
				'id_provinsi' => $this->session->get('id_provinsi'),
				'provinsi' => $this->session->get('provinsi'),
				'rolename' => $this->session->get('rolename'),
				'logged_in' => $this->session->get('logged_in'),
			);
  }

  public function getallproduk()
  {
	  try {
		  $request	= $this->request;
		  $param	= $request->getVar('param');
		  $produkmodel = new \App\Models\ProdukModel();
		  $data = $produkmodel->getproduk();
		  
		  if($data){
			  $response = [
				  'status'   => 'sukses',
				  'code'     => 200,
				  'data' 	 => $data
			  ];
		  }else{
			  $response = [
				  'status'   => 'gagal',
				  'code'     => '0',
				  'data'     => 'tidak ada data',
			  ];
		  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	  exit;
	  } catch (\Exception $e) {
		  die($e->getMessage());
	  }
  }

  public function getharianterjual()
  {
	  try {
		  $request	= $this->request;
		  $date	= $request->getVar('date');
		  $produkmodel = new \App\Models\ProdukModel();
		  $data = $produkmodel->getharianterjual($date);
		  
		  if($data){
			  $response = [
				  'status'   => 'sukses',
				  'code'     => 200,
				  'data' 	 => $data
			  ];
		  }else{
			  $response = [
				  'status'   => 'gagal',
				  'code'     => '0',
				  'data'     => 'tidak ada data',
			  ];
		  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	  exit;
	  } catch (\Exception $e) {
		  die($e->getMessage());
	  }
  }

  public function menjualproduk()
  {
	  try {
		  $request	= $this->request;
		  $id		= $request->getVar('id');
		  $harga	= $request->getVar('harga');
		  $qty		= 1;

		  $produkmodel = new \App\Models\ProdukModel();
		  $data = [
			'id_produk' 	=> $id,	
			'qty' 			=> 1,	
			'create_date' 	=> $this->now,
			'create_by' 	=> $this->session->get('id'),
		  ];

		$produkmodel->insertproduk($data);
		  
		  if($data){
			  $response = [
				  'status'   => 'sukses',
				  'code'     => 200,
				  'data' 	 => $data
			  ];
		  }else{
			  $response = [
				  'status'   => 'gagal',
				  'code'     => '0',
				  'data'     => 'tidak ada data',
			  ];
		  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	  exit;
	  } catch (\Exception $e) {
		  die($e->getMessage());
	  }
  }

  public function getalluser()
  {
	  try {
		  $request	= $this->request;
		  $param	= $request->getVar('param');
		  $user = new \App\Models\UserModel();
		  $data = $user->getUsers($param);
		  
		  if($data){
			  $response = [
				  'status'   => 'sukses',
				  'code'     => 200,
				  'data' 	 => $data
			  ];
		  }else{
			  $response = [
				  'status'   => 'gagal',
				  'code'     => '0',
				  'data'     => 'tidak ada data',
			  ];
		  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	  exit;
	  } catch (\Exception $e) {
		  die($e->getMessage());
	  }
  }

  public function getuser()
  {
	  try {
		  $request	= $this->request;
		  $param 	= $request->getVar('param');
		
		  $user = new \App\Models\UserModel();
		  if($param){
		  	$data = $user->getWhere(['m_user_simponi.id_usersim' => $request->getVar('id')], $param)->getRow();
		  }else{
		  	$data = $user->getWhere(['m_user.id' => $request->getVar('id')])->getRow();
		  }
		  
		  if($data){
			  $response = [
				  'status'   => 'sukses',
				  'code'     => 200,
				  'data' 	 => $data
			  ];
		  }else{
			  $response = [
				  'status'   => 'gagal',
				  'code'     => '0',
				  'data'     => 'tidak ada data',
			  ];
		  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	  exit;
	  } catch (\Exception $e) {
		  die($e->getMessage());
	  }
  }

  public function adduser()
  {
	try {
		$request		= $this->request;
		$param		= $request->getVar('param');
		
		$method			= $request->getMethod();
		$user = new \App\Models\UserModel();

		if($method == 'post'){
				
				if($request->getVar('id')){
					$data = [
						'name' 		=> $request->getVar('name'),	
						'email' 		=> $request->getVar('email'),	
						'username' 		=> $request->getVar('username'),	
						'id_role' 		=> $request->getVar('id_role'),
						'status' 		=> 1,
						'update_date' 	=> $this->now,
						'update_by' 	=> $this->session->get('id')
					];
					
					if($request->getVar('password')){
						$data['password'] = md5($request->getVar('password'));
					}
					
					$user->update($request->getVar('id'), $data);
					
				}else{
					$data = [
						'name' 			=> $request->getVar('name'),	
						'email' 		=> $request->getVar('email'),	
						'username' 		=> $request->getVar('username'),	
						'password' 		=> md5($request->getVar('password')),
						'id_role' 		=> $request->getVar('id_role'),
						'status' 		=> 1,
						'create_date' 	=> $this->now,
						'update_date' 	=> $this->now,
						'create_by' 	=> $this->session->get('id'),
						'update_by' 	=> $this->session->get('id')
					];
					$user->insert($data);
				}
		}
		redirect('user','refresh');
	} catch (\Exception $e) {
		die($e->getMessage());
	}
  }

  public function deleteuser()
  {
	try {
		$request		= $this->request;
		$param		= $request->getVar('param');
		$method			= $request->getMethod();
		$user = new \App\Models\UserModel();

		$user->deleteUser($request->getVar('id'));
		
		$response = [
			'status'   => 'success',
			'code'     => 200,
		];

		header('Content-Type: application/json');
		echo json_encode($response);
		exit;
	} catch (\Exception $e) {
		die($e->getMessage());
	}
  }

  public function getlog()
  {
	  try {
		  $request	= $this->request;

		  $log = new \App\Models\LogModel();
		  $data = $log->getLogs($request->getVar('length'), $request->getVar('start'), $request->getVar('search'));
		  $count = $log->countLogs($request->getVar('search'));
		  
		  if($data){
			  $response = [
					'status'   => 'sukses',
					'code'     => 200,
					// 'draw' 		=> $request->getPost('draw'),
					'recordsTotal' => $count,
					// 'recordsFiltered' => $datatable->countFiltered(),
					'data' => $data
			  ];
		  }else{
			  $response = [
				  'status'   => 'gagal',
				  'code'     => '0',
				  'data'     => [],
			  ];
		  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	  exit;
	  } catch (\Exception $e) {
		  die($e->getMessage());
	  }
  }

  

}
