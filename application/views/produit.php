  

<!-- ======= Portfolio Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container" data-aos="fade-up">

        

              
    <form method="post" action="<?php echo base_url() ?>/products/ajout_panier">
    <img src="<?php echo base_url();?>style/img/<?php echo $produit->pdt_img?>" alt="" style="display:block; margin:auto;">
    <h3><?php echo $produit->pdt_nom ?>   </h3>
    <br>
    <?php echo $produit->pdt_description; 
        echo "<br>";
        echo ".<br>";
    ?>
    <div class="btn-group btn-group-toggle" data-toggle="buttons">
      <label class="btn btn-secondary active">
        <input type="radio" name="prix" value="S" autocomplete="off" checked> S
      </label>
      <label class="btn btn-secondary">
        <input type="radio" name="prix" value="M" autocomplete="off"> M
      </label>
      <label class="btn btn-secondary">
        <input type="radio" name="prix" value="L" autocomplete="off"> L
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
        <input type="radio" name="prixjr" value="S" autocomplete="off" checked> S
      </label>
      <label class="btn btn-secondary">
        <input type="radio" name="prixjr" value="M" autocomplete="off"> M
      </label>
      <label class="btn btn-secondary">
        <input type="radio" name="prixjr" value="L" autocomplete="off"> L
      </label>
    </div>
    <?php
      echo "<br>";
      echo "<br>";
      echo "Prix Junior : "; echo $produit->pdt_prixjr;
      echo "€";
      echo "<br>";
      echo "<br>";
    ?>
   

    <div class="form-group">
    <label for="exampleFormControlSelect1">Couleur</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option><?php echo $color->col_clr; ?></option>
      <option><?php echo $color->col_clr; ?></option>
      <option><?php echo $color->col_clr; ?></option>
      
    </select>
  </div>
    <br>
    <br>
    <br>
  
    <button type="submit" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true" color="yellow">Ajouter au panier</button>  
  </form>

  </section><!-- End Portfolio Details Section -->

</main><!-- End #main -->

      
