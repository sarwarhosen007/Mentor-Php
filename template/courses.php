<?php

$jsonCoursesSubtitleString = getJSONFromDB("select * from section_subtitle where sectionName ='Courses'");

$CoursesSubtitle = json_decode($jsonCoursesSubtitleString);

$jsonCoursesDataString = getJSONFromDB("select * from courses where status='on'");
$CoursesData = json_decode($jsonCoursesDataString);

 ?>
<!--Courses-->
    <section id ="courses" class="section-padding">
      <div class="container">
        <div class="row">
          <div class="header-section text-center">
            <h2>Courses</h2>
            <p><?php echo $CoursesSubtitle[0]->subtitle; ?></p>
            <hr class="bottom-line">
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row">
        <?php for ($i=0; $i <sizeof($CoursesData); $i++) {  ?>
          <div class="col-md-4 col-sm-6 padleft-right">
            <figure class="imghvr-fold-up">
              <img src="admin/<?php echo $CoursesData[$i]->image_url; ?>" class="img-responsive">
              <figcaption>
                  <h3><?php echo $CoursesData[$i]->title; ?></h3>
                  <p><?php echo $CoursesData[$i]->details; ?></p>
              </figcaption>
              <a href="#"></a>
            </figure>
          </div>
          <?php } ?>   
        </div>
      </div>
    </section>
    <!--/ Courses-->