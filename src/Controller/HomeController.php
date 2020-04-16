<?php

namespace App\Controller;

use App\Model\CategorieManager;
use App\Model\CommentManager;
use App\Model\MagicienManager;
use App\Model\PotionManager;

class HomeController extends AbstractController
{
    public function index(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $magicienManager = new MagicienManager;
            $login = ['email' => $_POST['email'], 'password' => $_POST['password']];
            $result = $magicienManager->checkMagicienConnection($login);
            if (!empty($result)){
                $_SESSION['is_connected'] = true;
                $_SESSION['user'] = [
                    'id' => $result['id'],
                    'email' => $result['email'],
                    'role' => 'user'
                ];
                header('Location: http://localhost:8000/home/shop');
            }
        }
        return $this->twig->render('Home/index.html.twig');
    }

    public function shop($id = null)
    {
        $messages = [];
        if(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] === true){
            $categManager = new CategorieManager;
            $categorie = $categManager->selectAll();
            
            if($id != null){
                $potionManager = new PotionManager;
                $potions = $potionManager->selectByCategory(intval($id));
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    if(isset($_POST['like'])){
                        $this->like($_POST['id']);
                        $_POST = array();
                        $messages['like'] = "You liked this potion";
                    }
                    if(isset($_POST['comment'])){
                        $this->postComment($_POST);
                        $_POST = array();
                        $messages['comment'] = "Your comment have been post with success, thanks !";
                    }
                    if(isset($_POST['add_shop'])){
                        $this->addToBasket($_POST);
                        $_POST = array();
                        $messages['add_shop'] = "You added a potion on your basket";
                    }
                }
                return $this->twig->render('Shop/index.html.twig', [
                    'potions' => $potions,
                    'categorie' => $categorie,
                    'session' => $_SESSION
                    ]);
                }

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if(isset($_POST['like'])){
                    $this->like($_POST['id']);
                    $_POST = array();
                    $messages['like'] = "You liked this potion";
                }
                if(isset($_POST['comment'])){
                    $this->postComment($_POST);
                    $_POST = array();
                    $messages['comment'] = "Your comment have been post with success, thanks !";
                }
                if(isset($_POST['add_shop'])){
                    $this->addToBasket($_POST);
                    $_POST = array();
                    $messages['add_shop'] = "You added a potion on your basket";
                }
            }

            $potionManager = new PotionManager;
            $potions = $potionManager->selectAllOrdered();
            return $this->twig->render('Shop/index.html.twig', [
                'messages' => $messages,
                'potions' => $potions,
                'categorie' => $categorie,
                'session' => $_SESSION
            ]);

        }
        header('Location: http://localhost:8000/');
    }

    public function addToBasket($form){
        $panier = [];
        $post = [
            'id' => intval($form['id']),
            'qty' => intval($form['qty'])
        ];
        if(empty($_SESSION['panier'])){
            array_push($panier, $post);
        } else {
            // Recup session_panier dans panier
            foreach($_SESSION['panier'] as $item){
                array_push($panier, $item);
            }
            // recup d'un tableau d'id des produits presents dans le panier
            $ids = [];
            foreach($panier as $field){
                $ids[] = $field['id'];
            }
            // si id n'existe pas j'ajoute au panier
            if(!in_array($post['id'], $ids)){
                array_push($panier, $post);
            }
            // sinon je mets a jour la quantité de l'id qui existe déjà
            else {
                foreach($panier as $key => $field){        
                    if($field['id'] === $post['id']){
                        $field['qty'] += $post['qty'];
                        array_push($panier, $field);
                        unset($panier[array_search($key, $panier)]);
                    } 
                }
                array_slice($panier, 0, 5);
            } 
        }
        // je termine par mettre a jour le session_panier
        $_SESSION['panier'] = $panier;
    }

    public function logout(){
        session_unset();
        session_destroy();
        header('Location: http://localhost:8000/');
    }

    public function basket(){
        $potionManager = new PotionManager;

        $currentPanier = $_SESSION['panier'];
        $panier = [];
        $total = 0;
        foreach($currentPanier as $item){
            $potion = $potionManager->selectOneById($item['id']);
            $panier[] = [
                'id' => $item['id'],
                'name' => $potion['name'],
                'qty' => $item['qty'],
                'price' =>  $potion['price'],
                'total' => intval($potion['price']) * $item['qty']
            ];
        }
        foreach($panier as $item){
            $total += $item['total'];
        }
        return $this->twig->render('Shop/panier.html.twig', [
            'session' => $_SESSION, 
            'panier' => $panier,
            'total' => $total
        ]);
    }

    public function success(){
        $_SESSION['panier'] = [];
        return $this->twig->render('Shop/success.html.twig', [
            'session' => $_SESSION
        ]);
    }

    public function like($id){
        $potionManager = new PotionManager;
        $potion = $potionManager->updateScore(intval($id));
    }

    public function postComment($form){
        $potionManager = new PotionManager;
        $potionManager->postComment($form);
    }

    public function potion($id)
    {
        $messages = [];
        if(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] === true){
            
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                if(isset($_POST['like'])){
                    $this->like($_POST['id']);
                    $_POST = array();
                    $messages['like'] = "You liked this potion";
                }
                if(isset($_POST['comment'])){
                    $this->postComment($_POST);
                    $_POST = array();
                    $messages['comment'] = "Your comment have been post with success, thanks !";
                }
                if(isset($_POST['add_shop'])){
                    $this->addToBasket($_POST);
                    $_POST = array();
                    $messages['add_shop'] = "You added a potion on your basket";
                }
            }

            $potionManager = new PotionManager;
            $potion = $potionManager->selectOneById(intval($id));
            $commentManager = new CommentManager;
            $comments = $commentManager->selectAllById($id);
            return $this->twig->render('Shop/show.html.twig', [
                'messages' => $messages,
                'potion' => $potion,
                'comments' => $comments,
                'session' => $_SESSION
            ]);

        }
        header('Location: http://localhost:8000/');
    }
}
