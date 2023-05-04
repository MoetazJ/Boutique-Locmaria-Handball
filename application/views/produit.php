  

<!-- ======= Portfolio Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container" data-aos="fade-up">
         
    <form method="post" action="<?php echo base_url() ?>index.php/products/choix_variants/<?php echo $produit->pdt_id ?>">
    <img src="<?php echo base_url();?>style/img/<?php echo $produit->pdt_img?>" alt="" style="display:block; margin:auto;">
    <h3><?php echo $produit->pdt_nom ?>   </h3>
    <br>
    <?php echo $produit->pdt_description; 
        echo "<br>";
        echo ".<br>";
    ?>
    <div class="form-group">
        <label for="exampleFormControlSelect1">Tailles adultes (NULL si vous voulez commandez la taille junior)</label>
        <select class="form-control" id="exampleFormControlSelect1" name="size">
            <?php foreach ($size as $taille) { ?>
                <option value="<?php echo $taille['size_name']; ?>"><?php echo $taille['size_name']; ?></option>
            <?php } ?>
            <option value="NULL">NULL</option>

        </select>
    </div>
    <?php 
      echo "Prix Adulte : "; echo $produit->pdt_prix;
      echo "€<br>";
      echo "<br>";
    ?>
    
    <div class="form-group">
        <label for="exampleFormControlSelect1">Tailles juniors (NULL si vous voulez commandez la taille adulte)</label>
        <select class="form-control" id="exampleFormControlSelect1" name="sizejr">
            <?php foreach ($size as $taille) { ?>
                <option value="<?php echo $taille['size_name']; ?>"><?php echo $taille['size_name']; ?></option>
            <?php } ?>
                        <option value="NULL">NULL</option>

        </select>
    </div>
   
    <?php
      
      echo "Prix Junior : "; echo $produit->pdt_prixjr;
      echo "€";
      echo "<br>";
      echo "<br>";

      $x=0;
    ?>
   

    <div class="form-group">
        <label for="exampleFormControlSelect1">Couleur</label>
        <select class="form-control" id="exampleFormControlSelect1" name="color">
            <?php foreach ($color as $clr) { ?>
                <option value="<?php echo $clr['color_name']; ?>"><?php echo $clr['color_name']; ?></option>
            <?php } ?>
        </select>
    </div>

    <br>
    
    <div class="form-group">
      <label for="quantity">Quantité :</label>
      <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1">
    </div>
    <br>
  
    <button type="submit" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true" color="yellow">Ajouter au panier</button>  
  </form>

  </section><!-- End Portfolio Details Section -->

</main><!-- End #main -->

      
