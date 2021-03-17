<?php

namespace layouts;


/**
 * Class MainLayout
 * @package layouts
 */
class MainLayout
{
    /**
     * @return string
     */
    public function drawNavbar()
    {
        return '<header class="navbar">
                    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
                        <a class="navbar-brand" href="/">NetPeak</a>
                        <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                            </li>
                             <li class="nav-item">
                                <a class="nav-link" href="./AddProduct.php">Add Product</a>
                            </li>
                        </ul>
                    </div>
                    </nav>
                    </header>
                    <br><br><br>';
    }

}
