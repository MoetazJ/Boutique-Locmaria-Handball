  

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
    <select class="form-control" name="choix">
      <option value="adulte">Taille Adulte</option>
      <option value="junior">Taille Junior</option>
    </select>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Sexe : </label>

    <select class="form-control" name="sexe">
      <option value="H">Homme</option>
      <option value="F">Femme</option>
    </select>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Taille:</label>
        <select class="form-control" name="size">
            <?php foreach ($size as $taille) { ?>
                <option value="<?php echo $taille['size_name']; ?>"><?php echo $taille['size_name']; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="form-group">
        <label for="exampleFormControlSelect1">Couleur:</label>
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

      
