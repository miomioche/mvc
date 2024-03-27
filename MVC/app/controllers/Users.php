<?php

class Users extends Controller {
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
       
    }

    public function register() {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $data = [
                'name' => trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS)),
                'email' => trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),

                'name_error' => '', 
                'email_error' => '', 
                'password_error' => '', 
                'confirmPassword_error' => ''
            ];

            // Vérification du nom
            if(empty($data['name']))
                $data['name_error'] = 'Veuillez entrer votre nom';

            // Vérification de l'email
            if(empty($data['email']))
                $data['email_error'] = 'Veuillez entrer votre email';
            else
            {
                if(!filter_var($data['email'], FILTER_SANITIZE_EMAIL))
                    $data['email_error'] = 'Le format de votre email est invalide';
                
                if($this->userModel->findUserByEmail($data['email']))
                    $data['email_error'] = 'L\'email est déjà utilisé';
            }

            // Vérification du mot de passe
            if(empty($data['password']))
                $data['password_error'] = 'Veuillez entrer votre password';

            // Vérification de la confirmation du mot de passe
            if(empty($data['confirm_password']))
                $data['confirmPassword_error'] = 'Veuillez entrer votre confirmation de password';
            
            if($data['password'] != $data['confirm_password'])
                $data['confirmPassword_error'] = 'Les passwords ne correspondent pas';

            if(empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['confirmPassword_error']))
            {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Appel du model pour enregistrer un utilisateur
                if($this->userModel->register($data)){
                    redirect('users/login');
                    flash('Inscription réussie');
                }
                else{
                    flash('Une erreur est survenue', 'alert alert-danger');
                    $this->render('register', $data);
                }
            }
            else
                $this->render('register', $data);
        }
        else
            $this->render('register');
    }

    public function login() {
        $this->render('login');
    }

    public function logout() {
        $this->render('logout');
    }
}