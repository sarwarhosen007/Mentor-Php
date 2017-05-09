<?php

$jsonWorkshopSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Workshop'");

$WorkshopSubtitle = json_decode($jsonWorkshopSubtitleString);

$jsonWorkshopDataString = getJSONFromDB("select * from workshop where status='on'");
$WorkshopData = json_decode($jsonWorkshopDataString);

 ?>

<!--work-shop-->
    <section id="work-shop" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="header-section text-center">
            <h2>Upcoming Workshop</h2>
            <p><?php echo $WorkshopSubtitle[0]->subtitle; ?></p>
            <hr class="bottom-line">
          </div>
          <?php for ($i=0; $i <sizeof($WorkshopData); $i++) {  ?>
          
          <div class="col-md-4 col-sm-6">
            <div class="service-box text-center">
              <div class="icon-box">
                <i class="fa <?php echo $WorkshopData[$i]->icon; ?> color-green"></i>
              </div>
              <div class="icon-text">
                <h4 class="ser-text"><?php echo $WorkshopData[$i]->title; ?></h4>
              </div>
            </div>
          </div>
           <?php } ?>
           
        </div>
      </div>
    </section>
    <!--/ work-shop-->