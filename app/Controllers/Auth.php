<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Libraries\Hash;

class Auth extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }
    public function index()
    {
        $data = [
            'title' => 'The Wardrobe (login)',
        ];
        echo view('templates/header', $data);
        echo view('auth/login', $data);
    }
    public function register()
    {
        $data = [
            'title' => 'The Wardrobe (register)',
        ];
        echo view('templates/header', $data);
        echo view('auth/register', $data);
    }
    public function save()
    {
        //validating requests
        // $validation = $this->validate([
        //         'firstname'=>'required',
        //         'lastname'=>'required',
        //         'email'=>'required|valid_email|is_unique[tbl_users.email]',
        //         'gender'=>'required',
        //         'password'=>'required|min_length[6]|max_length[15]',
        //         'cpassword'=>'required|min_length[6]|max_length[15]|matches[password]'

        // ]);

    //     $validation = $this->validate([
    //         'firstname'=>[
    //             'rules'=>'required',
    //             'errors'=>[
    //                 'required'=>'Your first name is required'
    //             ]
    //             ],
    //             'lastname'=>[
    //                 'rules'=>'required',
    //                 'errors'=>[
    //                     'required'=>'Your last name is required'
    //                 ]
    //                 ],
    
    //         'email'=>[
    //             'rules'=>'required|valid_email|is_unique[users.email]',
    //             'errors'=>[
    //                 'required'=>'Your correct email is required',
    //                 'valid_email'=>'You must enter a valid email',
    //                 'is_unique'=>'Email already exists'
    //             ]
    //             ],
    //         'password'=>[
    //             'rules'=>'required|min_length[6]|max_length[15]',
    //             'errors'=>[
    //                 'required'=>'Password is required',
    //                 'min_length'=>'Password must have atleast 6 characters in length',
    //                 'max_length'=>'Maximum password length is 15'
    //             ]
    //             ],
    //         'cpassword'=>[
    //             'rules'=>'required|min_length[6]|max_length[15]|matches[password]',
    //             'errors'=>[
    //                 'required'=>'Confirm password is required',
    //                 'min_length'=>' Confirm Password must have atleast 6 characters in length',
    //                 'max_length'=>'Maximum password length is 15',
    //                 'matches'=>'Confirm password does not match the password'
    //             ]
    //             ],
    //             'gender'=>[
    //                 'rules'=>'required',
    //                 'errors'=>[
    //                     'required'=>'Your gender is required'
    //                 ]
    //                 ],
    
    //     ]);
    //     if(!$validation)
    //     {
    //         $data = [
    //             'title' => 'The Wardrobe (register)',
    //         ];
    //         echo view('templates/header', $data);
    //         echo view('auth/register',['validation'=>$this->validator]);
    //     }else{
    //         //register user into db
    //         $firstname= $this->request->getPost('firstname');
    //         $lastname= $this->request->getPost('lastname');
    //         $email= $this->request->getPost('email');
    //         $gender= $this->request->getPost('gender');
    //         $password= $this->request->getPost('password');

    //         $values = 
    //         [
    //             'firstname' => $firstname,
    //             'lastname' => $lastname,
    //             'email' => $email,
    //             'password' => Hash::make($password),
    //             'gender' => $gender,

    //         ];
    //         $usersModel = new \App\Models\UsersModel();
    //         $query = $usersModel->insert($values);
    //         if(!$query){
    //             return redirect()->back()->with('fail','Something went wrong');
                
    //         }else{
    //             //return  redirect()->to('register')->with('success','User registered successfully');
    //             $last_id = $usersModel->insertID();
    //             session()->set('loggedUser',$last_id);
    //             return redirect()->to('/pages');
    //         }
    //     }
        
        $usersModel = new \App\Models\UsersModel();
        $validation = \Config\Services::validation();
        $this->validate([
            'firstname'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Your first name is required'
                ]
                ],
            'lastname'=>[
                'rules'=>'required',
                'errors'=>[
                    'required'=>'Your last name is required'
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
            'cpassword'=>[
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
                        'required'=>'Your gender is required'
                ]
                ],
                'role'=>[
                    'rules'=>'required',
                    'errors'=>[
                        'required'=>'Your role is required'
                ]
                ],
    
        ]);
        if($validation->run() == FALSE){
            $errors = $validation->getErrors();
           // echo json_encode(['code'=>0, 'error'=>$errors]);
            $data = [
                'title' => 'The Wardrobe (register)',
            ];
            echo view('templates/header', $data);
            echo view('auth/register',['validation'=>$this->validator]);
        }else{
              //register user into db
            $firstname= $this->request->getPost('firstname');
            $lastname= $this->request->getPost('lastname');
            $email= $this->request->getPost('email');
            $gender= $this->request->getPost('gender');
            $password= $this->request->getPost('password');
            $role= $this->request->getPost('role');

            $values = 
            [
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email,
                'password' => Hash::make($password),
                'gender' => $gender,
                'role' => $role,

            ];
            $query = $usersModel->insert($values);

            if($query){
                echo json_encode(['code'=>1,'msg'=>'You have been registered.']);
                $last_id = $usersModel->insertID();
                session()->set('loggedUser',$last_id);
                //return  redirect()->to('register')->with('success','User registered successfully');
                 return redirect()->to('/pages');
            }else{
                echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
                return redirect()->back()->with('fail','Something went wrong');

            }
        }
    }

    function check()
    {
        //validate
        // $validation=$this->validate([
        //     'email'=>[
        //         'rules'=>'required|valid_email|is_not_unique[users.email]',
        //         'errors'=>[
        //             'required'=>'Your correct email is required',
        //             'valid_email'=>'You must enter a valid email',
        //             'is_not_unique'=>"Email user doesn't exists please register"
        //         ]
        //         ],
        //     'password'=>[
        //         'rules'=>'required|min_length[6]|max_length[15]',
        //         'errors'=>[
        //             'required'=>'Password is required',
        //             'min_length'=>'Password must have atleast 6 characters in length',
        //             'max_length'=>'Maximum password length is 15'
        //             ]
        //             ],
        // ]);
        // if(!$validation){
        //     $data = [
        //         'title' => 'The Wardrobe (login)',
        //     ];
        //     echo view('templates/header', $data);
        //     echo view('auth/login', ['validation'=>$this->validator]);
        // }else{
        //     $email= $this->request->getPost('email');
        //     $password= $this->request->getPost('password');
        //     $usersModel = new \App\Models\UsersModel();
        //     $user_info = $usersModel->where('email',$email)->first();
        //     $check_password = Hash::check($password,$user_info['password']);
        //     if(!$check_password){
        //         session()->setFlashdata('fail','incorrect password');
        //         return redirect()->to('/auth')->withInput();
        //     }else{
        //         $user_id=$user_info['user_id'];
        //         session()->set('loggedUser',$user_id);
        //         return redirect()->to('/pages');
        //     }
        // }

        $usersModel = new \App\Models\UsersModel();
        $validation = \Config\Services::validation();
        $this->validate([  

                'email'=>[
                    'rules'=>'required|valid_email|is_not_unique[tbl_users.email]',
                    'errors'=>[
                        'required'=>'Your correct email is required.',
                        'valid_email'=>'You must enter a valid email.',
                        'is_not_unique'=>'Email user does not exist please register.'
                    ]
                    ],
                'password'=>[
                    'rules'=>'required|min_length[6]|max_length[15]',
                    'errors'=>[
                        'required'=>'Password is required',
                        'min_length'=>'Password must have atleast 6 characters in length',
                        'max_length'=>'Maximum password length is 15 characters in length.'
                    ]
                    ],
        ]);
        
        if($validation->run() == FALSE){
            $errors = $validation->getErrors();
            //echo json_encode(['code'=>0, 'error'=>$errors]);
            $data = [
                'title' => 'The Wardrobe (login)',
            ];
            echo view('templates/header', $data);
            echo view('auth/login', ['validation'=>$this->validator]);
        }
        else{
            $email= $this->request->getPost('email');
            $password= $this->request->getPost('password');
            $usersModel = new \App\Models\UsersModel();
            $user_info = $usersModel->where('email',$email)->first();
            $check_password = Hash::check($password,$user_info['password']);
            if(!$check_password){
                session()->setFlashdata('fail','incorrect password');
                $errors = $validation->getErrors();
                echo json_encode(['code'=>0, 'error'=>$errors]);
                return redirect()->to('/auth')->withInput();

            }else{
                $user_id=$user_info['user_id'];
                session()->set('loggedUser',$user_id);
                return redirect()->to('/pages');
            }    
        }
    }

    public function logout(){
        if(session()->has('loggedUser')){
            session()->remove('loggedUser');
            return redirect()->to('/auth?access=out')->with('fail','You are logged out!');
            
        }
    }

}