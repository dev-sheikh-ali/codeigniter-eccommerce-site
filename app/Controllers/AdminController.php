<?php

namespace App\Controllers;
use App\Libraries\Hash;


class AdminController extends BaseController
{

    public function __construct(){
        helper(['url', 'form']);
        require_once APPPATH.'ThirdParty/ssp.php';
        $this->db = db_connect();
    }

    public function index()
    {
        $data['pageTitle'] = 'Home';
        return view('dashboard/home', $data);
    }

    public function profile(){
        $data['pageTitle'] = 'Profile';
        return view('dashboard/profile',$data);
    }

    // User functions

    public function users(){
        $roleModel = new \App\Models\RolesModel();
        $data['pageTitle'] = 'Users List';
        $data['role'] = $roleModel->findAll();

        return view('dashboard/users', $data);
    }

    public function addUser(){
        $userModel = new \App\Models\UsersModel();
        $validation = \Config\Services::validation();
        $this->validate([
            'firstname'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'First name is required'
                ]
                ],
            'lastname'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Last name is required'
                ]
                ],
    
            'email'=>[
                'rules'=>'required|valid_email|is_unique[tbl_users.email]',
                'errors'=>[
                    'required'=>'Your correct email is required',
                    'valid_email'=>'You must enter a valid email',
                    'is_unique'=>'Email already exists'
                ]
                ],
            'password'=>[
                'rules'=>'required|min_length[6]|max_length[15]',
                'errors'=>[
                    'required'=>'Password is required',
                    'min_length'=>'Password must have atleast 6 characters in length',
                    'max_length'=>'Maximum password length is 15'
                ]
                ],
            'confirm_password'=>[
                'rules'=>'required|min_length[6]|max_length[15]|matches[password]',
                'errors'=>[
                    'required'=>'Confirm password is required',
                    'min_length'=>' Confirm Password must have atleast 6 characters in length',
                    'max_length'=>'Maximum password length is 15',
                    'matches'=>'Confirm password does not match the password'
                ]
                ],
            'gender'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Gender is required'
                ]
                ],
            'role'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Role is required'
                ]
                ]
        ]);

        if($validation->run() == FALSE){
            $errors = $validation->getErrors();
            echo json_encode(['code'=>0, 'error'=>$errors]);
        }else{
             //Insert user data into db
             $password= $this->request->getPost('password');
             $data = [
                 'first_name'=>$this->request->getPost('firstname'),
                 'last_name'=>$this->request->getPost('lastname'),
                 'email'=>$this->request->getPost('email'),
                 'password' => Hash::make($password),
                 'gender'=>$this->request->getPost('gender'),
                 'role'=>$this->request->getPost('role'),

             ];
             $query = $userModel->insert($data);
             if($query){
                 echo json_encode(['code'=>1,'msg'=>'New user has been added.']);
             }else{
                 echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
             }
        }
    }

    public function getAllUsers(){
        //DB Details
        $dbDetails = array(
            "host"=>$this->db->hostname,
            "user"=>$this->db->username,
            "pass"=>$this->db->password,
            "db"=>$this->db->database,
        );

        $table = "tbl_users";
        $primaryKey = "user_id";

        $columns = array(
            array(
                "db"=>"user_id",
                "dt"=>0,
            ),
            array(
                "db"=>"first_name",
                "dt"=>1,
            ),
            array(
                "db"=>"last_name",
                "dt"=>2,
            ),
            array(
                "db"=>"email",
                "dt"=>3,
            ),
            array(
                "db"=>"gender",
                "dt"=>4,
            ),
            array(
                "db"=>"role",
                "dt"=>5,
            ),
            array(
                "db"=>"user_id",
                "dt"=>6,
                "formatter"=>function($d, $row){
                    return "<div class='btn-group'>
                                  <button class='btn btn-sm btn-primary' data-id='".$row['user_id']."' id='updateUserBtn'><i class='fa fa-edit'></i></button>
                                  <button class='btn btn-sm btn-danger' data-id='".$row['user_id']."' id='deleteUserBtn'><i class='fa fa-trash'></i></button>
                             </div>";
                }
            ),
        );

        echo json_encode(
            \SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }


    public function getUserInfo(){
        $userModel = new \App\Models\UsersModel();
        $user_id = $this->request->getPost('user_id');
        $info = $userModel->find($user_id);
        if($info){
            echo json_encode(['code'=>1, 'msg'=>'', 'results'=>$info]);
        }else{
            echo json_encode(['code'=>0, 'msg'=>'No results found', 'results'=>null]);
        }
    }

    public function updateUser(){
        $userModel = new \App\Models\UsersModel();
        $validation = \Config\Services::validation();
        $uid = $this->request->getPost('uid');

        $this->validate([

            'firstname'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'First name is required'
                ]
                ],
            'lastname'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Last name is required'
                ]
                ],
    
            'email'=>[
                'rules'=>'required|valid_email|is_unique[tbl_users.email,user_id,'.$uid.']',
                'errors'=>[
                    'required'=>'Your correct email is required',
                    'valid_email'=>'You must enter a valid email',
                    'is_unique'=>'Email already exists'
                ]
                ],
            'password'=>[
                'rules'=>'required|min_length[6]|max_length[15]',
                'errors'=>[
                    'required'=>'Password is required',
                    'min_length'=>'Password must have atleast 6 characters in length',
                    'max_length'=>'Maximum password length is 15'
                ]
                ],
            'confirm_password'=>[
                'rules'=>'required|min_length[6]|max_length[15]|matches[password]',
                'errors'=>[
                    'required'=>'Confirm password is required',
                    'min_length'=>' Confirm Password must have atleast 6 characters in length',
                    'max_length'=>'Maximum password length is 15',
                    'matches'=>'Confirm password does not match the password'
                ]
                ],
            'gender'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Gender is required'
                ]
                ],
            'role'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Role is required'
                ]
                ]
        ]);

        if($validation->run() == FALSE){
            $errors = $validation->getErrors();
            echo json_encode(['code'=>0,'error'=>$errors]);
        }else{
            //Update User.
            $password= $this->request->getPost('password');
            $data = [
                'first_name'=>$this->request->getPost('firstname'),
                'last_name'=>$this->request->getPost('lastname'),
                'email'=>$this->request->getPost('email'),
                'password' => Hash::make($password),
                'gender'=>$this->request->getPost('gender'),
                'role'=>$this->request->getPost('role'),
           ];
            $query = $userModel->update($uid,$data);

            if($query){
                echo json_encode(['code'=>1, 'msg'=>'User info have been updated successfully']);
            }else{
                echo json_encode(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }


    public function deleteUser(){
        $userModel = new \App\Models\UsersModel();
        $user_id = $this->request->getPost('user_id');
        $query = $userModel->delete($user_id);

        if($query){
            echo json_encode(['code'=>1,'msg'=>'User deleted Successfully']);
        }else{
            echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
        }
    }

    // Category functions

    public function categories(){
        $data['pageTitle'] = 'Categories';
        return view('dashboard/categories', $data);
    }

    public function addCategory(){
        $categoryModel = new \App\Models\CategoriesModel();
        $validation = \Config\Services::validation();
        $this->validate([
                
            'categoryname'=>[
                'rules'=>'required|is_unique[tbl_categories.category_name]',
                'errors'=>[
                    'required'=>'Category name is required',
                    'is_unique'=>'Category already exists'
                ]
                ]
        ]);

        if($validation->run() == FALSE){
            $errors = $validation->getErrors();
            echo json_encode(['code'=>0, 'error'=>$errors]);
        }else{
             //Insert category data into db
             $data = [
                 'category_name'=>$this->request->getPost('categoryname'),
             ];
             $query = $categoryModel->insert($data);
             if($query){
                 echo json_encode(['code'=>1,'msg'=>'New category has been added.']);
             }else{
                 echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
             }
        }
    }

    public function getAllCategories(){
        //DB Details
        $dbDetails = array(
            "host"=>$this->db->hostname,
            "user"=>$this->db->username,
            "pass"=>$this->db->password,
            "db"=>$this->db->database,
        );

        $table = "tbl_categories";
        $primaryKey = "category_id";

        $columns = array(
            array(
                "db"=>"category_id",
                "dt"=>0,
            ),
            array(
                "db"=>"category_name",
                "dt"=>1,
            ),
            array(
                "db"=>"category_id",
                "dt"=>2,
                "formatter"=>function($d, $row){
                    return "<div class='btn-group'>
                                  <button class='btn btn-sm btn-primary' data-id='".$row['category_id']."' id='updateCategoryBtn'><i class='fa fa-edit'></i></button>
                                  <button class='btn btn-sm btn-danger' data-id='".$row['category_id']."' id='deleteCategoryBtn'><i class='fa fa-trash'></i></button>
                             </div>";
                }
            ),
        );

        echo json_encode(
            \SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }

    public function getCategoryInfo(){
        $categoryModel = new \App\Models\CategoriesModel();
        $category_id = $this->request->getPost('category_id');
        $info = $categoryModel->find($category_id);
        if($info){
            echo json_encode(['code'=>1, 'msg'=>'', 'results'=>$info]);
        }else{
            echo json_encode(['code'=>0, 'msg'=>'No results found', 'results'=>null]);
        }
    }

    public function updateCategory(){
        $categoryModel = new \App\Models\CategoriesModel();
        $validation = \Config\Services::validation();
        $cid = $this->request->getPost('cid');

        $this->validate([

            'categoryname'=>[
                'rules'=>'required|is_unique[tbl_categories.category_name,category_id,'.$cid.']',
                'errors'=>[
                    'required'=>'Category name is required',
                    'is_unique'=>'Category already exists'
                ]
                ]
            
        ]);

        if($validation->run() == FALSE){
            $errors = $validation->getErrors();
            echo json_encode(['code'=>0,'error'=>$errors]);
        }else{
            //Update Category.
            $data = [
                'category_name'=>$this->request->getPost('categoryname'),
           ];
            $query = $categoryModel->update($cid,$data);

            if($query){
                echo json_encode(['code'=>1, 'msg'=>'Category details have been updated successfully']);
            }else{
                echo json_encode(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }


    public function deleteCategory(){
        $categoryModel = new \App\Models\CategoriesModel();
        $category_id = $this->request->getPost('category_id');
        $query = $categoryModel->delete($category_id);

        if($query){
            echo json_encode(['code'=>1,'msg'=>'Category deleted Successfully']);
        }else{
            echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
        }
    }
    
        // Sub-Category functions

        public function subcategories(){
            $categoryModel = new \App\Models\CategoriesModel();
            $data['pageTitle'] = 'Sub-Categories';
            $data['category'] = $categoryModel->findAll();

            return view('dashboard/subcategories', $data);
        }

        public function addSubCategory(){
            $subcategoryModel = new \App\Models\SubCategoriesModel();
            $validation = \Config\Services::validation();
            $this->validate([
                    
                'subcategoryname'=>[
                    'rules'=>'required|is_unique[tbl_subcategories.subcategory_name]',
                    'errors'=>[
                        'required'=>'Sub-Category name is required.',
                        'is_unique'=>'Sub-Category already exists.'
                    ]
                ],
                'category'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'category is required.'
                    ]
                ]
            ]);
    
            if($validation->run() == FALSE){
                $errors = $validation->getErrors();
                echo json_encode(['code'=>0, 'error'=>$errors]);
            }else{
                 //Insert sub-category data into db
                 $data = [
                     'subcategory_name'=>$this->request->getPost('subcategoryname'),
                     'category'=>$this->request->getPost('category'),

                 ];
                 $query = $subcategoryModel->insert($data);
                 if($query){
                     echo json_encode(['code'=>1,'msg'=>'New sub-category has been added.']);
                 }else{
                     echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
                 }
            }
        }

        public function getAllSubCategories(){
            //DB Details
            $dbDetails = array(
                "host"=>$this->db->hostname,
                "user"=>$this->db->username,
                "pass"=>$this->db->password,
                "db"=>$this->db->database,
            );
    
            $table = "tbl_subcategories";
            $primaryKey = "subcategory_id";
    
            $columns = array(
                array(
                    "db"=>"subcategory_id",
                    "dt"=>0,
                ),
                array(
                    "db"=>"subcategory_name",
                    "dt"=>1,
                ),
                array(
                    "db"=>"category",
                    "dt"=>2,
                ),
                array(
                    "db"=>"subcategory_id",
                    "dt"=>3,
                    "formatter"=>function($d, $row){
                        return "<div class='btn-group'>
                                      <button class='btn btn-sm btn-primary' data-id='".$row['subcategory_id']."' id='updateSubCategoryBtn'><i class='fa fa-edit'></i></button>
                                      <button class='btn btn-sm btn-danger' data-id='".$row['subcategory_id']."' id='deleteSubCategoryBtn'><i class='fa fa-trash'></i></button>
                                 </div>";
                    }
                ),
            );
    
            echo json_encode(
                \SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
            );
        }

        public function getSubCategoryInfo(){
            $subcategoryModel = new \App\Models\SubCategoriesModel();
            $subcategory_id = $this->request->getPost('subcategory_id');
            $info = $subcategoryModel->find($subcategory_id);
            if($info){
                echo json_encode(['code'=>1, 'msg'=>'', 'results'=>$info]);
            }else{
                echo json_encode(['code'=>0, 'msg'=>'No results found', 'results'=>null]);
            }
        } 

        public function updateSubCategory(){
            $subcategoryModel = new \App\Models\SubCategoriesModel();
            $validation = \Config\Services::validation();
            $scid = $this->request->getPost('scid');
    
            $this->validate([
    
                'subcategoryname'=>[
                    'rules'=>'required|is_unique[tbl_subcategories.subcategory_name,subcategory_id,'.$scid.']',
                    'errors'=>[
                        'required'=>'Sub-Category name is required.',
                        'is_unique'=>'Sub-Category already exists.'
                    ]
                    ],
                'category'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'category is required.'
                    ]
                ]
                
            ]);
    
            if($validation->run() == FALSE){
                $errors = $validation->getErrors();
                echo json_encode(['code'=>0,'error'=>$errors]);
            }else{
                //Update Sub-Category.
                $data = [
                    'subcategory_name'=>$this->request->getPost('subcategoryname'),
                    'category'=>$this->request->getPost('category'),
               ];
                $query = $subcategoryModel->update($scid,$data);
    
                if($query){
                    echo json_encode(['code'=>1, 'msg'=>'Sub-Category details have been updated successfully']);
                }else{
                    echo json_encode(['code'=>0, 'msg'=>'Something went wrong']);
                }
            }
        }
    
    
        public function deleteSubCategory(){
            $subcategoryModel = new \App\Models\SubCategoriesModel();
            $subcategory_id = $this->request->getPost('subcategory_id');
            $query = $subcategoryModel->delete($subcategory_id);
    
            if($query){
                echo json_encode(['code'=>1,'msg'=>'Sub-Category deleted Successfully']);
            }else{
                echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
            }
        }

        // Payment Type functions.

        public function paymenttypes(){
            $paymenttypeModel = new \App\Models\PaymenttypesModel();
            $data['pageTitle'] = 'Payment types';

            return view('dashboard/paymenttypes', $data);
        }

        public function addPaymenttype(){
            $paymenttypeModel = new \App\Models\PaymenttypesModel();
            $validation = \Config\Services::validation();
            $this->validate([
                    
                'paymenttypename'=>[
                    'rules'=>'required|is_unique[tbl_paymenttypes.paymenttype_name]',
                    'errors'=>[
                        'required'=>'Payment type name is required.',
                        'is_unique'=>'Payment type already exists.'
                    ]
                ],
                'paymenttypedescription'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Payment Type is required.'
                    ]
                ]
            ]);
    
            if($validation->run() == FALSE){
                $errors = $validation->getErrors();
                echo json_encode(['code'=>0, 'error'=>$errors]);
            }else{
                 //Insert payment type data into db
                 $data = [
                     'paymenttype_name'=>$this->request->getPost('paymenttypename'),
                     'description'=>$this->request->getPost('paymenttypedescription'),
                 ];
                 $query = $paymenttypeModel->insert($data);
                 if($query){
                     echo json_encode(['code'=>1,'msg'=>'New payment type has been added.']);
                 }else{
                     echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
                 }
            }
        }

        public function getAllPaymenttypes(){
            //DB Details
            $dbDetails = array(
                "host"=>$this->db->hostname,
                "user"=>$this->db->username,
                "pass"=>$this->db->password,
                "db"=>$this->db->database,
            );
    
            $table = "tbl_paymenttypes";
            $primaryKey = "paymenttype_id";
    
            $columns = array(
                array(
                    "db"=>"paymenttype_id",
                    "dt"=>0,
                ),
                array(
                    "db"=>"paymenttype_name",
                    "dt"=>1,
                ),
                array(
                    "db"=>"description",
                    "dt"=>2,
                ),
                array(
                    "db"=>"paymenttype_id",
                    "dt"=>3,
                    "formatter"=>function($d, $row){
                        return "<div class='btn-group'>
                                      <button class='btn btn-sm btn-primary' data-id='".$row['paymenttype_id']."' id='updatePaymenttypeBtn'><i class='fa fa-edit'></i></button>
                                      <button class='btn btn-sm btn-danger' data-id='".$row['paymenttype_id']."' id='deletePaymenttypeBtn'><i class='fa fa-trash'></i></button>
                                 </div>";
                    }
                ),
            );
    
            echo json_encode(
                \SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
            );
        }

        public function getPaymenttypeInfo(){
            $paymenttypeModel = new \App\Models\PaymenttypesModel();
            $paymenttype_id = $this->request->getPost('paymenttype_id');
            $info = $paymenttypeModel->find($paymenttype_id);
            if($info){
                echo json_encode(['code'=>1, 'msg'=>'', 'results'=>$info]);
            }else{
                echo json_encode(['code'=>0, 'msg'=>'No results found', 'results'=>null]);
            }
        }

        public function updatePaymenttype(){
            $paymenttypeModel = new \App\Models\PaymenttypesModel();
            $validation = \Config\Services::validation();
            $ptid = $this->request->getPost('ptid');
    
            $this->validate([
    
                'paymenttypename'=>[
                    'rules'=>'required|is_unique[tbl_paymenttypes.paymenttype_name,paymenttype_id,'.$ptid.']',
                    'errors'=>[
                        'required'=>'Payment type name is required.',
                        'is_unique'=>'Payment type already exists.'
                    ]
                    ],
                'paymenttypedescription'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Payment type is required.'
                    ]
                ]
                
            ]);
    
            if($validation->run() == FALSE){
                $errors = $validation->getErrors();
                echo json_encode(['code'=>0,'error'=>$errors]);
            }else{
                //Update Payment type.
                $data = [
                    'paymenttype_name'=>$this->request->getPost('paymenttypename'),
                    'description'=>$this->request->getPost('paymenttypedescription'),
               ];
                $query = $paymenttypeModel->update($ptid,$data);
    
                if($query){
                    echo json_encode(['code'=>1, 'msg'=>'Payment type details have been updated successfully']);
                }else{
                    echo json_encode(['code'=>0, 'msg'=>'Something went wrong']);
                }
            }
        }
    
    
        public function deletePaymenttype(){
            $paymenttypeModel = new \App\Models\PaymenttypesModel();
            $paymenttype_id = $this->request->getPost('paymenttype_id');
            $query = $paymenttypeModel->delete($paymenttype_id);
    
            if($query){
                echo json_encode(['code'=>1,'msg'=>'Payment type deleted Successfully']);
            }else{
                echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
            }
        }

        public function products(){
            $subcategoryModel = new \App\Models\SubCategoriesModel();
            $data['pageTitle'] = 'Product List';
            $data['sub_category'] = $subcategoryModel->findAll();
            return view('dashboard/products', $data);
        }

        public function addProduct(){
            $productModel = new \App\Models\ProductsModel();
            $productImageModel = new \App\Models\ProductImagesModel();
            $validation = \Config\Services::validation();
            $this->validate([
                    
                'productname'=>[
                    'rules'=>'required|is_unique[tbl_product.product_name]',
                    'errors'=>[
                        'required'=>'Product name is required.',
                        'is_unique'=>'Product already exists.'
                    ]
                ],
                'productdescription'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Product description is required.'
                    ]
                ],
                'productimage'=>[
                    'rules'=>'uploaded[productimage]|is_image[productimage]',
                    'errors'=>[
                        'uploaded'=>'Image is required!',
                        'is_image'=>'Only Images allowed !'
    
                    ]
                ],
                'unitprice'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Unit price is required.'
                    ]
                ],
                'availablequantity'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Available quantity is required.'
                    ]
                ],
                'subcategory'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'subcategory is required.'
                    ]
                ],

            ]);
            if($validation->run() == FALSE){
                $errors = $validation->getErrors();
                echo json_encode(['code'=>0, 'error'=>$errors]);
            }else{
                 //Insert product data into db
                $file = $this->request->getFile('productimage');
                if($file-> isValid() && ! $file->hasMoved()){
                    $imageName = $file->getRandomName();                    
                    $file->move('admin/img/', $imageName);
                }
                 $data = [
                     'product_name'=>$this->request->getPost('productname'),
                     'product_description'=>$this->request->getPost('productdescription'),
                     'product_image'=>$imageName,
                     'unit_price'=>$this->request->getPost('unitprice'),
                     'available_quantity'=>$this->request->getPost('availablequantity'),
                     'subcategory_id'=>$this->request->getPost('subcategory'),
                     'created_at'=>date("Y-m-d H:i:s"),
                     'added_by'=>6,
                 ];
                 $query = $productModel->insert($data);
                 if($query){
                    $productId =  $productModel->insertID();
                     $values = [ 
                        'product_image'=>$imageName,
                        'product_id'=>$productId,
                        'created_at'=>date("Y-m-d H:i:s"),
                        'added_by'=>6,
                    ];
                    $query2 = $productImageModel->insert($values);
                    if($query2){
                          echo json_encode(['code'=>1,'msg'=>'New payment type has been added.']);
                    }else{
                        echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
                    }
                 }else{
                     echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
                 }
            }




        }
        




    
}