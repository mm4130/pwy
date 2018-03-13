<?php
class index
{
    private $instanceModelProduit;

    public function __construct()
    {
        //include("models/account_m.php");
        //$this->instanceModelProduit = new account_m();

    }

    public function index()
    {
        include("views/v_head.php");
        include("views/v_index.php");
        include("views/v_foot.php");
    }
}