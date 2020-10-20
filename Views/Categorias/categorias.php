<?php headerTienda($data); ?>

<div>
    <div class="wrap">
        <h1>Escoge un producto</h1>
        <div class="store-wrapper">
            <div class="category_list">
                <a href="#" class="category_item" category="all">Todo</a>
            <?php
                include('php/conexionProductos.php');
                $resultadoCat = $conexion->query("SELECT * FROM categorias;") or die($conexion->error);
                while ($fila = mysqli_fetch_array($resultadoCat)) {
                ?>
                <a href="#" class="category_item" category="<?= $fila['nombre_categorias'];?>"> <?= $fila['nombre_categorias'];?> </a>
                <?php }?>
            </div>
            <section class="products-list">
                <?php
                include('php/conexionProductos.php');
                $resultado = $conexion->query("SELECT * FROM productos
                INNER JOIN categorias ON categorias_idcategorias=idcategorias;") or die($conexion->error);
                while ($file = mysqli_fetch_array($resultado)) {
                ?>
                <div class="product-item" category="<?= $file['nombre_categorias'];?>">
                    <img src="images/laptop_hp.jpg" alt="">
                    <a href="<?= base_url() ?>/shop_single?id=<?= $file['idproductos'];?>"><?= $file['nombre_producto']; ?></a>
                </div>
                <?php }?>
            </section>
        </div>
    </div>
</div>

<?php footerTienda($data); ?>