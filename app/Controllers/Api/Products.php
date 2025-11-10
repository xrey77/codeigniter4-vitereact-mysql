<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait; 
use CodeIgniter\RESTful\ResourceController;
use App\Models\ProductModel;
use CodeIgniter\Pager\Pager;

class Products extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    public function addProduct() {
        $req = $this->request->getJSON();
        try {
            $data = [
                'category' => $req->category,
                'descriptions' => $req->descriptions,
                'qty' => $req->qty,
                'unit' => $req->unit,
                'costprice' => $req->costprice,
                'sellprice' => $req->sellprice,
                'saleprice' => $req->saleprice,
                'productpicture' => $req->productpicture,
                'alertstocks' => $req->alertstocks,
                'criticalstocks' => $req->criticalstocks
            ];

            $productModel = new ProductModel();
            $productModel->insert($data);
        } catch(\Exception $ex) {
            return $this->fail($ex->getMessage(), 400);
        }

        return $this->response->setJSON(['message' => 'New Product has been added.'],200);
    }

    public function updateProduct($id = null) {
        try {
            $data = [
                'category' => $req->category,
                'descriptions' => $req->descriptions,
                'qty' => $req->qty,
                'unit' => $req->unit,
                'costprice' => $req->costprice,
                'sellprice' => $req->sellprice,
                'saleprice' => $req->saleprice,
                'productpicture' => $req->productpicture,
                'alertstocks' => $req->alertstocks,
                'criticalstocks' => $req->criticalstocks
            ];

            $productModel = new ProductModel();
            $productModel->update($id, $data);

            return $this->response->setJSON([
                'message' => 'Product has been successfully updated.'],200);

        } catch(\Exception $ex) {
            return $this->fail($ex->getMessage(), 400);
        }
    
    }

    public function deleteProduct($id = null) {
        $productModel = new UserModel();
        $data = $productModel->find($id);
        if($data){

            $productModel->delete($id);
            return $this->response->setJSON([
                'message' => 'Product has been deleted successfully.'],200);

        } else {
            return $this->fail('User not found.', 404);
        }
    }    


    public function listProducts($page = null) {
            //OPTION 1===========================
            // $db = \Config\Database::connect();
            // $builder = $db->table('products');
        
            // $perPage = 5;
            // $offset = ($page - 1) * $perPage;

            // $query = $builder->limit($perPage, $offset)->get();
             
            // $totrecs = $builder->countAllResults();
            // $totpage = (int)ceil($totrecs / $perPage);

            // $products['products'] = $query->getResult();
            // if ($products) {
            //     $data = [
            //         'page' => (int)$page,
            //         'totpage' => $totpage,
            //         'totrecs' => $totrecs,
            //         'products' => $query->getResult()
            //     ];
            //     return $this->response->setJSON($data,200);
            // } else {
            //     return $this->fail('Products not found.', 404);            
            // }

            //OPTION 2===========================
            $db = db_connect();
            $builder = $db->table('products');
            $total = $builder->countAllResults(); // Get total count
        
            $perPage = 5;
            $pager = service('pager');
            $offset = ($page - 1) * $perPage;
            $totpage = (int)ceil($total / $perPage);
            $products = $builder->get($perPage, $offset)->getResult();
        
            $data = [
                'message' => '',
                'page' => (int)$page,
                'totpage' => $totpage,
                'totalrecs' => $total,
                'products' => $products,
                // 'pager_links' => $pager->makeLinks($page, $perPage, $total)
            ];

            return $this->response->setJSON($data,200);
        }

    public function searchProduct($key = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('products');        
        $search_term = '%' . $key . '%';        
        $builder->like('descriptions', $search_term);
        $query = $builder->get();
        $results = $query->getResult();
        if ($results) {
            return $this->response->setJSON($results,200);
        } else {
            return $this->fail('Product not found.', 404);   
        }
    }

}