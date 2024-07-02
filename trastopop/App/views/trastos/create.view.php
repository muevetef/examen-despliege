<?php loadPartial('head') ?>
<?php loadPartial('navbar') ?>
<?php loadPartial('top-banner') ?>

<?php
// inspect($errors);
?>
<!-- Publicar un Artículo Formulario -->
<section class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Publicar un Anuncio</h2>
        <!-- <div class="message bg-red-100 p-3 my-3">This is an error message.</div>
        <div class="message bg-green-100 p-3 my-3">
          This is a success message.
        </div> -->
        <form method="POST" action="/trasto">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Información del Artículo
            </h2>
            <div class="mb-4">
                <input type="text" name="title" value="<?= $trastos['title'] ?? '' ?>" placeholder="Título del Artículo" class="w-full px-4 py-2 border rounded focus:outline-none" />
                <?php if (isset($errors['title'])) : ?>
                    <div class="message bg-red-100 p-3 my-3"><?= $errors['title'] ?></div>
                <?php endif ?>
            </div>
            <div class="mb-4">
                <textarea name="description" placeholder="Descripción del Artículo" class="w-full px-4 py-2 border rounded focus:outline-none"><?= $trastos['description'] ?? '' ?></textarea>
                <?php if (isset($errors['description'])) : ?>
                    <div class="message bg-red-100 p-3 my-3"><?= $errors['description'] ?></div>
                <?php endif ?>
            </div>
            <div class="mb-4">
                <textarea name="details" placeholder="Detalles del Artículo" class="w-full px-4 py-2 border rounded focus:outline-none"><?= $trastos['details'] ?? '' ?></textarea>
            </div>
            <div class="mb-4">
                <input type="text" name="price" value="<?= $trastos['price'] ?? '' ?>" placeholder="Precio" class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input type="text" name="condition" value="<?= $trastos['condition'] ?? '' ?>" placeholder="Condición" class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input type="text" name="category" value="<?= $trastos['category'] ?? '' ?> " placeholder="Categoría" class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input type="text" name="tags" value="<?= $trastos['tags'] ?? '' ?>" placeholder="Etiquetas" class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Información de Contacto y Ubicación
            </h2>
            <div class="mb-4">
                <input type="text" name="seller" value="<?= $trastos['seller'] ?? '' ?>" placeholder="Nombre del Vendedor" class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input type="text" name="address" value="<?= $trastos['address'] ?? '' ?>" placeholder="Dirección" class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input type="text" name="city" value="<?= $trastos['city'] ?? '' ?>" placeholder="Ciudad" class="w-full px-4 py-2 border rounded focus:outline-none" />
                <?php if (isset($errors['city'])) : ?>
                    <div class="message bg-red-100 p-3 my-3"><?= $errors['city'] ?></div>
                <?php endif ?>
            </div>
            <div class="mb-4">
                <input type="text" name="state" value="<?= $trastos['state'] ?? '' ?>" placeholder="Estado" class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input type="text" name="phone" value="<?= $trastos['phone'] ?? '' ?>" placeholder="Teléfono" class="w-full px-4 py-2 border rounded focus:outline-none" />
            </div>
            <div class="mb-4">
                <input type="email" name="email" value="<?= $trastos['email'] ?? '' ?>" placeholder="Correo Electrónico para Contacto" class="w-full px-4 py-2 border rounded focus:outline-none" />
                <?php if (isset($errors['email'])) : ?>
                    <div class="message bg-red-100 p-3 my-3"><?= $errors['email'] ?></div>
                <?php endif ?>
            </div>
            <button class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Guardar
            </button>
            <a href="/" class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none">
                Cancelar
            </a>
        </form>
    </div>
</section>

<?php loadPartial('footer') ?>