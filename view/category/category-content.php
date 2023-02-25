<?php
global $home, $get_id, $start_from, $record_per_page;
$check = 0;
$get_product = $home->productOfCateChild($get_id, $start_from . " , " . $record_per_page);
foreach ($get_product as $result) {
  $image = product_upload($result['Product_Image']);
  $link =  linkProductDetail($result['Product_Slug']);
  $check++;
?>

  <div class="col-md-6">
    <div class="wow fadeInDown">
      <ul class="fashion_catgnav">
        <li>
          <div class="catgimg2_container"> <a href="<?php echo $link ?>"><img alt="<?php echo $result['Product_Name'] ?>" src="<?php echo $image; ?>"></a>
          </div>
          <h2 class="catg_titile"><a href="<?php echo $link ?>"><?php echo General::limitContent($result['Product_Name'], 15) ?></a>
          </h2>
          <div class="comments_box"> <span class="meta_date">14/12/2045</span> <span class="meta_comment"><a href="#">No Comments</a></span> <span class="meta_more"><a href="<?php echo $link ?>">Read
                More...</a></span> </div>
          <p><?php echo General::limitContent($result['Meta_Desc_Product'], 15) ?></p>
        </li>
      </ul>
    </div>
  </div>

<?php } ?>