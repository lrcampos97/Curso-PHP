<?php

namespace Ecommerce\Model;

use \Ecommerce\DB\Sql;
use \Ecommerce\Model;
use \Ecommerce\Mailer;


class Category extends Model {

    public  function __construct($idcategory = 0){
        if ($idcategory !== 0){
            $this->get($idcategory);    
        }
    }

    public static function listAll(){
        
        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_categories ORDER BY descategory"); 
    }


    public static function updateView(){

        $categories = Category::listAll();

        $html = []; // montar o html com as categorias

        foreach ($categories as $value) {
            array_push($html, '<li><a href="/categories/'. $value["idcategory"] .'">'. $value["descategory"] . '</a></li>' );
        }

        file_put_contents($_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "categories-menu.html", implode('', $html)); // incluir o HTML no arquivo        
    }

    public function get($idcategory){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_categories cat WHERE cat.idcategory = :idcategory", array(
            ":idcategory"=>$idcategory
        ));

        $this->setData($results[0]);
    }


    public function delete(){

        $sql = new Sql();

        $sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory",array(
            ":idcategory"=>$this->getidcategory()
        ));

        Category::updateView();
    }   

    public function save(){
        
        $sql = new Sql();


        $results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", array(
            ":idcategory"=> $this->getidcategory(), // ESTES MÉTODOS SÃO GERADOS DE FORMA AUTOMATICA PELA CLASSE MODEL
            ":descategory"=> $this->getdescategory()
        ));

        $this->setData($results[0]);

        Category::updateView();
    }    

}