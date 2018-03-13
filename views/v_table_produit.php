<div class="row">
<a href="<?php echo BASE_URL?>app.php/Produit/creerProduit/"> Ajouter un produit </a>
<table>
<caption>Recapitulatifs des produits</caption>
<thead>
<tr><th>nom</th><th>type</th><th>id</th><th>prix</th><th>photo</th>
<?php //if(isset($_SESSION['droit']) and $_SESSION['droit']=='DROITadmin'): ?>
<th>opération</th>
<?php //endif;?>
</tr>
</thead>
<tbody>
<?php if(isset($data[0])): ?>
	<?php foreach ($data as $value): ?>
		<tr><td>
		<?php echo $value['nom']; ?>
		</td><td>
		<?= $value['libelle']; ?>
		</td><td>
		<?php echo($value['id']); ?>
		</td><td>
		<?= helperViewPrix::view($value['prix']); ?>
		</td><td>
		<?= $value['photo']; ?>
		</td><td>
		<img style="width:40px;height:40px" src="<?php echo BASE_URL?>images/<?= $value['photo']; ?>" alt="image de <?= $value['libelle']; ?>" >
		</td>
		<td>
			<a href="<?php echo BASE_URL?>app.php/Produit/modifierProduit/<?= $value['id']; ?>">modifier</a>
			<a href="<?php echo BASE_URL?>app.php/Produit/supprimerProduit/<?= $value['id']; ?>">supprimer</a>
		</td>
		</tr>
<tbody>
</table>
</div>