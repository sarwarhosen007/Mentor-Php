<?php 

 $jsonFeatureSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Features'");

$FeaturesSubtitle = json_decode($jsonFeatureSubtitleString);

$jsonFeatureDataString = getJSONFromDB("select * from features where status='on'");
$FeaturesData = json_decode($jsonFeatureDataString);

?>

<!--Feature-->
    <section id ="feature" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="header-section text-center">
            <h2>Features</h2>
            <p><?php echo $FeaturesSubtitle[0]->subtitle; ?></p>
            <hr class="bottom-line">
          </div>
          <div class="feature-info">
          <?php for ($i=0; $i <sizeof($FeaturesData); $i++) { ?>
            <div class="fea">
              <div class="col-md-4">
                <div class="heading pull-right">
                  <h4><?php echo $FeaturesData[$i]->title; ?></h4>
                  <p>Donec et lectus bibendum dolor dictum auctor in ac erat. Vestibulum egestas sollicitudin metus non urna in eros tincidunt convallis id id nisi in interdum.</p>
                </div>
                <div class="fea-img pull-left">
                  <i class="fa fa-css3"></i>
                </div>
              </div>
            </div>
            <?php } ?>

        </div>
        </div>
      </div>
    </section>
    <!--/ feature-->