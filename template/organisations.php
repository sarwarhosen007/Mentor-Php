<?php 

 $jsonFeatureSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Education'");

$EducationSubtitle = json_decode($jsonFeatureSubtitleString);

$jsonEducationDataString = getJSONFromDB("select * from education where status='on'");
$EducationData = json_decode($jsonEducationDataString);

?>


<!--Organisations-->
    <section id ="organisations" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="col-md-6">

            <?php for ($i=0; $i <sizeof($EducationData); $i++) { ?>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">         
              <div class="orga-stru">
                <h3><?php echo $EducationData[$i]->percent; ?>%</h3>
                <p><?php echo $EducationData[$i]->title; ?></p>
                <i class="fa <?php echo $EducationData[$i]->icon; ?>"></i>
              </div>  
            </div>
           <?php } ?>

          </div>
          <div class="col-md-6">
            <div class="detail-info">
              <hgroup>
                <h3 class="det-txt"> Is inclusive quality education affordable?</h3>
                <h4 class="sm-txt">(Revised and Updated for <?php echo date("Y"); ?>)</h4>
              </hgroup>
              <p class="det-p"><?php echo $EducationSubtitle[0]->subtitle; ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--/ Organisations-->