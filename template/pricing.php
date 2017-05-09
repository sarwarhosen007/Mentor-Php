<?php

$jsonPricesSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Prices'");

$PricesSubtitle = json_decode($jsonFaculitySubtitleString);

$jsonPricesDataString = getJSONFromDB("select * from prices where status='on'");
$PricesData = json_decode($jsonPricesDataString);

 ?><!--Pricing-->
    <section id ="pricing" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="header-section text-center">
            <h2>Our Pricing</h2>
            <p><?php echo $PricesSubtitle[0]->subtitle; ?></p>
            <hr class="bottom-line">
          </div>
          <?php for ($i=0; $i <sizeof($PricesData); $i++) { ?> 
          <div class="col-md-4 col-sm-4">
            <div class="price-table">
              <!-- Plan  -->
              <div class="pricing-head">
                <h4><?php echo $PricesData[$i]->plan_name; ?></h4>
                <span class="fa fa-usd curency"></span> <span class="amount"><?php echo $PricesData[$i]->price; ?></span> 
              </div>
          
              <!-- Plean Detail -->
              <div class="price-in mart-15">
                <a href="#" class="btn btn-bg green btn-block">PURCHACE</a> 
              </div>
            </div>
          </div>
          <?php } ?> 
           
        </div>
      </div>
    </section>
    <!--/ Pricing-->