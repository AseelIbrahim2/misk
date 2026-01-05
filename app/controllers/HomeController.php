<?php  

class HomeController extends Controller{

 


    public function index()
    {
      
        $users = User::all();

        echo '<pre>';
        print_r($users->toArray());

    }

    public function create($username='',$email=''){
            User::create([
            'username'=>$username,
            'email'=>$email

        ]);


    }

   
}


