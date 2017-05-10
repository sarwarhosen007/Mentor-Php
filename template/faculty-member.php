<?php

$jsonFaculitySubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Faculty'");

$FaculitySubtitle = json_decode($jsonFaculitySubtitleString);

$jsonFaculityDataString = getJSONFromDB("select * from faculty where status='on'");
$FaculityData = json_decode($jsonFaculityDataString);

 ?>
<!--Faculity member-->
    <section id="faculity-member" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="header-section text-center">
            <h2>Meet Our Faculty Member</h2>
            <p><?php echo $FaculitySubtitle[0]->subtitle; ?></p>
            <hr class="bottom-line">
          </div>
          <?php for ($i=0; $i <sizeof($FaculityData); $i++) {  ?>
          <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="pm-staff-profile-container" >
              <div class="pm-staff-profile-image-wrapper text-center">
                <div class="pm-staff-profile-image">
                  <img src="admin/<?php echo $FaculityData[$i]->image_url; ?>" alt="" style="height: 151px; width: 151px;" class="img-thumbnail img-circle" />
                </div>   
              </div>                                
              <div class="pm-staff-profile-details text-center">  
                <p class="pm-staff-profile-name"><?php echo $FaculityData[$i]->name; ?></p>
                <p class="pm-staff-profile-title"><?php echo $FaculityData[$i]->position; ?></p>
                
                <p class="pm-staff-profile-bio"><?php echo $FaculityData[$i]->details; ?> </p>
              </div>     
            </div>
          </div>
          <?php } ?>      
        </div>
      </div>
    </section>
    <!--/ Faculity member-->