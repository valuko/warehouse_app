<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Warehouse Management App!</h1>

        <p class="lead">Welcome to the Warehouse Management App.</p>

        <p><a class="btn btn-lg btn-success" href="site/login">Login Here</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Employees</h2>

                <p>Manage your employees in one simple click. Create more employees, remove undesired accounts and change account details</p>

                <p><a class="btn btn-default" href="employee">Employees &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Products</h2>

                <p>Manage your Warehouse products here. Create more products, assign the products to multiple categories and Add images to the products</p>

                <p><a class="btn btn-default" href="product/">Products &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Categories</h2>

                <p>Manage your desired categories here. Create more and remove existing categories</p>

                <p><a class="btn btn-default" href="category/">Categories &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
