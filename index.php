<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<?php include('header.php'); ?>
<main class="main-body">
<div class="abt-wrap">

<h2 class ="txt">ABOUT US</h2>
<p class ="txt" >
    Beautimania offers a comprehensive selection of makeup, fragrance, and accessories tailored for both men and women. Our diverse range 
    encompasses an array of renowned brands, ensuring top-quality products that cater to various preferences and needs. Whether you're 
    seeking the latest trends in cosmetics, signature scents, or stylish accessories, 
    Beautimania provides an extensive collection to suit every individual style and preference. With a commitment to excellence and 
    customer satisfaction, we strive to enhance your beauty and grooming experience with our curated selection of premium products.
</p>
</div>
<div class="container">
<div class="slideshow"></div>

</div>
<div class="product-wrap">
<div class="product-head">
    <h2 class ="txt">
        OUR PRODUCTS
    </h2>
</div>
<div class="card-wrapper">
    <section class="card">
      <!-- Lipstick img link: https://img.freepik.com/free-vector/new-lip-care-makeup-luxury-brand_1284-18942.jpg?w=740&t=st=1707965048~exp=1707965648~hmac=1339a64a1f399e42c0f5b24164cdde9f190fb4e1420d93a79dc956780ba5fb66 -->
        <img src="img/Lipsticks.jpg" alt="Lipsticks" style="width:100%">
        <div class="container">
          <h4 class ="txt"><b>LIPSTICKS</b></h4>
          <p class ="txt">Lipsticks aren't just makeup; they're a statement. Whether matte, glossy, or somewhere in between, they speak volumes about your style and personality</p>
        </div>
      </section>
      <section class="card">
        <!-- perfume img link: https://scontent.fyzd1-3.fna.fbcdn.net/v/t1.18169-9/28279341_1380575108739527_2058831077939877708_n.jpg?_nc_cat=101&ccb=1-7&_nc_sid=be3454&_nc_ohc=0cll0fVPOsIAX9Fi8II&_nc_ht=scontent.fyzd1-3.fna&oh=00_AfDa2FZMEtzrqcTIV7SEaCKt39oVzyagCkSM0VwBIhcmSg&oe=65F4E960 -->
        <img src="img/perfume.jpg" alt="perfume" style="width:100%">
        <div class="container">
          <h4 class ="txt"><b>FRAGRANCE</b></h4>
          <p class ="txt">Step into a world of sensory delight with fragrance, where each note unfolds like a love letter to the senses, igniting passion and enchantment with every breath.</p>
        </div>
      </section>
      <section class="card">                          
        <!-- jewelery img link: https://www.paperboatcreative.com/wp-content/uploads/2018/10/diamond-in-black-background-1024x692.jpg -->
        <img src="img/jewelery.png" alt="jewelery" style="width:100%">
        <div class="container">
          <h4 class ="txt"><b>JEWELERY</b></h4>
          <p class ="txt">Like tiny treasures that whisper stories of elegance and sophistication, jewelry holds the power to elevate any outfit and captivate every gaze.</p>
        </section>
      </div>
    
</div>

</div>

<div class="why-shop-wrapper">
<div class="shop-wrp">
<div>
<h2 class="txt">WHY SHOP WITH US</h2>
</div>
<div class="shop-card-wrapper">
  <div>
      <section class="shop-card">
          <div class="shop-icon">
            <i class="fa fa-truck txt fa-3x" aria-hidden="true"></i>
          </div>
          
          
          <div class="shop-container">

            <h4 class =" shop-head txt"><b>Free Shipping</b></h4>
            <p class ="txt">Free carbon neutral shipping across Canada.</p>
          </div>
        </section>
        <section class="shop-card">
          <div class="shop-icon">
            <i class="fa fa-star txt fa-3x" aria-hidden="true"></i>
          </div>
          
          
          <div class="shop-container">
            
            <h4 class =" shop-head txt"><b>Loyalty Program</b></h4>
            <p class ="txt">Receive 5% back in Beautimania Points across Canada.</p>
          </div>
        </section>
  </div>

<div>
  <section class="shop-card">
      <div class="shop-icon">
        <i class="fa fa-gift txt fa-3x" aria-hidden="true"></i>
      </div>
      
      
      <div class="shop-container">

        <h4 class =" shop-head txt"><b>Free Samples</b></h4>
        <p class ="txt">Receive a mixture of samples with all orders</p>
      </div>
    </section>
    <section class="shop-card">
      <div class="shop-icon">
        <i class="fa fa-check-circle txt fa-3x" aria-hidden="true"></i>
      </div>
      
      
      <div class="shop-container">

        <h4 class =" shop-head txt"><b>Authorized</b></h4>
        <p class ="txt">Authorized retailer for all the brands we offer.</p>
      </div>
    </section>
</div>
</div>

</div>
</div>

</main>
<?php include('footer.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/about_js.js"></script>
