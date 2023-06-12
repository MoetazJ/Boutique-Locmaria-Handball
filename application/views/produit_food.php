<!-- ======= Portfolio Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container" data-aos="fade-up">
    <form method="post" action="<?php echo base_url() ?>index.php/products/choix_variants/<?php echo $produit->pdt_id ?>">
      <img src="<?php echo base_url();?>style/img/<?php echo $produit->pdt_img?>" alt="" style="display:block; margin:auto;">
      <h3><?php echo $produit->pdt_nom ?></h3>
      <br>
      <h5><?php echo $prix->price; ?> € <h5>
        <br> 
      <?php echo $produit->pdt_description; ?>
      <br><br>

      <div class="form-group">
        <label>Taille : </label>
        <select class="form-control" name="taille">
            
          <option value="G">Grand</option>
          <option value="P">Petit</option>
        </select>
      </div>

      <div class="form-group">
        <label for="options">Choisissez la sauce:</label>
        <select class="custom-select" id="options" name="sauces[]" multiple>
          <option value="algerienne">Algerienne</option>
          <option value="ketchup">Ketchup</option>
          <option value="mayonnaise">Mayonnaise</option>
          <option value="sauce blanche">Sauce Blanche</option>
        </select>
      </div>

      <div class="form-group">
        <label for="quantity">Quantité :</label>
        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="1">
      </div>
      <br>

      <button type="submit" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true" color="yellow">Ajouter au panier</button>
    </form>
  </div>
</section><!-- End Portfolio Details Section -->
