  

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container" data-aos="fade-up">

        

              
        <img src="<?php echo base_url();?>style/img/<?php echo $produit->pdt_img?>" alt="" style="display:block; margin:auto;">
        <h3><?php echo $produit->pdt_nom ?>   </h3>
        <br>
        <?php echo $produit->pdt_description; 
            echo "<br>";
            echo ".<br>";
                    

        ?>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn btn-secondary active">
            <input type="radio" name="options" id="option1" autocomplete="off" checked> S
          </label>
          <label class="btn btn-secondary">
            <input type="radio" name="options" id="option2" autocomplete="off"> M
          </label>
          <label class="btn btn-secondary">
            <input type="radio" name="options" id="option3" autocomplete="off"> L
          </label>
        </div>
        <?php 
          echo "<br>";
                    echo "<br>";

          echo "Prix Adulte : "; echo $produit->pdt_prix;
          echo "€<br>";
          echo "<br>";
          echo "<br>";

        ?>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label class="btn btn-secondary active">
          <input type="radio" name="Sjr" id="Sjr" autocomplete="off" checked> S
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="Mjr" id="Mjr" autocomplete="off"> M
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="Ljr" id="Ljr" autocomplete="off"> L
        </label>
        </div>
      <?php
          echo "<br>";
          echo "<br>";

          echo "Prix Junior : "; echo $produit->pdt_prixjr;
          echo "€";

        ?>
      </div>


    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->